<?php
include_once "include/header.php";
?>

<title>Admin Panel - Orders</title>

<body>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container py-5">
      <h2 class="mb-4">Customers</h2>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
          <div class="table-wrapper" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-dark sticky-header">
                <tr>
                  <th style="text-align: center;">Email</th>
                  <th style="text-align: center;">Received</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($subscribers) {
                  foreach ($subscribers as $row) {
                    ?>
                    <tr>
                      <td style="text-align: center;"><?php echo htmlspecialchars($row['email']); ?></td>
                      <td style="text-align: center;"><?php echo htmlspecialchars($row['receive_date']); ?></td>
                      <td>
                        <button onclick="confirmdelete(<?php echo $row['id']; ?>, 'subscribers' ,'subscribers')"
                          class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted">No subscribers found.</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="text-center">
        <?php echo $pager->links('default', 'custom') ?>
      </div>
    </div>
  </div>
  <?php include_once "include/footer.php"; ?>
</body>

</html>

<style>
  .table-wrapper {
    max-height: 400px;
    overflow-y: auto;
    border-radius: 10px;
  }

  .sticky-header th {
    position: sticky;
    top: 0;
    z-index: 100;
    background-color: #212529;
    color: white;
  }

  .table-wrapper::-webkit-scrollbar {
    width: 6px;
  }

  .table-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
  }

  .table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #555;
  }
</style>