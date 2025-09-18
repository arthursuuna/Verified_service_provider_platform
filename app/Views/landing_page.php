<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buganda Land Board - Verified Service Providers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/landing.css') ?>" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="logo-placeholder me-2" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">BLB</div>
                <span class="fw-bold">Buganda Land Board</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#providers">Providers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="<?= base_url('login') ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <div class="hero-content text-white">
                        <h1 class="display-4 fw-bold mb-4">
                            Find <span class="text-warning">Verified</span> Service Providers
                        </h1>
                        <p class="lead mb-4">
                            Buganda Land Board guarantees quality and trust. Connect with verified professionals
                            for plumbing, surveying, construction, and agricultural services.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#services" class="btn btn-warning btn-lg px-4">
                                <i class="fas fa-search me-2"></i>Find Services
                            </a>
                            <a href="<?= base_url('providers/register') ?>" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-user-plus me-2"></i>Join as Provider.
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-stats">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-card text-center">
                                    <div class="stat-number"><?= number_format($verifiedProviders) ?></div>
                                    <div class="stat-label">Verified Providers</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center">
                                    <div class="stat-number"><?= number_format($activeProviders) ?></div>
                                    <div class="stat-label">Active Services</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center">
                                    <div class="stat-number"><?= count($categories) ?></div>
                                    <div class="stat-label">Service Categories</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center">
                                    <div class="stat-number">100%</div>
                                    <div class="stat-label">BLB Guaranteed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Categories Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-3">Our Service Categories</h2>
                    <p class="lead text-muted">
                        Choose from our comprehensive range of verified professional services
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="service-card h-100">
                            <div class="service-icon">
                                <?php
                                $icons = [
                                    'plumbing' => 'fas fa-wrench',
                                    'surveying' => 'fas fa-map-marked-alt',
                                    'construction' => 'fas fa-hard-hat',
                                    'farming' => 'fas fa-seedling'
                                ];
                                $icon = $icons[$category['slug']] ?? 'fas fa-cogs';
                                ?>
                                <i class="<?= $icon ?>"></i>
                            </div>
                            <div class="service-content">
                                <h5 class="service-title"><?= esc($category['name']) ?></h5>
                                <p class="service-description">
                                    Professional <?= strtolower(esc($category['name'])) ?> services verified by BLB
                                </p>
                                <a href="<?= base_url('services/' . $category['slug']) ?>" class="btn btn-primary btn-sm">
                                    View Providers <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Providers Section -->
    <?php if (!empty($featuredProviders)): ?>
        <section id="providers" class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="display-5 fw-bold mb-3">Featured Providers</h2>
                        <p class="lead text-muted">
                            Meet some of our top-rated verified service providers
                        </p>
                    </div>
                </div>
                <div class="row g-4">
                    <?php foreach (array_slice($featuredProviders, 0, 6) as $provider): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="provider-card h-100">
                                <div class="provider-header">
                                    <div class="provider-avatar">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="verified-badge">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Verified</span>
                                    </div>
                                </div>
                                <div class="provider-body">
                                    <h5 class="provider-name"><?= esc($provider['business_name']) ?></h5>
                                    <p class="provider-owner text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        <?= esc($provider['owner_name']) ?>
                                    </p>
                                    <?php if (!empty($provider['location'])): ?>
                                        <p class="provider-location text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <?= esc($provider['location']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (!empty($provider['categories'])): ?>
                                        <div class="provider-categories">
                                            <?php
                                            $categoryList = explode(',', $provider['categories']);
                                            foreach (array_slice($categoryList, 0, 2) as $cat):
                                            ?>
                                                <span class="badge bg-secondary me-1"><?= esc(trim($cat)) ?></span>
                                            <?php endforeach; ?>
                                            <?php if (count($categoryList) > 2): ?>
                                                <span class="badge bg-light text-dark">+<?= count($categoryList) - 2 ?> more</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="provider-footer">
                                    <a href="<?= base_url('provider/' . $provider['id']) ?>" class="btn btn-outline-primary btn-sm">
                                        View Profile
                                    </a>
                                    <a href="<?= base_url('request-service/' . $provider['id']) ?>" class="btn btn-primary btn-sm">
                                        Request Service
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= base_url('providers') ?>" class="btn btn-outline-primary btn-lg">
                        View All Providers <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- How It Works Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-3">How It Works</h2>
                    <p class="lead text-muted">
                        Simple steps to connect with verified service providers
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5>Browse Services</h5>
                        <p class="text-muted">
                            Explore our categories and find the service you need
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="fas fa-hand-pointer"></i>
                        </div>
                        <h5>Select Provider</h5>
                        <p class="text-muted">
                            Choose from verified providers with BLB guarantee
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card text-center">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5>Get Connected</h5>
                        <p class="text-muted">
                            BLB facilitates the connection and ensures quality service
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">About Buganda Land Board</h2>
                    <p class="lead mb-4">
                        The Buganda Land Board (BLB) is committed to ensuring quality and trust in service delivery.
                        Our platform connects you with verified professionals who meet our strict standards.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="feature-item">
                                <i class="fas fa-shield-alt text-primary mb-2"></i>
                                <h6>BLB Guaranteed</h6>
                                <small class="text-muted">Quality assurance</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item">
                                <i class="fas fa-users text-primary mb-2"></i>
                                <h6>Verified Providers</h6>
                                <small class="text-muted">Trusted professionals</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item">
                                <i class="fas fa-clock text-primary mb-2"></i>
                                <h6>Quick Response</h6>
                                <small class="text-muted">Fast connections</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item">
                                <i class="fas fa-star text-primary mb-2"></i>
                                <h6>Quality Service</h6>
                                <small class="text-muted">Rated providers</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.2);">
                            <div class="text-center">
                                <i class="fas fa-building mb-3" style="font-size: 3rem;"></i>
                                <div>Buganda Land Board</div>
                                <div style="font-size: 1rem; opacity: 0.8;">Quality Service Guarantee</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4">Ready to Get Started?</h2>
                    <p class="lead mb-4">
                        Join thousands of satisfied customers who trust BLB verified service providers
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#services" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-search me-2"></i>Find a Service
                        </a>
                        <a href="<?= base_url('contact') ?>" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-envelope me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="logo-placeholder me-2" style="width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.9rem;">BLB</div>
                        <span>&copy; <?= date('Y') ?> Buganda Land Board. All rights reserved.</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/landing.js') ?>"></script>
</body>

</html>