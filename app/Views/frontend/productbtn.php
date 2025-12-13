<?php if(!empty($user)){?>
    <div class="d-flex justify-content-center gap-2">
        <button 
            type="button"
            onclick="return addtocart(<?= $product['id'];?>, <?= session()->get('userid');?>, this);" 
            class="btn btn-sm btn-outline-success"
            <?php foreach($cart as $ct){if($ct['productid'] == $product['id']){echo "disabled";break;}}?>>
            <i class="bi bi-cart-plus me-1"></i> 
            <span class="addcartbtn">
                <?php 
                    $found = false;
                    foreach($cart as $ct){
                        if($ct['productid'] == $product['id']){
                            echo "Already in Cart";
                            $found = true;
                            break;
                        }
                    }
                    if(!$found){
                        echo "Add to Cart";
                    }
                ?>
            </span>
        </button>
        <a href="<?php echo site_url('buy/').encode_id($product['id'])."/".encode_id(session()->get('userid')).'/buy' ;?>" class="btn btn-sm btn-outline-primary">Buy Now</a>
    </div>

<?php } ?>


<script>
    function addtocart(id, userid, btn){
        let BASE_URL = '<?php echo base_url();?>';
        $.ajax({
            type: "POST",
            url: BASE_URL + "addtocart",
            data: { productid: id, userid: userid },
            success: function(response) {
                if(response == "success") {
                    btn.querySelector('.addcartbtn').innerText = "Added to cart";
                    btn.classList.remove('btn-outline-success');
                    btn.classList.add('btn-success');
                    btn.setAttribute('disabled', true);
                    $("#badge-cart").text(parseInt($("#badge-cart").text()) + 1);
                }
                else
                {
                    alert(response);
                }
            }
        })
    }

</script>