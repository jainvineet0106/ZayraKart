<?php
include_once 'include/header.php';
?>

<body class="d-flex flex-column min-vh-100" style="padding-top: 75px;">
    <title>ZayraKart - Shop</title>
    <div class="content flex-grow-1">
      <?php 
      include_once 'include/head.php';
      ?>
      <div class="main_container">
        <?php
        include_once 'include/sidebar.php';
        ?>

        <div class="products_container">
          <?php
            foreach ($products as $product) {
              $product['description'] = str_replace("_","'",$product['description']);
          ?>
          <div class="card shadow-sm my-4 mx-3" style="width: 18rem; border-radius: 15px;">
            <img src="<?php echo base_url('public/frontend/images/Product/').$product['image'];?>" 
              class="card-img-top" 
              alt="Product Image" 
              style="height: 180px; object-fit: contain; border-top-left-radius: 15px; border-top-right-radius: 15px;">

            <div class="card-body">
              <h5 class="card-title"><?php echo $product['name'];?></h5>
              <p class="card-text text-muted mb-2"><?php echo $product['description'];?></p>
              <h6 class="text-danger mb-3">₹<?php echo $product['amount'];?></h6>
              <?php include "productbtn.php";?>              
            </div>
          </div>
          <?php
          }
          ?>
          
        </div>
      </div>

    </div>

<?php 
include_once 'include/footer.php';
?>
<script>
  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('sidebar-hidden');
  });
</script>

</body>
</html>

