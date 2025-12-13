<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>UPI Payment</title>
    <link rel="icon" href="<?= base_url('public/frontend/assets/images/favicon.png') ?>"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upi-box {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .upi-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="upi-box">
        <div class="upi-icon">📲</div>
        <h3>Pay via UPI</h3>
        <p>Enter your UPI ID to proceed with payment</p>

        <form id="upiForm" action="<?= site_url('buy/upi_submit') ?>" method="post">
            <div class="mb-3">
                <input type="text" class="form-control" id="upi_id" name="upi_id" placeholder="example@upi" required>
            </div>
            
            <div class="mb-3">
                <h3>UPI QR for: <?= esc($pn) ?> — Rs.<?= esc($amount) ?></h3>
                <img src="<?= esc($qr_url) ?>" alt="UPI QR" width="250" height="250">
            </div>

            <button type="submit" class="btn btn-success w-100">Proceed to Pay</button>
        </form>

        <div class="mt-3">
            <button onclick="history.back()" class="btn btn-secondary w-100">Back to Payment Methods</button>
        </div>
    </div>
</div>

<script>
document.getElementById('upiForm').addEventListener('submit', function(e){
    // e.preventDefault();
    // alert("UPI payment interface clicked. Integration will be done later!");
});
</script>

</body>
</html>
