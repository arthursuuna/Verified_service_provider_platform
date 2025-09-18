<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceCategoryModel extends Model
{
    protected $table            = 'service_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'description',
        'icon',
        'is_active',
        'sort_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]|is_unique[service_categories.name,id,{id}]',
        'description' => 'permit_empty|max_length[500]',
        'icon' => 'permit_empty|max_length[100]',
        'is_active' => 'permit_empty|in_list[0,1]',
        'sort_order' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Category name is required',
            'min_length' => 'Category name must be at least 2 characters long',
            'max_length' => 'Category name cannot exceed 100 characters',
            'is_unique' => 'This category name already exists'
        ]
    ];

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get all active categories ordered by sort_order
     */
    public function getActiveCategories()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * Get category with provider count
     */
    public function getCategoriesWithProviderCount()
    {
        $builder = $this->db->table($this->table);
        $builder->select('service_categories.*, COUNT(psc.service_category_id) as provider_count');
        $builder->join('provider_service_categories psc', 'psc.service_category_id = service_categories.id', 'left');
        $builder->join('service_providers sp', 'sp.id = psc.service_provider_id AND sp.status = "approved"', 'left');
        $builder->where('service_categories.is_active', 1);
        $builder->groupBy('service_categories.id');
        $builder->orderBy('service_categories.sort_order', 'ASC');
        $builder->orderBy('service_categories.name', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Get category by slug/name
     */
    public function getCategoryBySlug(string $slug)
    {
        // Convert slug back to name format (replace dashes with spaces, capitalize)
        $name = ucwords(str_replace('-', ' ', $slug));

        return $this->where('name', $name)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Generate slug from category name
     */
    public function generateSlug(string $name): string
    {
        return strtolower(str_replace(' ', '-', trim($name)));
    }

    /**
     * Get categories for a specific provider
     */
    public function getProviderCategories(int $providerId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('service_categories.*');
        $builder->join('provider_service_categories psc', 'psc.service_category_id = service_categories.id');
        $builder->where('psc.service_provider_id', $providerId);
        $builder->where('service_categories.is_active', 1);
        $builder->orderBy('service_categories.name', 'ASC');

        return $builder->get()->getResultArray();
    }
}
