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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        input[type="url"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .category-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .category-section h3 {
            margin-top: 0;
            color: #333;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .category-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .category-item input[type="checkbox"] {
            margin-right: 10px;
        }

        .category-item label {
            margin-bottom: 0;
            font-weight: normal;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .info-box {
            background: #e7f3ff;
            border: 1px solid #007bff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #007bff;
        }

        .required {
            color: #dc3545;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
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
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="<?= base_url() ?>" class="back-link">← Back to Home</a>

        <h1>Service Provider Registration</h1>

        <div class="info-box">
            <h3>Registration Process</h3>
            <p>Thank you for your interest in joining our service provider network. After submitting your registration:</p>
            <ul>
                <li>Your application will be reviewed by our admin team</li>
                <li>You will receive an email notification once approved</li>
                <li>Only approved providers will be visible to customers</li>
                <li>Please ensure all information is accurate and complete</li>
            </ul>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('providers/register') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="business_name">Business Name <span class="required">*</span></label>
                <input type="text" id="business_name" name="business_name"
                    value="<?= old('business_name') ?>" required>
                <?php if (isset($validation) && $validation->hasError('business_name')): ?>
                    <div class="error"><?= $validation->getError('business_name') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="owner_name">Owner Name <span class="required">*</span></label>
                <input type="text" id="owner_name" name="owner_name"
                    value="<?= old('owner_name') ?>" required>
                <?php if (isset($validation) && $validation->hasError('owner_name')): ?>
                    <div class="error"><?= $validation->getError('owner_name') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email"
                    value="<?= old('email') ?>" required>
                <?php if (isset($validation) && $validation->hasError('email')): ?>
                    <div class="error"><?= $validation->getError('email') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span class="required">*</span></label>
                <input type="tel" id="phone" name="phone"
                    value="<?= old('phone') ?>" required>
                <?php if (isset($validation) && $validation->hasError('phone')): ?>
                    <div class="error"><?= $validation->getError('phone') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="location">Location/Service Area <span class="required">*</span></label>
                <input type="text" id="location" name="location"
                    value="<?= old('location') ?>"
                    placeholder="e.g., Nairobi, Kenya or Multiple Counties" required>
                <?php if (isset($validation) && $validation->hasError('location')): ?>
                    <div class="error"><?= $validation->getError('location') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="website">Website (Optional)</label>
                <input type="url" id="website" name="website"
                    value="<?= old('website') ?>"
                    placeholder="https://yourwebsite.com">
                <?php if (isset($validation) && $validation->hasError('website')): ?>
                    <div class="error"><?= $validation->getError('website') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Business Description <span class="required">*</span></label>
                <textarea id="description" name="description"
                    placeholder="Describe your services, experience, and what makes your business unique..." required><?= old('description') ?></textarea>
                <?php if (isset($validation) && $validation->hasError('description')): ?>
                    <div class="error"><?= $validation->getError('description') ?></div>
                <?php endif; ?>
            </div>

            <div class="category-section">
                <h3>Service Categories <span class="required">*</span></h3>
                <p>Select all services your business provides:</p>

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

            <button type="submit" class="submit-btn">Submit Registration</button>
        </form>
    </div>
</body>

</html>