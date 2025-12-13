<style>
.modal-header {
    background-color: #0d6efd;
    color: white;
}
.form-control:focus {
    box-shadow: none;
    border-color: #0d6efd;
}
</style>
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">User Login</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="javascript:;" onsubmit="return login();" id="userlogin" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" required placeholder="Enter email" autofocus>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required placeholder="Enter password">
          </div>
          <!-- <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div> -->
          <!-- <div class="text-end mb-3">
            <a href="#" class="small">Forgot password?</a>
          </div> -->
          <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
        </div>
        <div class="modal-footer text-center">
          <p class="mb-0 w-100">Don't have an account?
            <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Create Account</a>
          </p>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="registerModalLabel">Create Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="javascript:;" id="userregistration" onsubmit="return registration();" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" required placeholder="Enter your name">
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" required placeholder="Enter email">
          </div>
          <div class="mb-3">
            <label class="form-label">Mobile Number</label>
            <input type="tel" class="form-control" name="mobile" required placeholder="Enter mobile">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required placeholder="Create password">
          </div>
          <button type="submit" class="btn btn-success w-100">Create Account</button>
        </div>
        <div class="modal-footer text-center">
          <p class="mb-0 w-100">Already have an account?
            <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
          </p>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  function openLogin() {
    var registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
    if(registerModal){
        registerModal.hide();
    }

    // Thoda delay ke baad login modal show karo
    setTimeout(function(){
        var loginModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal'));
        loginModal.show();
    }, 500);

  }
    function login(){
      let BASE_URL = "<?php echo base_url();?>";
        $.ajax({
          type:"post",
          url:BASE_URL + "login_here",
          data:$("#userlogin").serialize(),
          success:function(response){
            if(response === "true")
            {
              window.location.reload();
            }else{
              alert(response);
            }
          }
        })
    }
    function registration(){
      let BASE_URL = "<?php echo base_url();?>";
        $.ajax({
          type:"post",
          url:BASE_URL + "registration_here",
          data:$("#userregistration").serialize(),
          success:function(response){
            if(response === "true")
            {
              alert("Account Created successfully!");
              openLogin();
            }
            else{
              if(response == "Account already exists"){
                openLogin();
              }
              alert(response);
            }
          }
        })
    }
</script>