<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'password_hash',
        'type'
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
        'name' => 'required|min_length[2]|max_length[150]',
        'email' => 'required|valid_email|max_length[190]|is_unique[users.email,id,{id}]',
        'phone' => 'permit_empty|max_length[50]',
        'type' => 'required|in_list[admin,regular]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 2 characters long',
            'max_length' => 'Name cannot exceed 150 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'type' => [
            'required' => 'User type is required',
            'in_list' => 'Invalid user type'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password before saving to database
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }

        return $data;
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Verify user password
     */
    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Create new user with validation
     */
    public function createUser(array $userData): bool
    {
        // Set default type if not provided
        if (!isset($userData['type'])) {
            $userData['type'] = 'regular';
        }

        // Validate data
        if (!$this->validate($userData)) {
            return false;
        }

        // Insert user
        return $this->insert($userData) !== false;
    }

    /**
     * Authenticate user
     */
    public function authenticate(string $email, string $password): array|false
    {
        $user = $this->findByEmail($email);

        if ($user && $this->verifyPassword($password, $user['password_hash'])) {
            // Remove password hash from returned data
            unset($user['password_hash']);
            return $user;
        }

        return false;
    }

    /**
     * Get admins only
     */
    public function getAdmins()
    {
        return $this->where('type', 'admin')->findAll();
    }

    /**
     * Get regular users only
     */
    public function getRegularUsers()
    {
        return $this->where('type', 'regular')->findAll();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(int $userId): bool
    {
        $user = $this->find($userId);
        return $user && $user['type'] === 'admin';
    }

    /**
     * Update user profile
     */
    public function updateProfile(int $userId, array $data): bool
    {
        // Remove sensitive fields from profile update
        unset($data['password_hash'], $data['type'], $data['id']);

        return $this->update($userId, $data);
    }

    /**
     * Change user password
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): bool
    {
        $user = $this->find($userId);

        if (!$user || !$this->verifyPassword($currentPassword, $user['password_hash'])) {
            return false;
        }

        return $this->update($userId, ['password' => $newPassword]);
    }

    /**
     * Get user statistics
     */
    public function getStats(): array
    {
        $stats = [];
        $stats['total'] = $this->countAll();
        $stats['admins'] = $this->where('type', 'admin')->countAllResults(false);
        $stats['regular'] = $this->where('type', 'regular')->countAllResults(false);

        return $stats;
    }

    /**
     * Search users
     */
    public function searchUsers(string $search, string $type = null): array
    {
        $builder = $this->select('id, name, email, phone, type, created_at')
            ->groupStart()
            ->like('name', $search)
            ->orLike('email', $search)
            ->groupEnd();

        if ($type) {
            $builder->where('type', $type);
        }

        return $builder->findAll();
    }
}
