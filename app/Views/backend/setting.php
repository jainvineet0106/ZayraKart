<?php include_once "include/header.php"; ?>

<body>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3">Admin Settings</h4>
      </div>
      <?php if(session()->getFlashdata('success')):?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <?php
      foreach ($view as $row) {
      ?>
      <form action="<?php echo site_url('admin/setting');?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Admin Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" placeholder="Enter Admin Name" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Admin Username<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" placeholder="Enter Admin Username" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Email Address<span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" placeholder="Enter Email Address" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Mobile<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="mobile" min="0" max="10" value="<?php echo $row['mobile']; ?>" placeholder="Enter Mobile Number" required />
        </div>
        <div class="mb-3">
          <label class="form-label">UPI ID<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="upiid" min="0" max="10" value="<?php echo $row['upiid']; ?>" placeholder="Enter UPI ID" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Location<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="location" value="<?php echo $row['address']; ?>" placeholder="Enter Location" required />
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Shop Open Time <span class="text-danger">*</span></label>
            <div class="row g-2">
              <div class="col-4">
                <select class="form-select" name="open_hour" required>
                  <?php
                  $opntime = explode(',', $row['open']);
                  for ($i = 1; $i <= 12; $i++) {
                    $sel = ($i == $opntime[0]) ? "selected" : "";
                    echo "<option value='$i' $sel>$i</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-4">
                <select class="form-select" name="open_minute" required>
                  <?php
                  for ($i = 0; $i < 60; $i += 5) {
                    $val = sprintf('%02d', $i);
                    $sel = ($i == $opntime[1]) ? "selected" : "";
                    echo "<option value='$val' $sel>$val</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-4">
                <select class="form-select" name="open_ampm" required>
                  <option value="AM" <?= ($opntime[2] === "AM") ? "selected" : "" ?>>AM</option>
                  <option value="PM" <?= ($opntime[2] === "PM") ? "selected" : "" ?>>PM</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Shop Close Time -->
          <div class="col-md-6">
            <label class="form-label fw-semibold">Shop Close Time <span class="text-danger">*</span></label>
            <div class="row g-2">
              <div class="col-4">
                <select class="form-select" name="close_hour" required>
                  <?php
                  $closetime = explode(',', $row['close']);
                  for ($i = 1; $i <= 12; $i++) {
                    $sel = ($i == $closetime[0]) ? "selected" : "";
                    echo "<option value='$i' $sel>$i</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-4">
                <select class="form-select" name="close_minute" required>
                  <?php
                  for ($i = 0; $i < 60; $i += 5) {
                    $val = sprintf('%02d', $i);
                    $sel = ($i == $closetime[1]) ? "selected" : "";
                    echo "<option value='$val' $sel>$val</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-4">
                <select class="form-select" name="close_ampm" required>
                  <option value="AM" <?= ($closetime[2] === "AM") ? "selected" : "" ?>>AM</option>
                  <option value="PM" <?= ($closetime[2] === "PM") ? "selected" : "" ?>>PM</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Week Selection -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Week From <span class="text-danger">*</span></label>
            <select class="form-select" name="week_from" required>
              <option value="">-- Select Day --</option>
              <?php
              $days = ["Mon" => "Monday", "Tue" => "Tuesday", "Wed" => "Wednesday", "Thu" => "Thursday", "Fri" => "Friday", "Sat" => "Saturday", "Sun" => "Sunday"];
              foreach ($days as $key => $day) {
                $sel = ($row['week_from'] == $key) ? "selected" : "";
                echo "<option value='$key' $sel>$day</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Week To <span class="text-danger">*</span></label>
            <select class="form-select" name="week_to" required>
              <option value="">-- Select Day --</option>
              <?php
              foreach ($days as $key => $day) {
                $sel = ($row['week_to'] == $key) ? "selected" : "";
                echo "<option value='$key' $sel>$day</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Change Password<span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="Enter New Password" />
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
      <?php }?>
    </div>
  </div>
  <?php include_once "include/footer.php"; ?>

<script>
document.getElementById('image').addEventListener('change', function (e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.readAsDataURL(file);

  reader.onload = function (event) {
    const img = new Image();
    img.src = event.target.result;

    img.onload = function () {
      const canvas = document.createElement('canvas');
      const maxWidth = 800;
      const scale = maxWidth / img.width;
      canvas.width = maxWidth;
      canvas.height = img.height * scale;

      const ctx = canvas.getContext('2d');
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

      const compressedData = canvas.toDataURL('image/jpeg', 0.7); // compress here
      document.getElementById('compressedImage').value = compressedData;
    }
  }
});
</script>


</body>
</html>