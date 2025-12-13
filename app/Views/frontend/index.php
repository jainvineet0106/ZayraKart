<?php
include_once 'include/header.php';
?>

<body>
    <title>ZayraKart - Online Shopping Site</title>
    <?php
    include_once 'include/head.php';
    ?>

    <section class="py-5 text-center video-section position-relative">
        <!-- Video Background -->
        <video autoplay muted playsinline class="bg-video position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
            <source src="<?php echo base_url('public/frontend/images/bg/')?>banner.mp4" type="video/mp4">
        </video>

        <!-- Overlay Content -->
        <div class="container content position-relative text-white" style="z-index: 2;">
            <h1 class="display-3 fw-bold gradient-text">Welcome to ZayraKart</h1>
            <p class="lead fs-4">Explore the latest trends and shop your favorite products.</p>
        </div>

        <!-- Optional overlay for darker effect -->
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.4); z-index:1;"></div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 text-dark">Shop by Categories</h2>
            <div class="category-scroll-container">
                <div class="category-scroll">
                    <?php
                    foreach ($categories as $category) {
                        ?>
                        <a href="<?php echo site_url('shop/').encode_id($category['id']);?>" style="text-decoration: none;">
                        <div class="category-card">
                            <div class="card border-0 shadow-sm">
                                <img src="<?php echo base_url('public/frontend/images/category_img/').$category['image'];?>" class="card-img-top" alt="<?php echo $category['category']; ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $category['category']; ?></h5>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <h2 class="text-center fw-bold mb-5 text-dark"><a href="<?php echo site_url('shop/').encode_id(0);?>" class="btn btn-danger btn-lg mt-3">Shop Now</a></h2>
            
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 text-dark">Products of the Day</h2>
            <div class="row g-4 category-scroll-container">
                <div class="category-scroll">
                    <?php 
                    foreach ($PBC as $pro) {
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card product-card border-0 shadow-sm rounded-4 h-100">
                            <div class="position-relative">
                            <img src="<?php echo base_url('public/frontend/images/Product/').$pro[0]['image'];?>" class="card-img-top rounded-top" alt="Product Image"
                                style="object-fit: cover; height: 230px; transition: transform 0.3s ease;" />
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold mb-2">
                                    <i class="fas fa-tag me-1 text-primary"></i>
                                    <?php echo $pro[0]['name']; ?>
                                </h5>
                                <p class="text-danger fs-5 fw-bold mb-3">₹<?php echo $pro[0]['amount']; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- subscribers Section -->
    <?php if(empty($user)) {?>
    <section class="py-5 text-white" style="background: linear-gradient(to right, #fc4a1a, #f7b733);">
        <div class="container text-center">
            <h2 class="fw-bold">Stay Updated!</h2>
            <p>Subscribe to our newsletter for exclusive deals and latest news.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="javascript:;" onsubmit="return subscribe()" method="post" id="subscribe" class="d-flex">
                        <input name="email" type="email" class="form-control me-2" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-dark">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>

<?php
include_once 'include/footer.php';
?>

<script>
    function subscribe(){
        let BASE_URL = "<?php echo base_url();?>"; 
        $.ajax({
          type:"post",
          url:BASE_URL+"subscribe",
          data:$("#subscribe").serialize(),
          success:function(response){
            if(response === 'true')
            {
              alert("You're subscribed! We'll keep you updated with our best products and special offers.");
            }
            else{
                alert(response);
            }
            document.getElementById('subscribe').reset();
          }
        })
    }
</script>


</body>
</html>