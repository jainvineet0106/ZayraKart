<?php

// use App\Controllers\Staff;

foreach ($staffs as $staff) {
    $staffid = $staff['staffid'];
    $name = $staff['name'];
    $mobile = $staff['mobile'];
    $email = $staff['email'];
    $image = $staff['image'];
}

foreach ($admins as $admin) {
    $companyname = $admin['name'];
}

$logo_path = base_url('public/frontend/images/bg/logo2.png');
$photo_path = base_url('public/staff/images/' . $image);
$qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=' . urlencode("Staff ID: $staffid");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff ID Card</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        .id-card {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            position: relative;
            text-align: center;
            background-color: #134a81ff;
            color: white;
        }

        .id-header img {
            width: 40mm;
            height: 15mm;
            object-fit: contain;
            margin-bottom: 3mm;
        }

        .id-photo {
            width: 25mm;
            height: 25mm;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            margin: 0 auto 3mm;
            display: block;
        }

        .id-info h2 {
            font-size: 14pt;
            margin: 2mm 0;
            font-weight: 600;
        }

        .id-info p {
            font-size: 10pt;
            margin: 1mm 0;
            color: #ffffff;
        }

        .id-divider {
            width: 75%;
            height: 1px;
            background-color: #ffffff;
            margin: 2mm auto;
        }

        .qr-section img {
            width: 25mm;
            height: 25mm;
            background: #ffffff;
            padding: 2mm;
            border-radius: 4mm;
        }

        .id-footer {
            /* background-color: #1565c0; */
            background-color: #11304eff;
            font-size: 9pt;
            padding: 2mm 0;
            position: absolute;
            bottom: 0;
            width: 100%;
            left: 0;
        }
    </style>
</head>

<body>
    <div class="id-card">
        <div class="id-header">
            <img src="<?php echo $logo_path; ?>" alt="Company Logo">
        </div>
        <img src="<?php echo $photo_path; ?>" alt="User Photo" class="id-photo">
        <div class="id-info">
            <h2><?php echo htmlspecialchars($name); ?></h2>
            <p><strong>Mobile:</strong> +91 <?php echo htmlspecialchars($mobile); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <div class="id-divider"></div><br>
            <p><strong>Staff ID:</strong> <?php echo htmlspecialchars($staffid); ?></p>
        </div>

        <div class="qr-section">
            <img src="<?php echo $qr_url; ?>" alt="QR Code">
        </div>

        <div class="id-footer">
            Authorized by: <?php echo htmlspecialchars($companyname); ?>
        </div>
    </div>
</body>

</html>