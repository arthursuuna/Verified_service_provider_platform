<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .form-section {
            margin-bottom: 30px;
            padding: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .form-section h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        input[type="url"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .file-upload-section {
            background: #f8f9fa;
            border: 2px dashed #007bff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 15px 0;
        }

        .file-upload-section h4 {
            color: #007bff;
            margin-top: 0;
        }

        .file-requirements {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }

        .category-section {
            background: #e7f3ff;
            padding: 25px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #007bff;
        }

        .category-section h3 {
            margin-top: 0;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .category-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: background-color 0.3s;
        }

        .category-item:hover {
            background-color: #f0f8ff;
        }

        .category-item input[type="checkbox"] {
            margin-right: 12px;
            transform: scale(1.2);
        }

        .category-item label {
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
        }

        .submit-btn {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
            margin-top: 30px;
            transition: transform 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .info-box {
            background: #e7f3ff;
            border: 1px solid #007bff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #007bff;
        }

        .required {
            color: #dc3545;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .verification-note {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .status-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="<?= base_url() ?>" class="back-link">← Back to Home</a>

        <h1>Service Provider Registration</h1>
        <p class="subtitle">Join our verified network of professional service providers</p>

        <div class="info-box">
            <h3>Registration & Verification Process</h3>
            <p>Welcome to our professional service provider network. Here's what happens after registration:</p>
            <ul>
                <li><strong>Document Review:</strong> Our team reviews your uploaded verification documents</li>
                <li><strong>Status Updates:</strong> Track your application status (Pending → Verified → Active)</li>
                <li><strong>Subscription Required:</strong> Verified providers need an active subscription to appear publicly</li>
                <li><strong>Professional Visibility:</strong> Only verified and subscribed providers are visible to customers</li>
            </ul>
        </div>

        <div class="status-info">
            <h4>Provider Status Levels:</h4>
            <ul>
                <li><strong>Pending Verification:</strong> Application submitted, awaiting document review</li>
                <li><strong>Verified:</strong> Documents approved, ready for subscription</li>
                <li><strong>Suspended:</strong> Account temporarily inactive</li>
                <li><strong>Expired Subscription:</strong> Subscription renewal required</li>
            </ul>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('providers/register') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Business Information Section -->
            <div class="form-section">
                <h3>📊 Business Information</h3>

                <div class="form-group">
                    <label for="business_name">Business Name <span class="required">*</span></label>
                    <input type="text" id="business_name" name="business_name"
                        value="<?= old('business_name') ?>"
                        placeholder="Enter your business or company name" required>
                    <?php if (isset($validation) && $validation->hasError('business_name')): ?>
                        <div class="error"><?= $validation->getError('business_name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="owner_name">Owner/Manager Name <span class="required">*</span></label>
                    <input type="text" id="owner_name" name="owner_name"
                        value="<?= old('owner_name') ?>"
                        placeholder="Full name of business owner or manager" required>
                    <?php if (isset($validation) && $validation->hasError('owner_name')): ?>
                        <div class="error"><?= $validation->getError('owner_name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="location">Business Location/Service Area <span class="required">*</span></label>
                    <input type="text" id="location" name="location"
                        value="<?= old('location') ?>"
                        placeholder="e.g., Nairobi, Kenya or Multiple Counties" required>
                    <?php if (isset($validation) && $validation->hasError('location')): ?>
                        <div class="error"><?= $validation->getError('location') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="form-section">
                <h3>📞 Contact Information</h3>

                <div class="form-group">
                    <label for="email">Business Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email"
                        value="<?= old('email') ?>"
                        placeholder="business@company.com" required>
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <div class="error"><?= $validation->getError('email') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="phone">Business Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone"
                        value="<?= old('phone') ?>"
                        placeholder="+254 xxx xxx xxx" required>
                    <?php if (isset($validation) && $validation->hasError('phone')): ?>
                        <div class="error"><?= $validation->getError('phone') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="website">Business Website (Optional)</label>
                    <input type="url" id="website" name="website"
                        value="<?= old('website') ?>"
                        placeholder="https://yourbusiness.com">
                    <?php if (isset($validation) && $validation->hasError('website')): ?>
                        <div class="error"><?= $validation->getError('website') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Service Information Section -->
            <div class="form-section">
                <h3>🛠️ Service Information</h3>

                <div class="form-group">
                    <label for="service_description">Service Description <span class="required">*</span></label>
                    <textarea id="service_description" name="service_description"
                        placeholder="Describe your services, experience, qualifications, and what makes your business unique. Include years of experience, certifications, and specializations." required><?= old('service_description') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('service_description')): ?>
                        <div class="error"><?= $validation->getError('service_description') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Service Categories Section -->
            <div class="category-section">
                <h3>🏷️ Service Categories <span class="required">*</span></h3>
                <p>Select one or more categories that best describe your services:</p>

                <?php if (isset($validation) && $validation->hasError('categories')): ?>
                    <div class="error"><?= $validation->getError('categories') ?></div>
                <?php endif; ?>

                <div class="category-grid">
                    <?php if (isset($serviceCategories) && !empty($serviceCategories)): ?>
                        <?php foreach ($serviceCategories as $category): ?>
                            <div class="category-item">
                                <input type="checkbox"
                                    id="category_<?= $category['id'] ?>"
                                    name="categories[]"
                                    value="<?= $category['id'] ?>"
                                    <?= in_array($category['id'], old('categories') ?? []) ? 'checked' : '' ?>>
                                <label for="category_<?= $category['id'] ?>"><?= esc($category['name']) ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No service categories available. Please contact administrator.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Documentation Upload Section -->
            <div class="form-section">
                <h3>📋 Verification Documents</h3>

                <div class="verification-note">
                    <strong>Document Verification Required:</strong> To maintain quality and trust, all service providers must submit verification documents before approval.
                </div>

                <div class="file-upload-section">
                    <h4>📄 Upload Verification Documents</h4>
                    <input type="file" id="verification_documents" name="verification_documents[]"
                        multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">

                    <div class="file-requirements">
                        <strong>Required Documents (at least one):</strong><br>
                        • Business registration certificate<br>
                        • Professional license or certification<br>
                        • Tax compliance certificate<br>
                        • Insurance documents<br>
                        • Portfolio or work samples<br><br>

                        <strong>File Requirements:</strong><br>
                        • Formats: PDF, JPG, PNG, DOC, DOCX<br>
                        • Maximum size: 5MB per file<br>
                        • Maximum files: 5 documents
                    </div>
                </div>

                <?php if (isset($validation) && $validation->hasError('verification_documents')): ?>
                    <div class="error"><?= $validation->getError('verification_documents') ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="submit-btn">
                📝 Submit Registration for Verification
            </button>
        </form>
    </div>
</body>

</html>