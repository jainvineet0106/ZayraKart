<?php include_once "include/header.php"; ?>

<body>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container mt-4">
      <?php if(session()->getFlashdata('success')){?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php }else if(session()->getFlashdata('error')){?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      <?php } ?>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Products</h2>
        <a href="<?php echo site_url('admin/addproduct')?>" class="btn btn-success">+ Add Product</a>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-hover text-center align-middle">
          <thead class="table-secondary text-dark">
            <tr>
              <th>S.no</th>
              <th>Image</th>
              <th>Product Id</th>
              <th>Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Description</th>
              <th>Categories</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            foreach ($products as $row) {
              $row['description'] = str_replace("_","'",$row['description']);
            ?>
            <tr>
                <td><?= ++$i ?></td>
                <td>
                  <img src="<?php echo base_url('public/frontend/images/Product/').$row['image'];?>" class="img-thumbnail" width="80" alt="Product <?= $i ?>">
                </td>
                <td><?= $row['product_id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>Rs. <?= $row['amount'] ?></td>
                <td><?= $row['stock'] ?></td>
                <td style="width: 250px;"><?= $row['description'] ?></td>
                <td>
                    <?php
                    foreach($categories as $cat){
                      if($cat['id'] == $row['categories_id']){
                        echo $cat['category'];
                      }
                    }
                    ?>
                </td>
                <td>
                    <a href="<?php echo site_url('admin/edit_product/').encode_id($row['id']);?>" class="btn btn-sm btn-primary">Edit</a>
                    <a class="btn btn-sm btn-danger" onclick="confirmdelete(<?= $row['id'] ?>, 'products', 'product' )">Delete</a>
                </td>
            </tr>
            <?php 
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-12">
        <div class="text-center">
            <?php echo $pager->links('default','custom') ?>
        </div>
      </div>
    </div>
  </div>

  <?php include_once "include/footer.php"; ?>
</body>
</html>
