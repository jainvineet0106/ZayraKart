<?php include_once "include/header.php"; ?>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container mt-5">
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
      <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Product</h4>
        </div>
        <div class="card-body p-4">
          <form action="<?php echo site_url('admin/addproduct');?>" id="product" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="productName" class="form-label fw-semibold">
                <i class="fas fa-box me-2 text-primary"></i>Product Name<span style="color: red">*</span>
              </label>
              <input type="text" class="form-control" id="productName" name="product_name" required>
            </div>
            <div class="mb-3">
              <label for="productImage" class="form-label fw-semibold">
                <i class="fas fa-image me-2 text-primary"></i>Product Image<span style="color: red">*</span>
              </label>
              <input class="form-control" type="file" id="productImage" name="product_image" required>
              <input type="hidden" name="compressed_image" id="compressedImage">
            </div>
            <div class="mb-3">
              <label for="productPrice" class="form-label fw-semibold">
                <i class="fas fa-tag me-2 text-primary"></i>Price (₹)<span style="color: red">*</span>
              </label>
              <input type="number" class="form-control" id="productPrice" name="price" min="1" required>
            </div>
            <div class="mb-3">
              <label for="productStock" class="form-label">
                <i class="fas fa-boxes me-2 text-primary"></i>Stock <span class="text-danger">*</span>
              </label>
              <input type="number" class="form-control" id="productStock" name="stock" min="0" required>
            </div>
            <div class="mb-3">
              <label for="productCategory" class="form-label fw-semibold">
                <i class="fas fa-list me-2 text-primary"></i>Category<span style="color: red">*</span>
              </label>
              <select class="form-select" id="productCategory" name="categories" onchange="checkCategory()" required>
                <option selected disabled>Choose a category</option>
                <?php
                foreach ($categories as $row){
                  ?>
                  <option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                  <?php } ?>
                  <option value="Other">Other</option>
              </select>
            </div>
            <div id="newCategoryFields" style="display: none; border: 1px dashed #ccc; padding: 15px; border-radius: 10px;">
              <h5 class="text-secondary mb-3">New Category Details</h5>

              <div class="mb-3">
                <label for="newCategory" class="form-label">New Category Name<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="new_category" id="newCategory">
              </div>
            </div>
            <div class="mb-3">
              <label for="productDesc" class="form-label fw-semibold">
                <i class="fas fa-align-left me-2 text-primary"></i>Description<span style="color: red">*</span>
              </label>
              <textarea class="form-control" id="productDesc" name="description" rows="3" placeholder="Enter product details..."></textarea>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-check-circle me-1"></i>Add Product
              </button>
              <a href="<?php echo site_url('admin/product')?>" class="btn btn-secondary">← Back to Products</a>
            </div>
          </form>
        </div>
      </div>
    </div>

</div>

<script>
document.getElementById('productImage').addEventListener('change', function (e) {
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

<script>
  function checkCategory() {
    const category = document.getElementById('productCategory').value;
    const newFields = document.getElementById('newCategoryFields');
    if (category === "Other") {
      newFields.style.display = "block";
    } else {
      newFields.style.display = "none";
    }
  }
</script>
  <?php include_once "include/footer.php"; ?>
</body>
</html>
