<?php
include_once "include/header.php";

foreach($accounts as $account){
    $name = $account['name'];
    $username = $account['username'];
    $email = $account['email'];
    $mobile = $account['mobile'];
    $address = $account['address'];
    $open = $account['open'];
    $close = $account['close'];
    $week_from = $account['week_from'];
    $week_to = $account['week_to'];
}

?>
<body>
    <title>Contact Us - ZayraKart</title>
    <?php
    include_once "include/head.php";
    ?>
    <div class="container py-5 mb-5">
        <h2 class="text-center mb-5 fw-bold">Get in Touch</h2>
        <div class="row g-4">
            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="contact-info">
                    <h5>Contact Information</h5>
                    <p id="address"><strong>Address:</strong><?php echo " ".$address;?></p>
                    <p><strong>Email:</strong><?php echo " ".$email;?></p>
                    <p><strong>Phone:</strong> +91<?php echo " ".$mobile;?></p>
                    <p><strong>Working Hours:</strong> 
                    <?php echo " ".$week_from;?> 
                    - 
                    <?php echo " ".$week_to;?> 
                    (
                        <?php
                        $opens = explode(",",$open);
                        $closes = explode(",",string: $close);
                        echo $opens[0].":".$opens[1]." ".$opens[2]." to ".$closes[0].":".$closes[1]." ".$closes[2]; 
                        ?>
                    )
                </p>
                </div>
            </div>
            <!-- Contact Form -->
            <div class="col-lg-8">
                <?php if(session()->getFlashdata('success')):?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="contact-form">
                    <form action="<?php echo site_url('/message')?>" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning text-white px-4">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h5 class="mb-3">Our Location</h5>
            <iframe id="mapFrame"
                width="100%" height="300"
                style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>

        <script>
            let locations = document.getElementById('address');
            let cleanedText = locations.innerText.split(":")[1].trim();
            const address = cleanedText;
            const query = address.replace(/\s/g, '+');
            const mapUrl = `https://maps.google.com/maps?q=${query}&t=k&z=15&output=embed`;
            document.getElementById("mapFrame").src = mapUrl;
        </script>
    </div>

<?php
include_once "include/footer.php";
?>

</body>
</html>
