<?php
include_once "include/header.php";
?>

<title>Admin Panel - Orders</title>

<body>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container py-5">
      <h2 class="mb-4">User Accounts</h2>

      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
          <div class="table-wrapper" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-dark sticky-header">
                <tr>
                  <th style="text-align: center;">User</th>
                  <th style="text-align: center;">Email</th>
                  <th style="text-align: center;">Mobile</th>
                  <th style="text-align: center;">Addressess</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($user_accounts) {
                  foreach ($user_accounts as $row) {
                    ?>
                    <tr>
                      <td style="text-align: center; vertical-align: middle; padding: 15px;">
                        <div style="display: inline-block; padding: 15px 25px; font-family: 'Poppins', sans-serif;">
                          <img src="<?php echo base_url('public/frontend/images/useraccounts/') . $row['image']; ?>" alt="User"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                          <div style="font-weight: 600; color: #333; font-size: 16px;">
                            <?php echo htmlspecialchars($row['name']); ?>
                          </div>
                        </div>
                      </td>

                      <td style="text-align: center;"><?php echo htmlspecialchars($row['email']); ?></td>
                      <td style="text-align: center;"><?php echo htmlspecialchars($row['mobile']); ?></td>

                      <td style="text-align: center; vertical-align: middle; padding: 15px;">
                        <div style="display: inline-block; padding: 10px 20px;">
                          <table
                            style="border-collapse: collapse; font-family: 'Poppins', sans-serif; font-size: 15px; color: #333;">
                            <?php
                            $found = true;
                            foreach ($useraddress as $address) {
                              if ($address['userid'] == $row['id']) {
                                ?>
                                <tr>
                                  <td style="padding: 8px 12px; font-weight: 600; color: #007bff;"><?= $address['title']; ?></td>
                                  <td style="padding: 8px 5px; color: #555;">:-</td>
                                  <td style="padding: 8px 12px; color: #444;"><?= $address['address'] ?></td>
                                </tr>
                              <?php
                              }
                            }
                            ?>
                          </table>
                        </div>
                      </td>

                      <td>
                        <button onclick="confirmdelete(<?php echo $row['id']; ?>, 'user_accounts' ,'useraccounts')"
                          class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted">No User found.</td>
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