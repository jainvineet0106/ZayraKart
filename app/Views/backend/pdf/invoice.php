<?php
  foreach($admins as $admin){
    $cname = $admin['name'];
    $cemail = $admin['email'];
    $caddress = $admin['address'];
    $cmobile = $admin['mobile'];
  }
  foreach($orders as $order){
    $orderid = $order['orderid'];
    $buyproductid = explode('#@', $order['buyproductid']);
    $subtotal = $order['subtotal'];
    $packaging = $order['packaging'];
    $tax = $order['tax'];
    $total = $order['total'];
    $paymentmode = $order['paymentmode'];
    $paystatus = $order['paystatus'];
    $orderat = $order['orderat'];
  }
  foreach($customers as $customer){
    $customername = $customer['title'];
    $customermobile = $customer['mobile']; 
    $customeraddress = $customer['address']; 
    $customerpincode = $customer['pincode'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice - <?= $orderid;?></title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 10px;
      color: #333;
      margin: 0;
      padding: 0;
      background: #fff;
    }

    .invoice-container {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      padding: 10px;
      border: 1px solid #000;
    }

    .header-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    .header-table td {
      vertical-align: top;
      padding: 5px;
    }
    .company-info h1 {
      font-size: 18px;
      margin: 0;
      color: #000;
    }
    .company-info p {
      margin: 2px 0;
    }
    .logo {
      text-align: right;
    }
    .logo img {
      width: 120px;
    }

    .invoice-title {
      text-align: center;
      margin: 10px 0 15px 0;
    }
    .invoice-title h2 {
      margin: 0;
      font-size: 16px;
      text-transform: uppercase;
      color: #000;
    }
    .invoice-title p {
      margin: 3px 0;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    .info-table td {
      width: 50%;
      vertical-align: top;
      padding: 5px;
      border: 1px solid #ddd;
    }
    .info-table strong {
      display: block;
      margin-bottom: 3px;
    }

    table.items {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    .items th, .items td {
      border: 1px solid #000;
      padding: 8px;
      font-size: 12px;
    }
    .items th {
      background: #f0f0f0;
      font-weight: bold;
      text-align: left;
    }
    .items td.text-center { text-align: center; }
    .items td.text-right { text-align: right; }

    .totals {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    .totals td {
      padding: 5px 8px;
    }
    .totals tr td:first-child {
      text-align: right;
      font-weight: bold;
    }
    .totals tr td:last-child {
      text-align: right;
      width: 100px;
    }
    .grand-total td {
      font-size: 14px;
      font-weight: bold;
      border-top: 2px solid #000;
    }

    .payment-section {
      display: table;
      width: 100%;
      margin-top: 15px;
    }
    .payment-info {
      display: table-cell;
      vertical-align: top;
      width: 70%;
      font-size: 12px;
    }
    .qr-code {
      display: table-cell;
      text-align: right;
      vertical-align: top;
    }
    .qr-code img {
      width: 50px;
      height: 50px;
      border: 1px solid #000;
      padding: 5px;
    }

    .payment-status {
      padding: 3px 6px;
      border-radius: 5px;
      font-weight: bold;
      color: #fff;
    }
    .terms {
      font-size: 11px;
      border-top: 1px solid #000;
      padding-top: 8px;
      margin-top: 10px;
      line-height: 1.4;
    }
    ol {
      margin: 0;
      padding-left: 18px;
    }
  </style>
</head>
<body>
  <div class="invoice-container">

    <!-- Header -->
    <table class="header-table">
      <tr>
        <td class="company-info">
          <h1><?= $cname;?></h1>
          <p><?= $caddress;?></p>
          <p>Email: <?= $cemail;?></p>
          <p>Customer Care: +91 <?= $cmobile;?></p>
        </td>
        <td class="logo">
          <?php
          $path = FCPATH.'public/frontend/images/bg/Logo.png';
          $type = pathinfo($path, PATHINFO_EXTENSION);
          $data = file_get_contents($path);
          $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); 
          ?>
          <img src="<?= $base64;?>" alt="Company Logo">
        </td>
      </tr>
    </table>

    <!-- Invoice Title -->
    <div class="invoice-title">
      <h2>Invoice - <?= $orderid;?></h2>
      <p>Order Date: <?= $orderat;?></p>
    </div>

    <!-- Customer Info -->
    <table class="info-table">
      <tr>
        <td>
          <strong>Customer Info:</strong>
          <p><?= $customername;?></p>
          <p><?= $customermobile;?></p>
        </td>
        <td>
          <strong>Shipping Address:</strong>
          <p><?= $customeraddress;?></p>
          <p><?= $customerpincode;?></p>
        </td>
      </tr>
    </table>

    <!-- Items Table -->
    <table class="items">
      <thead>
        <tr>
          <th>Product</th>
          <th class="text-center">Qty</th>
          <th class="text-right">Price</th>
          <th class="text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($BYP as $row): ?>
          <?php foreach($products as $product): ?>
            <?php if($row['productid'] == $product['id']): ?>
              <tr>
                <td><?= $product['name'];?></td>
                <td class="text-center"><?= $row['quantity'];?></td>
                <td class="text-right">Rs.<?= number_format($product['amount'], 2);?></td>
                <td class="text-right">Rs.<?= number_format($product['amount'] * $row['quantity'], 2);?></td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Totals -->
    <table class="totals">
      <tr><td>Subtotal:</td><td>Rs.<?= number_format($subtotal, 2);?></td></tr>
      <tr><td>Packaging:</td><td>Rs.<?= number_format($packaging, 2);?></td></tr>
      <tr><td>Tax:</td><td>Rs.<?= number_format($tax, 2);?></td></tr>
      <tr class="grand-total"><td>Grand Total:</td><td>Rs.<?= number_format($total, 2);?></td></tr>
    </table>

    <!-- Payment Info + QR -->
    <div class="payment-section">
      <div class="payment-info">
        <strong>Rupees <?= $inwords?></strong>
        <br><strong>Payment Mode:</strong>
        <?= $paymentmode;?>
      </div>

      <div class="qr-code">
        <img src="<?php echo $qrBase64; ?>" alt="QR Code">
      </div>
    </div>

    <!-- Terms -->
    <div class="terms">
      <strong>Terms & Conditions:</strong>
      <ol>
        <li>Goods once sold will not be taken back.</li>
        <li>Delivery timelines are indicative; delays may occur.</li>
        <li>All disputes are subject to City jurisdiction.</li>
        <li>Payment to be made within 7 days of invoice date.</li>
        <li>Warranty & Returns as per company policy.</li>
      </ol>
    </div>

  </div>
</body>

</html>
