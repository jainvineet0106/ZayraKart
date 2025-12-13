<?php
include APPPATH . 'Views/backend/include/header.php';
?>

<?php

foreach ($staffs as $staff) {
  $staffid = $staff['staffid'];
  $staffimage = $staff['image'];
  $staffmobile = $staff['mobile'];
  $staffemail = $staff['email'];
  $staffname = $staff['name'];
  $staffjoining = $staff['joining'];
  $staffpassword = $staff['password'];
  $staffdocuments = $staff['documents'];
  $staffsalary = $staff['salary'];
}

$years = [];
foreach ($staffattendance as $row) {
  if (!in_array($row['year'], $years)) {
    $years[] = $row['year'];
  }
}
rsort($years);
?>

<body class="d-flex flex-column min-vh-100" style="background-color: #f8f9fa;">
  <!-- Sidebar -->
  <?php include APPPATH . 'Views/backend/include/sidebar.php'; ?>
  <!-- Main -->
  <div class="content flex-grow-1" id="content_slide">
    <!-- Header -->
    <?php include APPPATH . 'Views/backend/include/head.php'; ?>

    <!-- Content -->
    <div class="container mt-4 mb-5">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <div class="mb-4 border-0 shadow-lg p-4 position-relative"
        style="border-radius: 20px; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff;">
        <a href="<?= site_url('admin/staffedit/' . encode_id($staffid)) ?>"
          class="btn btn-warning btn-sm position-absolute top-0 end-0 m-3 d-flex align-items-center gap-1">
          <i class="bi bi-pencil-fill"></i> Edit
        </a>
        <a href="<?= site_url('admin/staff') ?>"
          class="btn btn-outline-light btn-sm position-absolute top-0 start-0 m-3 d-flex align-items-center gap-1 shadow-sm">
          <i class="bi bi-arrow-left-circle-fill"></i> Back
        </a>
        <div class="row align-items-center g-4">
          <!-- Profile Image -->
          <div class="col-md-3 text-center">
            <img src="<?php echo base_url('public/staff/images/') . $staffimage; ?>" alt="Employee Photo"
              class="rounded-circle shadow"
              style="width: 140px; height: 140px; object-fit: cover; border: 5px solid #fff; box-shadow: 0 0 15px rgba(255,255,255,0.6);">
            <h6 class="mt-2 text-light"><?= $staffname ?></h6>
          </div>
          <!-- Info Section -->
          <div class="col-md-9">
            <h2 class="fw-bold mb-3 text-warning"><?= $staffname ?></h2>

            <div class="row">
              <div class="col-sm-6 mb-2">
                <i class="bi bi-person-badge-fill text-warning me-2"></i>
                <strong>ID:</strong> <?= $staffid ?>
              </div>
              <!-- <div class="col-sm-6 mb-2">
                <i class="bi bi-briefcase-fill text-warning me-2"></i>
                <strong>Role:</strong> Manager
              </div> -->
              <!-- <div class="col-sm-6 mb-2">
                <i class="bi bi-building text-warning me-2"></i>
                <strong>Department:</strong> Sales
              </div> -->
              <div class="col-sm-6 mb-2">
                <i class="bi bi-envelope-fill text-warning me-2"></i>
                <strong>Email:</strong> <?= $staffemail ?>
              </div>
              <div class="col-sm-6 mb-2">
                <i class="bi bi-telephone-fill text-warning me-2"></i>
                <strong>Phone:</strong> +91 <?= $staffmobile ?>
              </div>
              <div class="col-sm-6 mb-2">
                <i class="bi bi-calendar-check-fill text-warning me-2"></i>
                <strong>Joining Date:</strong> <?= $staffjoining ?>
              </div>
              <div class="col-sm-6 mb-2">
                <i class="bi bi-key-fill text-warning me-2"></i>
                <strong>Password:</strong> <?= $staffpassword ?>
              </div>
              <div class="col-sm-6 mb-2">
                <i class="bi bi-cash-stack text-warning me-2"></i>
                <strong>Salary:</strong> <?= $staffsalary ?>
              </div>
              <div class="col-sm-6 mb-2">
                <label for="document" class="form-label fw-bold">
                  <i class="bi bi-file-earmark-arrow-up text-warning me-2"></i>Select Document
                </label>
                <div class="input-group shadow-sm">
                  <select id="documents" class="form-select border-0 fw-semibold"
                    style="background: rgba(255,255,255,0.9); color: #1e3c72;">
                    <?php
                    if ($staffdocuments) {
                      $terms = explode("#@", $staffdocuments);
                      foreach ($terms as $value) {
                        foreach ($documents as $docu) {
                          if ($docu['id'] == $value) {
                            ?>
                            <option value="<?= $docu['documents'] ?>"><?= $docu['documents'] ?></option>
                            <?php
                          }
                        }
                      }
                    }
                    ?>
                  </select>
                  <button type="button" onclick="docview()" class="btn btn-warning fw-semibold px-4">
                    <i class="bi bi-eye"></i> View
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h2 class="text-center mb-4">Employee Attendance</h2>
    <div class="card shadow-sm border-0 rounded-4 mb-4">
      <div class="card-body">
        <form class="row g-3 align-items-center filter-bar">
          <div class="row g-3 align-items-end">
            <div class="col-md-3">
              <label for="monthFilter" class="form-label">Month</label>
              <select class="form-select" id="monthFilter" onchange="filterData()">
                <option value="" selected>-- All Months --</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
            </div>

            <!-- Year Filter -->
            <div class="col-md-3">
              <label for="yearFilter" class="form-label">Year</label>
              <select class="form-select" id="yearFilter" onchange="filterData()">
                <option value="" selected>-- All Years --</option>
                <?php foreach ($years as $year): ?>
                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Reset Button -->
            <div class="col-md-2">
              <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">Reset</button>
            </div>
          </div>

        </form>
      </div>
    </div>

    <div class="card p-4">
      <table id="attendancetable" class="table table-bordered table-hover text-center">
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Time</th>
            <th>Date</th>
            <th>Month</th>
            <th>Year</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($staffattendance as $row) { ?>
            <tr>
              <td><?php echo $row['staffid']; ?></td>
              <td><?php echo $row['time']; ?></td>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['month']; ?></td>
              <td><?php echo $row['year']; ?></td>
              <td class="status"><?php echo $row['status']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <br>
    <div class="col-md-12">
      <div class="text-center">
        <?php echo $pager->links('default', 'custom') ?>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const statusElements = document.querySelectorAll(".status");

      statusElements.forEach(el => {
        const statusText = el.textContent.trim();

        switch (statusText) {
          case "Present":
            el.classList.add("bg-success", "text-white", "px-2", "rounded");
            break;
          case "Absent":
            el.classList.add("bg-danger", "text-white", "px-2", "rounded");
            break;
          case "Leave":
            el.classList.add("bg-warning", "text-dark", "px-2", "rounded");
            break;
          default:
            el.classList.add("bg-secondary", "text-white", "px-2", "rounded");
        }
      });
    });

    function filterData() {
      const month = document.getElementById('monthFilter').value;
      const year = document.getElementById('yearFilter').value;
      const table = document.getElementById('attendancetable');
      const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

      for (let i = 0; i < rows.length; i++) {
        let monthCell = rows[i].cells[2].textContent;
        let yearCell = rows[i].cells[3].textContent;

        if ((month === "" || monthCell === month) && (year === "" || yearCell === year)) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    }

    function clearFilters() {
      document.getElementById('monthFilter').value = "";
      document.getElementById('yearFilter').value = "";
      filterData();
    }

    function docview() {
      let doc = document.getElementById('documents');

      let BASE_URL = "<?= base_url('public/staff/images/documents/') ?>";

      window.open(BASE_URL + doc.value, "_blank");
    }
  </script>

  </div>
  <?php
  include APPPATH . 'Views/backend/include/footer.php';
  ?>
</body>

</html>