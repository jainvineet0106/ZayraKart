<?php
include APPPATH . 'Views/backend/include/header.php';
?>

<body class="d-flex flex-column min-vh-100" style="background-color: #f8f9fa;">

    <!-- Sidebar -->
    <?php include APPPATH . 'Views/backend/include/sidebar.php'; ?>

    <!-- Main -->
    <div class="content flex-grow-1" id="content_slide">
        <!-- Header -->
        <?php include APPPATH . 'Views/backend/include/head.php'; ?>

        <?php if(session()->getFlashdata('error')):?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="container mt-4 mb-5">
            <div class="card shadow-lg p-4 border-0"
                style="border-radius: 20px; background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff;">
                <h2 class="mb-4 text-warning">Add New Staff</h2>

                <form action="<?= site_url('admin/staffadd')?>" method="POST"
                    class="row g-3" enctype="multipart/form-data">

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control"
                            placeholder="Enter Full Name" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="staff@email.com" required>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" name="phone" id="phone" class="form-control"
                            placeholder="Mobile number" required>
                    </div>

                    <!-- Change salary -->
                    <div class="col-md-6">
                        <label class="form-label">Salary</label>
                        <input type="number" name="salary" class="form-control"
                            placeholder="Enter salary" required>
                    </div>

                    <!-- Profile Image Upload -->
                    <div class="col-md-6">
                        <label for="profile_pic" class="form-label">Profile Image</label>
                        <input type="file" name="profile_pic" id="profile_pic" class="form-control">
                        <input type="hidden" name="compressed_image" id="compressedImage">
                    </div>
                    
                    <!-- Upload documents -->
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Documents</label>
                        
                        <div id="documentsContainer">
                            <input type="file" name="documents[]" id="documents" class="form-control" required>
                        </div>
                        <!-- Add new document button -->
                        <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addDocuments()">
                            <i class="bi bi-plus-circle"></i> Add New Document
                        </button>
                    </div>

                    <!-- Change Password -->
                    <div class="col-md-6">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Enter New Password" required>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle-fill"></i> Update Staff
                        </button>
                        <a href="<?= site_url('admin/staff')?>"
                            class="btn btn-secondary ms-2">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
    include APPPATH . 'Views/backend/include/footer.php';
    ?>

    <script>
        document.getElementById('profile_pic').addEventListener('change', function (e) {
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

                    const compressedData = canvas.toDataURL('image/jpeg', 0.7);
                    document.getElementById('compressedImage').value = compressedData;
                };
            };
        });

        function addDocuments() {
            const container = document.getElementById('documentsContainer');
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'documents[]';
            input.className = 'form-control mb-2';
            container.appendChild(input);
        }
        function deleteDoc(id, staffid){
            let BASE_URL = "<?php echo base_url();?>";
            if(confirm('Sure To Delete This...')){
                $.ajax({
                    type: "get",
                    url: BASE_URL+"admin/deleteDocu/"+id+'/staffdocuments/'+staffid,
                    success:function(response){
                        if(response == "success")
                        {
                            $("#do-"+id).fadeOut();
                        }
                    }
                });
            }
        }
    </script>

</body>
</html>
