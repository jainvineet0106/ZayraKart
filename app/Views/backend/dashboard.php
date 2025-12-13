<?php
include_once "include/header.php";
?>

<body>
  <?php
  include_once "include/sidebar.php";
  ?>
  <div class="content" id="content_slide">
    <?php
    include_once "include/head.php";
    ?>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card text-white bg-info">
          <div class="card-body">
            <h5 class="card-title">Staff Attendance</h5>
            <p class="card-text fs-6">Scan your QR to mark attendance</p>
            <button id="startScanner" class="btn btn-light btn-sm">Open QR Scanner</button>
            <!-- <video id="qr-video" width="100%" style="display:none;"></video>
            <form id="attendanceForm" method="POST" action="mark_attendance.php">
              <input type="hidden" name="staff_id" id="staff_id">
            </form> -->
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-primary">
          <div class="card-body">
            <h5 class="card-title">Total Products</h5>
            <p class="card-text fs-4"><?php echo $total_products; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success">
          <div class="card-body">
            <h5 class="card-title">Total Orders</h5>
            <p class="card-text fs-4"><?php echo $total_buy; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning">
          <div class="card-body">
            <h5 class="card-title">Total Subscribers</h5>
            <p class="card-text fs-4"><?php echo $total_subscribers; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-secondary">
          <div class="card-body">
            <h5 class="card-title">Total Staff</h5>
            <p class="card-text fs-4"><?php echo $total_staff; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <style>
    .modal-header {
      background-color: #343a40;
      color: #fff;
    }

    video {
      width: 100%;
      max-height: 400px;
      border-radius: 10px;
      border: 1px solid #dee2e6;
    }
  </style>
  <div class="modal fade" id="scannerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">QR Scanner</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <video id="video" autoplay playsinline></video>
          <canvas id="canvas" style="display:none;"></canvas>
          <p class="mt-2"><strong>Status:</strong> <span id="status">Waiting...</span></p>
        </div>
      </div>
    </div>
  </div>

  <style>
    .id-card {
      width: 40%;
      height: 100%;
      padding: 5mm 4mm;
      margin: 0 auto;
      box-sizing: border-box;
      border-radius: 10px;
      position: relative;
      text-align: center;
      /* background-color: #1976d2; */
      background-color: #1e3c72;
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
      background-color: #11304eff;
      font-size: 9pt;
      padding: 2mm 0;
      position: absolute;
      bottom: 0;
      width: 100%;
      border-radius: 0 0 10px 10px;
      left: 0;
    }
    @media (max-width: 991.98px) {
      .id-card {
        width: 80%;
      }
    }
  </style>
  <div class="modal fade" id="staffcardModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Staff Card</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <div class="id-card">
            <div class="id-header">
              <img src="" id="companylogo" alt="Company Logo">
            </div>
            <img src="" alt="User Photo" id="userphoto" class="id-photo">
            <div class="id-info">
              <h2 id="staffName"></h2>
              <p><strong>Username:</strong> <span id="staffUsername"></span></p>
              <p><strong>Mobile:</strong> <span id="staffMobile"></span></p>
              <p><strong>Email:</strong> <span id="staffEmail"></span></p>
              <div class="id-divider"></div>
              <p><strong>Staff ID: </strong><span id="staffID"></span></p>
            </div>

            <div class="qr-section">
              <img src="" id="staffqr" alt="QR Code">
            </div>
            <br>

            <div class="id-footer">
              Authorized by: <span id="companyName"></span>
            </div>
          </div>
          <button onclick="markPresentBtn()" id="markPresentBtn" class="btn mt-2"
            style="background: linear-gradient(45deg, #28a745, #218838); color: #fff; font-weight: bold; border-radius: 12px; padding: 10px 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
            Mark as Present
          </button>
        </div>
      </div>
    </div>
  </div>
  <?php include_once "include/footer.php"; ?>

  <?php
  foreach ($admins as $admin) {
    $companyname = $admin['name'];
  }
  $logo_path = base_url('public/frontend/images/bg/logo2.png');
  ?>

  <!-- <script src="https://unpkg.com/html5-qrcode"></script> -->
  <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
  <script>

    function fetchdetail(url, id) {
      return fetch("<?= base_url(); ?>" + url + "/" + id)
        .then(response => response.json())
        .catch(error => {
          console.error("Error fetching order:", error);
          throw error;
        });
    }

    function markPresentBtn() {
      let staffID = document.getElementById('staffID').innerText;
      if (!staffID) return;
      changeStatus(staffID, 'Present');
    }

    function changeStatus(staffID, attendance) {
      let BASE_URL = "<?php echo base_url(); ?>";
      $.ajax({
        type: "post",
        url: BASE_URL + "admin/markattendance",
        data: { staffid: staffID, attendance: attendance },
        success: function (response) {
          if(response == 'success'){
            staffModal.hide();
            alert('staff marked as Present');
          }
        }
      });
    }

    const modal = new bootstrap.Modal(document.getElementById('scannerModal'));
    const staffModal = new bootstrap.Modal(document.getElementById('staffcardModal'));

    async function view(staffid) {
      const staff = await fetchdetail('getstaff', staffid);
      document.getElementById('companylogo').src = "<?php echo $logo_path; ?>";
      document.getElementById('userphoto').src = "<?php echo base_url('public/staff/images/'); ?>" + staff.image;
      document.getElementById('staffqr').src = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=Staff ID:" + staffid;
      document.getElementById('staffID').textContent = staffid;
      document.getElementById('staffName').textContent = staff.name;
      document.getElementById('staffUsername').textContent = staff.username;
      document.getElementById('staffMobile').textContent = "+91 " + staff.mobile
      document.getElementById('staffEmail').textContent = staff.email;
      document.getElementById('companyName').textContent = "<?php echo htmlspecialchars($companyname); ?>";
      staffModal.show();
    }
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const statusEl = document.getElementById('status');
    let stream = null, scanning = false, currentOrderId = null;
    document.querySelectorAll('#startScanner').forEach(btn => {
      btn.addEventListener('click', () => {
        currentOrderId = btn.dataset.order;
        modal.show();
        startCamera();
      });
    });

    async function startCamera() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({
          video: { facingMode: "environment" }
        });
        video.srcObject = stream;
        scanning = true;
        statusEl.textContent = "Scanning...";
        requestAnimationFrame(scanFrame);
      } catch (err) { statusEl.textContent = "Camera access denied."; }
    }

    function stopCamera() {
      scanning = false;
      if (stream) {
        stream.getTracks().forEach(t => t.stop()); stream = null;
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
            if ((code.data).includes('Staff ID:')) {
              scanning = false;
              statusEl.textContent = "QR detected...";
              modal.hide();
              let staff_id = code.data.split(":");
              d(staff_id[1].trim());
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