<?php include 'include/header.php';?>

<?php 
foreach($user as $use){
    $name = $use['name'];
    $email = $use['email'];
    $mobile = $use['mobile'];
}
?>

<body>
<div class="container">
  <div class="edit-card">
    <div class="edit-header">
      <h3>Edit Profile</h3>
      <p class="text-muted"><?php echo $email;?></p>
    </div>

    <form action="<?php echo site_url('editprofile')?>" id="editProfileForm" method="POST">
      <div class="mb-3">
        <label class="form-label"><i class="bi bi-person-fill me-2"></i>Full Name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $name;?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email</label>
        <input type="email" class="form-control" name="email" value="<?php echo $email;?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="bi bi-telephone-fill me-2"></i>Mobile</label>
        <input 
          type="tel" 
          class="form-control" 
          name="mobile" 
          value="<?= $mobile; ?>" 
          required 
          maxlength="10" 
          pattern="[0-9]{10}" 
          title="Enter a valid 10-digit mobile number"
          placeholder="Enter 10-digit mobile number">
      </div>
      
      <div class="mb-3">
        <label class="form-label"><i class="bi bi-lock-fill me-2"></i>Change Password</label>
        <input type="password" class="form-control" name="password" value="" placeholder="Enter New Password" >
        <small>Leave Blank if you don't want to change the password</small>
      </div>
      
      <div class="d-flex justify-content-between align-items-center">
        <a href="javascript:history.back()" class="btn btn-primary d-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
        <button type="submit" class="btn btn-primary save-btn">💾 Save Changes</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>

