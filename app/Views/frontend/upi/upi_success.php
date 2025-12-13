<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>UPI Payment Success</title>
    <link rel="icon" href="<?= base_url('public/frontend/assets/images/favicon.png') ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h4>Payment Recorded Successfully!</h4>
        <p>Your UPI ID: <strong><?= esc($upi_id) ?></strong></p>
        <a href="<?= site_url('/') ?>" class="btn btn-primary">Go to Home</a>
    </div>
</div>
</body>
</html>
