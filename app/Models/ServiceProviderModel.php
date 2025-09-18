<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceProviderModel extends Model
{
    protected $table = 'service_providers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'business_name',
        'owner_name',
        'email',
        'phone',
        'location',
        'service_description',
        'website',
        'status',
        'is_subscribed',
        'verification_documents',
        'subscription_expires_at',
        'verified_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'business_name' => 'required|min_length[2]|max_length[200]',
        'owner_name' => 'required|min_length[2]|max_length[150]',
        'email' => 'required|valid_email|max_length[190]|is_unique[service_providers.email,id,{id}]',
        'phone' => 'required|max_length[50]',
        'location' => 'required|max_length[200]',
        'service_description' => 'required|min_length[10]|max_length[1000]',
        'website' => 'permit_empty|valid_url|max_length[255]',
        'status' => 'required|in_list[Pending Verification,Verified,Suspended,Expired Subscription]',
        'is_subscribed' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get verified providers with active subscriptions
     */
    public function getPublicProviders()
    {
        return $this->select('service_providers.*, 
                             MAX(CASE WHEN s.status="Active" AND CURRENT_DATE BETWEEN s.start_date AND s.end_date THEN 1 ELSE 0 END) as has_active_subscription')
            ->join('subscriptions s', 's.service_provider_id = service_providers.id', 'left')
            ->where('service_providers.status', 'Verified')
            ->groupBy('service_providers.id')
            ->having('has_active_subscription', 1)
            ->findAll();
    }

    /**
     * Get providers by status
     */
    public function getByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }

    /**
     * Get providers with their categories
     */
    public function getWithCategories($providerId = null)
    {
        $builder = $this->db->table('service_providers sp')
            ->select('sp.*, GROUP_CONCAT(sc.name) as categories')
            ->join('provider_service_categories psc', 'psc.provider_id = sp.id', 'left')
            ->join('service_categories sc', 'sc.id = psc.category_id', 'left')
            ->groupBy('sp.id');

        if ($providerId) {
            $builder->where('sp.id', $providerId);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}
