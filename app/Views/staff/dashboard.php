<?php

foreach ($staffs as $staff) {
    $name = $staff['name'];
    $staffid = $staff['staffid'];
    $image = $staff['image'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="icon" href="<?= base_url(); ?>public/frontend/assets/images/favicon.png">
    <link href="<?= base_url('public/staff/css/bootstrap.min.css') ?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
            /* This makes the main content take all available space */
        }

        .navbar-brand {
            font-weight: bold;
        }

        .card {
            border-radius: 12px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.45em 0.8em;
            border-radius: 50px;
        }

        .status-Returned-Requested {
            background: linear-gradient(90deg, #ffc107, #ffd966);
            color: #212529;
        }

        .status-Shipped {
            background: linear-gradient(90deg, #17a2b8, #45c6e5);
            color: #fff;
        }

        .status-Delivered {
            background: linear-gradient(90deg, #28a745, #3cd77a);
            color: #fff;
        }

        .status-Cancelled {
            background: linear-gradient(90deg, #dc3545, #ff6b6b);
            color: #fff;
        }

        .status-Returned {
            background: linear-gradient(90deg, #6f42c1, #9b6ff4);
            color: #fff;
        }

        video {
            width: 100%;
            max-height: 400px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .modal-header {
            background-color: #343a40;
            color: #fff;
        }

        footer {
            background: #343a40;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        @media (max-width: 576px) {
            .card h6 {
                font-size: 1rem;
            }

            .card h3 {
                font-size: 1.5rem;
            }

            .btn {
                font-size: 0.95rem;
                padding: 6px 12px;
            }

            video {
                max-height: 250px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark px-3">
        <div class="d-flex" style="justify-content: center; align-items: center;">
            <img src="<?= base_url('public/staff/images/' . $image) ?>" alt="<?= $name ?>" class="rounded-circle"
                width="40" height="40">
            <div class="ml-2 d-flex" style="justify-content: center; align-items: center; flex-direction: column;">
                <span class="text-warning me-3"><?= $name ?></span>
                <span class="text-white me-3">ID: <span class="text-info"><?= $staffid ?></span></span>
            </div>
        </div>
        <span class="navbar-brand fs-5">Delivery Dashboard</span>
        <a href="<?= base_url('staff/logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
    </nav>

    <main class="container mt-4">
        <!-- Dashboard Cards -->
        <div class="row g-4 text-center justify-content-center">

            <div class="col-6 col-md-2">
                <div class="card shadow-sm  p-3">
                    <h6>Total Orders</h6>
                    <h3 class="fw-bold"><?= $total_orders ?></h3>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <div class="card shadow-sm  p-3">
                    <h6>Pending</h6>
                    <h3 class="text-warning fw-bold" id="Shipped"><?= $Shipped ?></h3>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <div class="card shadow-sm  p-3">
                    <h6>Delivered</h6>
                    <h3 class="text-success fw-bold" id="Delivered"><?= $delivered ?></h3>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <div class="card shadow-sm  p-3">
                    <h6>Cancelled</h6>
                    <h3 class="text-danger fw-bold" id="Cancelled"><?= $cancelled ?></h3>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <div class="card shadow-sm  p-3">
                    <h6>Returned</h6>
                    <h3 class="text-info fw-bold" id="Returned"><?= $returned ?></h3>
                </div>
            </div>

        </div>


        <!-- Orders Table -->
        <div class="card shadow-sm mt-4 p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                <h5>📦 Orders List</h5>
            </div>

            <div class="d-none d-md-block table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Order Id</th>
                            <th>Total Item</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($orders as $o):
                            foreach ($addresses as $address) {
                                if ($o['address'] == $address['id']) {
                                    $oaddress = $address['address'];
                                    $ocustomer = $address['title'];
                                    $omobile = $address['mobile'];
                                    $opincode = $address['pincode'];
                                }
                                $totalItem = explode('#@', $o['buyproductid']);
                            } ?>
                            <tr>
                                <td id="<?= $o['orderid'] ?>"><?= $o['orderid'] ?></td>
                                <td><?= count($totalItem) ?></td>
                                <td><?= $ocustomer ?></td>
                                <td><?= $omobile ?></td>
                                <td><?= $oaddress . '<br>Pin: ' . $opincode ?></td>
                                <td>
                                    Rs.<?= $o['total'] ?><br>
                                    <?php
                                    if($o['status'] != 'Returned-Requested' && $o['status'] != 'Returned'){
                                    ?>
                                    Paystatus: <span id="paystatus-<?= $o['orderid'] ?>"><?= $o['paystatus'] ?></span><br>
                                    Mode: <?= $o['paymentmode'] ?>
                                    <?php    
                                    }
                                    ?>
                                </td>
                                <td>
                                    <span class="badge status-<?= $o['status'] ?>"
                                        id="status-<?= $o['orderid'] ?>"><span id="orderstatus-<?= $o['status'] ?>"><?= $o['status'] ?></span></span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm startScanBtn" data-order="<?= $o['orderid'] ?>"
                                        <?= ($o['status'] == 'Cancelled' || $o['status'] == 'Returned' || $o['status'] == 'Delivered') ? 'disabled' : '' ?>>
                                        Scan QR</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                <?php foreach ($orders as $o):
                    foreach ($addresses as $address) {
                        if ($o['address'] == $address['id']) {
                            $oaddress = $address['address'];
                            $ocustomer = $address['title'];
                            $omobile = $address['mobile'];
                            $opincode = $address['pincode'];
                        }
                    } ?>
                    <div class="card mb-3 shadow-sm p-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-1"><?= $o['orderid'] ?> 
                            <span class="badge status-<?= $o['status'] ?>" id="orderstatus-<?= $o['status'] ?>"><?= $o['status'] ?></span>
                            </h6>
                            <button class="btn btn-primary btn-sm startScanBtn" data-order="<?= $o['orderid'] ?>"
                                <?= ($o['status'] == 'Cancelled' || $o['status'] == 'Returned' || $o['status'] == 'Delivered') ? 'disabled' : '' ?>
                            >Scan
                                QR</button>
                        </div>
                        <p class="mb-1"><strong>Customer:</strong> <?= $ocustomer ?></p>
                        <p class="mb-1"><strong>Mobile:</strong> <?= $omobile ?></p>
                        <p class="mb-1"><strong>Address:</strong> <?= $oaddress ?>, Pin: <?= $opincode ?></p>
                        <p class="mb-0"><strong>Amount:</strong> Rs.<?= $o['total'] ?> 
                        <?php
                            if($o['status'] != 'Returned-Requested' && $o['status'] != 'Returned'){
                        ?> 
                        | Pay: <span id="mpaystatus-<?= $o['orderid']?>"><?= $o['paystatus'] ?></span> | Mode: <?= $o['paymentmode'] ?> 
                        <?php } ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">&copy; 2025 ZayraKart. All rights reserved. Designed by Vineet Jain.</p>
    </footer>

    <!-- QR Modal -->
    <div class="modal fade" id="scannerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR Scanner</h5>
                    <button type="button" class="btn-close btn-close-white" onclick="stopCamera()"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <video id="video" autoplay playsinline></video>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <p class="mt-2"><strong>Status:</strong> <span id="status">Waiting...</span></p>
                    <p><strong>Decoded:</strong> <span id="decoded">—</span></p>
                    <button onclick="markDeliveredBtn()" id="markDeliveredBtn" class="btn btn-success mt-2 d-none">Mark
                        as Delivered</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('public/staff/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
    <script>
        const modal = new bootstrap.Modal(document.getElementById('scannerModal'));
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const statusEl = document.getElementById('status');
        const decodedEl = document.getElementById('decoded');
        let stream = null, scanning = false, currentOrderId = null;
        document.querySelectorAll('.startScanBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                currentOrderId = btn.dataset.order;
                modal.show();
                startCamera();
            });
        });

        // document.getElementById('addProductBtn').addEventListener('click', () => {
        //     alert('Add Product function will be implemented here!');
        // });

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: "environment" }
                });
                video.srcObject = stream;
                scanning = true;
                statusEl.textContent = "Scanning...";
                decoded.textContent = "—";
                requestAnimationFrame(scanFrame);
            } catch (err) { statusEl.textContent = "Camera access denied."; }
        }
        function stopCamera() {
            scanning = false;
            if (stream) {
                stream.getTracks().forEach(t => t.stop()); stream = null;
            }
            let markbtn = document.getElementById('markDeliveredBtn');
            markbtn.classList.add('d-none');
        }
        function changeStatus(orderId, newStatus) {
            let BASE_URL = "<?php echo base_url(); ?>";
            $.ajax({
                type: "post",
                url: BASE_URL + "staff/changestate",
                data: { orderid: orderId, newStatus: newStatus },
                success: function (response) {
                    let status = document.getElementById('status-' + orderId);
                    status.innerText = newStatus;
                    status.classList.remove('status-' + status.innerText);
                    status.classList.add('status-' + newStatus);
                    let statusbar = JSON.parse(response);
                    document.getElementById('Delivered').innerText = statusbar['Delivered'];
                    document.getElementById('Shipped').innerText = statusbar['Shipped'];
                    document.getElementById('Cancelled').innerText = statusbar['Cancelled'];
                    document.getElementById('Returned').innerText = statusbar['Returned'];
                    document.getElementById('paystatus-' + orderId).innerText = 'Paid';
                    document.getElementById('mpaystatus-' + orderId).innerText = 'Paid';
                    Array.from(document.getElementsByClassName('startScanBtn')).forEach(btn => {
                        if (btn.dataset.order == orderId) {
                            btn.disabled = true;
                        }
                    });
                }
            });
        }
        function markDeliveredBtn(orderstatus = 'none') {
            let decoded = document.getElementById('decoded').innerText;
            if (!decoded) return;
            let words = decoded.split("|");
            let code = words[0].split(":");
            code = code[1].trim()
            let orderid = document.getElementById(currentOrderId);
            if (orderid) {
                if (orderid.innerText == code) {
                    if (orderstatus == 'Returned') {
                        changeStatus(code, orderstatus);
                        modal.hide();
                        alert('Order marked as Returned');
                    }else{
                        changeStatus(code, 'Delivered');
                        modal.hide();
                        alert('Order marked as Delivered');
                    }
                } else {
                    alert('No Item Match Scan Again');
                    let markbtn = document.getElementById('markDeliveredBtn');
                    markbtn.classList.add('d-none');
                    modal.show();
                    startCamera();
                }
            } else {
                alert('No Item Match Scan Again');
            }
        }
        function scanFrame() {
            if (!scanning) return;
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, { inversionAttempts: "attemptBoth" });
                if (code) {
                    if (code.data == "") {
                        scanning = true;
                    } else {
                        if ((code.data).includes('OrderID:')) {
                            scanning = false;
                            decodedEl.textContent = code.data;
                            statusEl.textContent = "QR detected...";
                            let orderstatus = document.getElementById('orderstatus-Returned-Requested');
                            if (orderstatus){
                                markDeliveredBtn('Returned');
                            }else{
                                let markbtn = document.getElementById('markDeliveredBtn');
                                markbtn.classList.remove('d-none');
                            }
                        }
                    }
                }
            }
            if (scanning) requestAnimationFrame(scanFrame);
        }
        document.getElementById('scannerModal').addEventListener('hidden.bs.modal', stopCamera);
    </script>
</body>

</html>