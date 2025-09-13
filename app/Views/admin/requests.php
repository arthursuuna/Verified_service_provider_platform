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
                        <a class="nav-link" href="<?= base_url('admin/providers') ?>">
                            <i class="fas fa-users me-1"></i>Providers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/users') ?>">
                            <i class="fas fa-user-friends me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/requests') ?>">
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

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>
                        <i class="fas fa-file-alt text-primary me-2"></i>Manage Service Requests
                    </h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Service Requests</h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($requests)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Request ID</th>
                                            <th>Customer</th>
                                            <th>Provider</th>
                                            <th>Service Details</th>
                                            <th>Status</th>
                                            <th>Request Date</th>
                                            <th>Actions</th>
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
                                                    <span class="fw-bold"><?= esc($request['business_name']) ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <?php if (!empty($request['description'])): ?>
                                                            <span><?= esc(substr($request['description'], 0, 50)) ?>...</span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($request['location'])): ?>
                                                            <small class="text-muted">
                                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                                <?= esc($request['location']) ?>
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?=
                                                                            $request['status'] === 'New' ? 'primary' : ($request['status'] === 'Contacted' ? 'warning' : ($request['status'] === 'Completed' ? 'success' : 'secondary'))
                                                                            ?>">
                                                        <?= esc($request['status']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M j, Y g:i A', strtotime($request['created_at'])) ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#requestModal<?= $request['id'] ?>"
                                                            title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            title="Contact Customer">
                                                            <i class="fas fa-envelope"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Request Detail Modal -->
                                            <div class="modal fade" id="requestModal<?= $request['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-file-alt me-2"></i>
                                                                Request #<?= esc($request['id']) ?> Details
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Customer Name</label>
                                                                        <p class="form-control-plaintext"><?= esc($request['user_name']) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Customer Email</label>
                                                                        <p class="form-control-plaintext"><?= esc($request['user_email']) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Service Provider</label>
                                                                        <p class="form-control-plaintext"><?= esc($request['business_name']) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Status</label>
                                                                        <p class="form-control-plaintext">
                                                                            <span class="badge bg-<?=
                                                                                                    $request['status'] === 'New' ? 'primary' : ($request['status'] === 'Contacted' ? 'warning' : ($request['status'] === 'Completed' ? 'success' : 'secondary'))
                                                                                                    ?>">
                                                                                <?= esc($request['status']) ?>
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <?php if (!empty($request['location'])): ?>
                                                                    <div class="col-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-bold">Location</label>
                                                                            <p class="form-control-plaintext">
                                                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                                                <?= esc($request['location']) ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($request['description'])): ?>
                                                                    <div class="col-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-bold">Service Description</label>
                                                                            <p class="form-control-plaintext"><?= esc($request['description']) ?></p>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Request Date</label>
                                                                        <p class="form-control-plaintext"><?= date('F j, Y g:i A', strtotime($request['created_at'])) ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">
                                                                <i class="fas fa-envelope me-1"></i>Contact Customer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No service requests found</h5>
                                <p class="text-muted">Service requests will appear here once customers start requesting services.</p>
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