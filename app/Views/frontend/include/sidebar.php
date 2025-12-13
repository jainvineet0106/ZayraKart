
<div class="toggle_container">
    <button id="sidebarToggle" class="btn text-white" style="background-color: transparent; border: none;">
    <i class="fas fa-bars" style="color: #333; font-size: 15px;"></i> 
    </button>
</div>

<div class="sidebar sidebar-hidden" id="sidebar">
    <h4>Categories</h4>
    <?php $sideid = decode_id($subpath); ?>
    <a href="<?php echo site_url('shop/').encode_id(0);?>" class="<?php echo ($sideid === '0')? 'active': '';?>">All Categories</a>
    <?php
    foreach ($categories as $row) {
    ?>
    <a href="<?php echo site_url('shop/').encode_id($row['id']);?>" class="<?php echo ($sideid === $row['id'])? 'active': '';?>"><?php echo $row['category'];?></a>
    <?php
        }
    // }
    ?>
</div>