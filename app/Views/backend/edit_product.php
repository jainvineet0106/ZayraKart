<?php include_once "include/header.php";?>

<body>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container mt-5">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0"><i class="fas fa-edit me-2 text-white"></i>Edit Product</h4>
        </div>
        <div class="card-body p-4">
            <?php
            foreach ($products as $row){
            ?>
            <form action="<?php echo site_url('admin/edit_product/').encode_id($row['id']);?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="productName" class="form-label fw-semibold">
                    <i class="fas fa-box me-2 text-primary"></i>Product Name<span style="color: red">*</span>
                    </label>
                    <input value="<?php echo $row['name'];?>" type="text" class="form-control" id="productName" name="product_name" required>
                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label fw-semibold">
                    <i class="fas fa-image me-2 text-primary"></i>Product Image
                    </label>
                    <input class="form-control" type="file" id="productImage" name="product_image">
                    <div class="border rounded shadow-sm" style="width: 150px; height: 120px; overflow: hidden;">
                        <img 
                        src="<?php echo base_url('public/frontend/images/Product/').$row['image'];?>" 
                        alt="Project Image"
                        class="img-fluid h-100 w-100"
                        >
                    </div>
                    <input type="hidden" name="compressed_image" id="compressedImage">
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label fw-semibold">
                    <i class="fas fa-tag me-2 text-primary"></i>Price (₹)<span style="color: red">*</span>
                    </label>
                    <input value="<?php echo $row['amount'];?>" type="number" class="form-control" id="productPrice" name="price" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="productStock" class="form-label">
                    <i class="fas fa-boxes me-2 text-primary"></i>Stock <span class="text-danger">*</span>
                    </label>
                    <input value="<?php echo $row['stock'];?>" type="number" class="form-control" id="productStock" name="stock" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="productCategory" class="form-label fw-semibold">
                    <i class="fas fa-list me-2 text-primary"></i>Category<span style="color: red">*</span>
                    </label>
                    <select class="form-select" id="productCategory" name="categories" onchange="checkCategory()" required>
                    <?php
                    foreach ($categories as $crow){
                    ?>
                    <option <?php echo ($row['categories_id'] === $crow['id'])? "selected":"";?> value="<?php echo $crow['category'];?>"><?php echo $crow['category'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="productDesc" class="form-label fw-semibold">
                    <i class="fas fa-align-left me-2 text-primary"></i>Description<span style="color: red">*</span>
                    </label>
                    <textarea class="form-control" id="productDesc" name="description" rows="3" placeholder="Enter product details..."><?= trim($row['description']);?></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-check-circle me-1"></i>Update Product
                    </button>
                    <a href="<?php echo site_url('admin/product')?>" class="btn btn-secondary">← Back to Products</a>
                </div>
            </form>
            <?php
            }
            ?>
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
