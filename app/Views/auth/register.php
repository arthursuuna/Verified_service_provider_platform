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
                            <p class="lead">Join Our Verified Platform</p>
                        </div>
                        <div class="brand-features">
                            <div class="feature-item">
                                <i class="fas fa-user-check"></i>
                                <h5>Easy Registration</h5>
                                <p>Quick and simple account creation process</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-search"></i>
                                <h5>Find Services</h5>
                                <p>Access verified service providers instantly</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-star"></i>
                                <h5>Rate & Review</h5>
                                <p>Share your experience and help others</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Registration Form -->
                <div class="col-lg-6 auth-form-side">
                    <div class="auth-form-content">
                        <div class="auth-form-header">
                            <h3>Create Account</h3>
                            <p>Join BLB to access verified service providers</p>
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

                        <!-- Registration Form -->
                        <form action="<?= base_url('auth/register') ?>" method="post" class="auth-form">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control <?= $validation->hasError('name') ? 'is-invalid' : '' ?>"
                                        id="name"
                                        name="name"
                                        value="<?= old('name') ?>"
                                        placeholder="Enter your full name"
                                        required>
                                    <?php if ($validation->hasError('name')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('name') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

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
                                <label for="phone" class="form-label">Phone Number <small class="text-muted">(Optional)</small></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel"
                                        class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>"
                                        id="phone"
                                        name="phone"
                                        value="<?= old('phone') ?>"
                                        placeholder="Enter your phone number">
                                    <?php if ($validation->hasError('phone')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('phone') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>"
                                            id="password"
                                            name="password"
                                            placeholder="Choose password"
                                            required>
                                        <?php if ($validation->hasError('password')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('password') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="password-strength mt-1">
                                        <small class="text-muted">Password strength: <span id="strengthText">Weak</span></small>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar" id="strengthBar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>"
                                            id="confirm_password"
                                            name="confirm_password"
                                            placeholder="Confirm password"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordRegister">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($validation->hasError('confirm_password')): ?>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('confirm_password') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input <?= $validation->hasError('terms') ? 'is-invalid' : '' ?>"
                                        type="checkbox"
                                        id="terms"
                                        name="terms"
                                        value="1"
                                        required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="<?= base_url('terms') ?>" target="_blank">Terms of Service</a>
                                        and <a href="<?= base_url('privacy') ?>" target="_blank">Privacy Policy</a>
                                    </label>
                                    <?php if ($validation->hasError('terms')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('terms') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>
                                Create Account
                            </button>
                        </form>

                        <div class="auth-divider">
                            <span>or</span>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Already have an account?</p>
                            <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-lg w-100 mt-2">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Sign In
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