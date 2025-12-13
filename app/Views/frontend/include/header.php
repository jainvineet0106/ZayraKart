<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo base_url();?>public/frontend/assets/images/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>public/frontend/assets/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/frontend/assets/res_style.css">
    <script>
        function profiledetail() {
            let loginBtn = document.getElementById("loginprofile");

            if (loginBtn) {
            loginBtn.classList.add("highlight-login");
            let tooltip = new bootstrap.Tooltip(loginBtn, {
                title: "Click here to Login",
                placement: "bottom",
                trigger: "manual"
            });

            setTimeout(() => {
                tooltip.show();
            }, 3000);

            setInterval(()=>{
                tooltip.show();
                // setTimeout(() => {
                //     loginBtn.classList.remove("highlight-login");
                //     tooltip.hide();
                // }, 10000);
            },7000)
            }
        };
    </script>
</head>