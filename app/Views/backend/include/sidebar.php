<?php
$url = service("uri");
$paths = $url->getSegment(2);
?>

<div class="sidebar sidebar-hidden" id="sidebar">
        <h4 class="text-center mb-4">🛒 Admin Panel</h4>
        <a href="<?php echo site_url('admin/dashboard'); ?>" class="<?= ($paths == "dashboard") ? "active" : ""; ?>"><i
                        class="bi bi-speedometer2 me-2"></i>Dashboard</a>

        <a href="<?php echo site_url('admin/product'); ?>" class="<?= (
                   $paths == "product" ||
                   $paths == "addproduct" ||
                   $paths == "edit_product") ? "active" : ""; ?>">
                <i class="bi bi-box-seam me-2"></i>Products
        </a>


        <a href="<?php echo site_url('admin/order'); ?>" class="<?= ($paths == "order") ? "active" : ""; ?>">
                <i class="bi bi-cart4 me-2"></i>Orders
        </a>
        <a href="<?php echo site_url('admin/returned_orders'); ?>"
                class="<?= ($paths == 'returned_orders') ? 'active' : ''; ?>">
                <i class="bi bi-arrow-repeat me-2"></i> Returned Orders
        </a>
        <a href="<?php echo site_url('admin/staff'); ?>" class="<?= (
                   $paths == "staff" ||
                   $paths == "staffadd" ||
                   $paths == "staffedit" ||
                   $paths == "staffdetails") ? "active" : ""; ?>">
                <i class="bi bi-person-badge-fill me-2"></i>Staff
        </a>
        <a href="<?php echo site_url('admin/useraccounts'); ?>"
                class="<?= ($paths == "useraccounts") ? "active" : ""; ?>"><i class="bi bi-people me-2"></i>User
                Accounts</a>
        <a href="<?php echo site_url('admin/subscribers'); ?>"
                class="<?= ($paths == "subscribers") ? "active" : ""; ?>">
                <i class="bi bi-people-fill me-2"></i> Subscribers
        </a>

        <a href="<?php echo site_url('admin/messages'); ?>" class="<?= ($paths == "messages") ? "active" : ""; ?>"><i
                        class="bi bi-chat-dots me-2"></i>Messages</a>
        <a href="<?php echo site_url('admin/setting'); ?>" class="<?= ($paths == "setting") ? "active" : ""; ?>"><i
                        class="bi bi-gear me-2"></i>Settings</a>

        <a href="<?php echo site_url('logout'); ?>" class="nav-link text-danger mt-3"><i
                        class="bi bi-box-arrow-right me-2"></i>Logout</a>
</div>