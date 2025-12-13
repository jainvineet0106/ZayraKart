<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Page</title>
  <link rel="icon" href="<?php echo base_url();?>public/frontend/assets/images/favicon.png"/>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body, html {
      height: 100%;
      margin: 0;
      background: url('<?php echo base_url()?>public/backend/images/loginbg3.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .card {
      width: 100%;
      max-width: 400px;
      padding: 30px;
      border-radius: 15px;
      background-color: rgba(20, 20, 20, 0.85);
      color: #fff;
      box-shadow: 0 4px 20px rgba(0,0,0,0.6);
    }

    .form-label {
      color: #ccc;
    }

    .form-control {
      border-radius: 10px;
      background-color: #2a2a2a;
      border: 1px solid #444;
      color: #fff;
    }

    .form-control:focus {
      background-color: #333;
      color: #fff;
      border-color: #666;
      box-shadow: none;
    }

    .form-control::placeholder {
      color: #aaa;
    }

    .btn-primary {
      border-radius: 10px;
      background-color: #4f46e5;
      border: none;
    }

    .btn-primary:hover {
      background-color: #4338ca;
    }

    .bottom-text a {
      color: #a5b4fc;
      text-decoration: none;
    }

    .bottom-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg bg-dark bg-opacity-75 text-white rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-info">
          <i class="bi bi-info-circle-fill me-2"></i> Notice
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-light">
        <?= session()->getFlashdata('error1') ?>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-info px-4 rounded-3 text-white fw-semibold shadow-sm" data-bs-dismiss="modal">
          Okay
        </button>
      </div>
    </div>
  </div>
</div> -->

  <div class="container-fluid login-container">
    <div class="card">
      <h3 class="text-center mb-4">Login</h3>
      <form action="<?php echo site_url('staff');?>" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">ID : </label>
          <input name="id" type="text" class="form-control" id="email" placeholder="Enter ID" required autofocus/>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input  name="password" type="password" class="form-control" id="password" placeholder="Enter password" required />
        </div>
        <div class="d-grid">
          <button type="submit" name="submit" class="btn btn-primary">Login</button>
          <a type="button" href="<?php echo site_url('/')?>" class="btn btn-outline-secondary btn-lg mt-2">
            Back
          </a>
        </div>
      </form>
    </div>
  </div>


  
  <!-- Bootstrap JS (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php //if (session()->getFlashdata('error1')): ?>
  <!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
      const loginUser = document.getElementById("loginUser");
      const infoModalEl = document.getElementById('infoModal');
      var myModal = new bootstrap.Modal(infoModalEl);
      myModal.show();
      infoModalEl.addEventListener('hidden.bs.modal', function () {
          loginUser.focus();
      });
    });
    </script> -->
    <?php //endif; ?>
</body>
</html>
