<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-shield-alt me-2"></i>BLB Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin') ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/providers') ?>">
                            <i class="fas fa-users me-1"></i>Providers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/users') ?>">
                            <i class="fas fa-user-friends me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/requests') ?>">
                            <i class="fas fa-file-alt me-1"></i>Requests
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><?= esc(session()->get('user_name')) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('user/profile') ?>">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/providers') ?>">Providers</a></li>
                                <li class="breadcrumb-item active"><?= esc($provider['business_name']) ?></li>
                            </ol>
                        </nav>
                        <h1>
                            <i class="fas fa-user-tie text-primary me-2"></i>
                            <?= esc($provider['business_name']) ?>
                        </h1>
                    </div>
                    <div>
                        <span class="badge bg-<?= $provider['status'] === 'Verified' ? 'success' : ($provider['status'] === 'Pending' ? 'warning' : 'danger') ?> fs-6">
                            <?= esc($provider['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Provider Information -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Provider Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Business Name</label>
                                    <p class="form-control-plaintext"><?= esc($provider['business_name']) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Contact Person</label>
                                    <p class="form-control-plaintext"><?= esc($provider['contact_person']) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <p class="form-control-plaintext"><?= esc($provider['email']) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <p class="form-control-plaintext"><?= esc($provider['phone']) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Physical Address</label>
                                    <p class="form-control-plaintext"><?= esc($provider['address'] ?? 'Not provided') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Website</label>
                                    <p class="form-control-plaintext">
                                        <?php if (!empty($provider['website'])): ?>
                                            <a href="<?= esc($provider['website']) ?>" target="_blank">
                                                <?= esc($provider['website']) ?>
                                                <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        <?php else: ?>
                                            Not provided
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Service Categories</label>
                                    <p class="form-control-plaintext">
                                        <?php if (!empty($provider['categories'])): ?>
                                            <?php foreach (explode(',', $provider['categories']) as $category): ?>
                                                <span class="badge bg-secondary me-1"><?= esc(trim($category)) ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">No categories assigned</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <p class="form-control-plaintext"><?= esc($provider['description'] ?? 'No description provided') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Registration Date</label>
                                    <p class="form-control-plaintext"><?= date('F j, Y g:i A', strtotime($provider['created_at'])) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Updated</label>
                                    <p class="form-control-plaintext"><?= date('F j, Y g:i A', strtotime($provider['updated_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions and Status -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if ($provider['status'] !== 'Verified'): ?>
                                <a href="<?= base_url('admin/verify-provider/' . $provider['id']) ?>"
                                    class="btn btn-success"
                                    onclick="return confirm('Are you sure you want to verify this provider?')">
                                    <i class="fas fa-check me-2"></i>Verify Provider
                                </a>
                            <?php endif; ?>

                            <?php if ($provider['status'] !== 'Suspended'): ?>
                                <a href="<?= base_url('admin/suspend-provider/' . $provider['id']) ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to suspend this provider?')">
                                    <i class="fas fa-ban me-2"></i>Suspend Provider
                                </a>
                            <?php endif; ?>

                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-envelope me-2"></i>Send Message
                            </button>

                            <a href="mailto:<?= esc($provider['email']) ?>" class="btn btn-outline-primary">
                                <i class="fas fa-at me-2"></i>Send Email
                            </a>
                        </div>

                        <hr>

                        <div class="text-center">
                            <h6 class="text-muted">Provider Statistics</h6>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-primary"><?= count($requests) ?></h4>
                                        <p class="text-muted small mb-0">Total Requests</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success"><?= count(array_filter($requests, function ($r) {
                                                                    return $r['status'] === 'Completed';
                                                                })) ?></h4>
                                    <p class="text-muted small mb-0">Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Requests -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Service Requests</h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($requests)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Request ID</th>
                                            <th>Customer</th>
                                            <th>Service Details</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requests as $request): ?>
                                            <tr>
                                                <td class="fw-bold">#<?= esc($request['id']) ?></td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold"><?= esc($request['user_name']) ?></span>
                                                        <small class="text-muted"><?= esc($request['user_email']) ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($request['description'])): ?>
                                                        <?= esc(substr($request['description'], 0, 50)) ?>...
                                                    <?php else: ?>
                                                        <span class="text-muted">No description</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?=
                                                                            $request['status'] === 'New' ? 'primary' : ($request['status'] === 'Contacted' ? 'warning' : ($request['status'] === 'Completed' ? 'success' : 'secondary'))
                                                                            ?>">
                                                        <?= esc($request['status']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M j, Y', strtotime($request['created_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No service requests found for this provider.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>