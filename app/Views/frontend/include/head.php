<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="<?php echo site_url('/'); ?>">
      <img src="<?php echo base_url("public/frontend/images/bg/")?>Logo.png" alt="ZayraKart">
    </a>
    
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto ms-4">
        <?php
        $url= service("uri");
        $paths = $url->getSegment(1);
        $subpath = $url->getTotalSegments() >= 2 ? $url->getSegment(2) : null;
        ?>
        <li class="nav-item"><a class="nav-link <?php echo ($paths === '')? 'active': '';?>" href="<?php echo site_url('/');?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($paths === 'shop')? 'active': '';?>" href="<?php echo site_url('shop/').encode_id(0);?>">Shop</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($paths === 'contact')? 'active': '';?>" href="<?php echo site_url('contact');?>">Contact</a></li>
      </ul>
    </div>

    <div class="d-flex align-items-center" style="position: relative;">
      <?php
      if(!empty($user)){
      ?>
        <a href="<?php echo site_url('Cart')?>" class="icon-btn">
          <i class="bi bi-cart-fill"></i>
          <span class="badge-cart" id="badge-cart"><?php echo $total_cart;?></span>
        </a>
      <?php } ?>
      <?php
      if(empty($user))
      {
      ?>
      <a id="loginprofile" href="#" class="icon-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
        <i class="bi bi-person-circle"></i>
      </a>
      <script>profiledetail();</script>
      <?php
      }
      else{
        foreach($user as $use){
          // $userid = $use['id'];
      ?>
      <!-- User Dropdown -->
      <div class="dropdown ms-3">
        <a class="d-flex align-items-center text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?php echo base_url('public/frontend/images/useraccounts/').$use['image'];?>" 
              alt="admin" class="rounded-circle shadow-sm" width="35" height="35">
          <span class="ms-3 fw-bold text-white fs-5"><?php echo $use['name'];?></span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end custom-dropdown shadow-lg border-0 mt-3 p-3" aria-labelledby="userDropdown">
          <li>
            <a class="dropdown-item d-flex align-items-center" href="<?php echo site_url('Profile')?>">
              <i class="bi bi-person-circle me-2 fs-5 text-primary"></i>
              <span class="fw-semibold text-dark">Profile</span>
            </a>
          </li>
          <li><hr class="dropdown-divider my-2"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="<?php echo site_url('logout')?>">
              <i class="bi bi-box-arrow-right me-2 fs-5 text-danger"></i>
              <span class="fw-semibold text-danger">Logout</span>
            </a>
          </li>
        </ul>

      </div>

      <?php } } ?>
    </div>


    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    

  </div>
  <!-- <form class="d-flex search-box me-3">
    <input class="form-control shadow-sm" type="search" placeholder="Search products..." aria-label="Search">
    <button class="btn ms-2" type="submit"><i class="bi bi-search"></i></button> -->
  </form>
</nav>

<?php 
include "user.php";
?>

<style>
  .user_login{
  background-color: transparent;
  font-size: 10px;
  padding: 0;
  line-height: 1;
}
</style>