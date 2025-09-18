<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Submitted Successfully</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }

        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }

        .message {
            font-size: 18px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .details-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }

        .details-box h3 {
            margin-top: 0;
            color: #495057;
        }

        .next-steps {
            background: #e7f3ff;
            border: 1px solid #007bff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }

        .next-steps h3 {
            margin-top: 0;
            color: #007bff;
        }

        .next-steps ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .next-steps li {
            margin-bottom: 8px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            color: white;
        }

        .reference-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 2px solid #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>Registration Submitted Successfully!</h1>

        <div class="message">
            Thank you for registering as a service provider with our platform. Your application has been received and is currently under review.
        </div>

        <?php if (isset($registrationId)): ?>
            <div class="reference-number">
                Reference Number: #SP<?= str_pad($registrationId, 6, '0', STR_PAD_LEFT) ?>
            </div>
        <?php endif; ?>

        <div class="details-box">
            <h3>Registration Details</h3>
            <p><strong>Business Name:</strong> <?= esc($businessName ?? 'N/A') ?></p>
            <p><strong>Owner Name:</strong> <?= esc($ownerName ?? 'N/A') ?></p>
            <p><strong>Email:</strong> <?= esc($email ?? 'N/A') ?></p>
            <p><strong>Phone:</strong> <?= esc($phone ?? 'N/A') ?></p>
            <p><strong>Location:</strong> <?= esc($location ?? 'N/A') ?></p>
            <p><strong>Status:</strong> <span style="color: #ffc107; font-weight: bold;">Pending Review</span></p>
        </div>

        <div class="next-steps">
            <h3>What happens next?</h3>
            <ul>
                <li><strong>Review Process:</strong> Our team will review your application within 2-3 business days</li>
                <li><strong>Verification:</strong> We may contact you for additional information or clarification</li>
                <li><strong>Approval Notification:</strong> You'll receive an email notification once your application is approved</li>
                <li><strong>Profile Setup:</strong> After approval, you can log in to complete your provider profile</li>
                <li><strong>Go Live:</strong> Your services will be visible to customers once approved</li>
            </ul>
        </div>

        <div style="margin-top: 30px;">
            <a href="<?= base_url() ?>" class="btn btn-primary">Return to Home</a>
            <a href="<?= base_url('providers/register') ?>" class="btn btn-secondary">Register Another Provider</a>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; font-size: 14px;">
            <p><strong>Need Help?</strong></p>
            <p>If you have any questions about your registration or the review process, please contact our support team.</p>
        </div>
    </div>
</body>

</html>