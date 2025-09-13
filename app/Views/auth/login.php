<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/auth.css') ?>" rel="stylesheet">
</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Left Side - Branding -->
                <div class="col-lg-6 auth-brand-side">
                    <div class="auth-brand-content">
                        <div class="brand-logo">
                            <div class="logo-placeholder">BLB</div>
                            <h2>Buganda Land Board</h2>
                            <p class="lead">Verified Service Providers Platform</p>
                        </div>
                        <div class="brand-features">
                            <div class="feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <h5>Trusted & Verified</h5>
                                <p>All service providers are verified by BLB</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-users"></i>
                                <h5>Quality Assurance</h5>
                                <p>BLB guarantees quality service delivery</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-handshake"></i>
                                <h5>Secure Connections</h5>
                                <p>Safe and secure service connections</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-lg-6 auth-form-side">
                    <div class="auth-form-content">
                        <div class="auth-form-header">
                            <h3>Welcome Back</h3>
                            <p>Sign in to your account to continue</p>
                        </div>

                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form action="<?= base_url('auth/login') ?>" method="post" class="auth-form">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>"
                                        id="email"
                                        name="email"
                                        value="<?= old('email') ?>"
                                        placeholder="Enter your email"
                                        required>
                                    <?php if ($validation->hasError('email')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>"
                                        id="password"
                                        name="password"
                                        placeholder="Enter your password"
                                        required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if ($validation->hasError('password')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="<?= base_url('auth/forgot-password') ?>" class="text-decoration-none">
                                    Forgot password?
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Sign In
                            </button>
                        </form>

                        <div class="auth-divider">
                            <span>or</span>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Don't have an account?</p>
                            <a href="<?= base_url('register') ?>" class="btn btn-outline-primary btn-lg w-100 mt-2">
                                <i class="fas fa-user-plus me-2"></i>
                                Create Account
                            </a>
                        </div>

                        <div class="auth-footer">
                            <div class="text-center">
                                <a href="<?= base_url('/') ?>" class="text-muted text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Homepage
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/auth.js') ?>"></script>
</body>

</html>