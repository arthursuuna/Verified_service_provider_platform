<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Show login form
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->session->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }

        $data = [
            'title' => 'Login - Buganda Land Board',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function processLogin()
    {
        // Validation rules
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', [
                'validation' => $this->validator,
                'title' => 'Login - Buganda Land Board'
            ]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Attempt authentication
        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'user_type' => $user['type'],
                'isLoggedIn' => true
            ];

            $this->session->set($sessionData);

            // Handle remember me
            if ($remember) {
                $this->setRememberMeCookie($user['id']);
            }

            // Set success message
            $this->session->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');

            // Redirect based on user role
            return $this->redirectBasedOnRole();
        } else {
            // Authentication failed
            $this->session->setFlashdata('error', 'Invalid email or password.');
            return redirect()->to('/login');
        }
    }

    /**
     * Show registration form
     */
    public function register()
    {
        // Redirect if already logged in
        if ($this->session->get('isLoggedIn')) {
            return $this->redirectBasedOnRole();
        }

        $data = [
            'title' => 'Register - Buganda Land Board',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/register', $data);
    }

    /**
     * Process registration
     */
    public function processRegister()
    {
        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
            'email' => 'required|valid_email|max_length[190]|is_unique[users.email]',
            'phone' => 'permit_empty|max_length[50]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'terms' => 'required'
        ];

        $messages = [
            'name' => [
                'required' => 'Full name is required',
                'min_length' => 'Name must be at least 2 characters long'
            ],
            'email' => [
                'required' => 'Email address is required',
                'valid_email' => 'Please enter a valid email address',
                'is_unique' => 'This email is already registered'
            ],
            'password' => [
                'required' => 'Password is required',
                'min_length' => 'Password must be at least 8 characters long'
            ],
            'confirm_password' => [
                'required' => 'Please confirm your password',
                'matches' => 'Password confirmation does not match'
            ],
            'terms' => [
                'required' => 'You must accept the terms and conditions'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return view('auth/register', [
                'validation' => $this->validator,
                'title' => 'Register - Buganda Land Board'
            ]);
        }

        // Prepare user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password'),
            'type' => 'regular' // Default to regular user
        ];

        // Create user
        if ($this->userModel->createUser($userData)) {
            $this->session->setFlashdata('success', 'Registration successful! Please log in.');
            return redirect()->to('/login');
        } else {
            $this->session->setFlashdata('error', 'Registration failed. Please try again.');
            return view('auth/register', [
                'validation' => $this->validator,
                'title' => 'Register - Buganda Land Board'
            ]);
        }
    }

    /**
     * Admin registration (separate form with admin privileges)
     */
    public function adminRegister()
    {
        // Check if user is already an admin
        if (!$this->isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
        }

        $data = [
            'title' => 'Register Admin - Buganda Land Board',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/admin_register', $data);
    }

    /**
     * Process admin registration
     */
    public function processAdminRegister()
    {
        // Check if user is already an admin
        if (!$this->isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
        }

        // Validation rules (similar to regular registration)
        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
            'email' => 'required|valid_email|max_length[190]|is_unique[users.email]',
            'phone' => 'permit_empty|max_length[50]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/admin_register', [
                'validation' => $this->validator,
                'title' => 'Register Admin - Buganda Land Board'
            ]);
        }

        // Prepare admin data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password'),
            'type' => 'admin' // Admin user
        ];

        // Create admin user
        if ($this->userModel->createUser($userData)) {
            $this->session->setFlashdata('success', 'Admin user created successfully!');
            return redirect()->to('/admin/users');
        } else {
            $this->session->setFlashdata('error', 'Failed to create admin user. Please try again.');
            return view('auth/admin_register', [
                'validation' => $this->validator,
                'title' => 'Register Admin - Buganda Land Board'
            ]);
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        // Clear remember me cookie
        $this->clearRememberMeCookie();

        // Destroy session
        $this->session->destroy();

        $this->session->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/');
    }

    /**
     * Check if current user is admin
     */
    private function isAdmin(): bool
    {
        return $this->session->get('user_type') === 'admin';
    }

    /**
     * Redirect based on user role
     */
    private function redirectBasedOnRole()
    {
        if ($this->isAdmin()) {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/user/dashboard');
        }
    }

    /**
     * Set remember me cookie
     */
    private function setRememberMeCookie(int $userId)
    {
        $token = bin2hex(random_bytes(32));

        // Store token in database or cache (for production)
        // For now, we'll use a simple approach
        $cookieValue = base64_encode($userId . '|' . $token);

        $response = \Config\Services::response();
        $response->setCookie([
            'name' => 'remember_token',
            'value' => $cookieValue,
            'expire' => 30 * 24 * 60 * 60, // 30 days
            'secure' => $this->request->isSecure(),
            'httponly' => true
        ]);
    }

    /**
     * Clear remember me cookie
     */
    private function clearRememberMeCookie()
    {
        $response = \Config\Services::response();
        $response->deleteCookie('remember_token');
    }

    /**
     * Check remember me cookie and auto-login
     */
    public function checkRememberMe()
    {
        if ($this->session->get('isLoggedIn')) {
            return; // Already logged in
        }

        $request = \Config\Services::request();
        $rememberToken = $request->getCookie('remember_token');

        if ($rememberToken) {
            $decoded = base64_decode($rememberToken);
            $parts = explode('|', $decoded);

            if (count($parts) === 2) {
                $userId = (int)$parts[0];
                $token = $parts[1];

                // Verify token and get user (in production, verify against stored tokens)
                $user = $this->userModel->find($userId);

                if ($user) {
                    // Auto-login user
                    $sessionData = [
                        'user_id' => $user['id'],
                        'user_name' => $user['name'],
                        'user_email' => $user['email'],
                        'user_type' => $user['type'],
                        'isLoggedIn' => true
                    ];

                    $this->session->set($sessionData);
                }
            }
        }
    }
}
