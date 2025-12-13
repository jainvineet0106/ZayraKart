<?php
include_once "include/header.php";
?>

<title>Admin Panel - Orders</title>

<body>
    <?php include_once "include/sidebar.php"; ?>

    <div class="content" id="content_slide">
        <?php include_once "include/head.php"; ?>

        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="mb-0">Staff Accounts</h2>
                <a href="<?= site_url('admin/staffadd') ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Staff
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="table-dark sticky-top">
                                <tr>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Mobile</th>
                                    <th class="text-center">Salary</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($staffs): ?>
                                    <?php foreach ($staffs as $row): ?>
                                        <tr class="table-row">
                                            <td class="text-center py-3">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="<?php echo base_url('public/staff/images/') . $row['image']; ?>"
                                                        alt="User" class="rounded-circle mb-2 user-img">
                                                    <span class="fw-semibold text-dark">
                                                        <?php echo htmlspecialchars($row['name']); ?>
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="text-center"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                            <td class="text-center fw-semibold text-success">
                                                Rs.<?php echo htmlspecialchars($row['salary']); ?>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                                                    <a href="<?php echo site_url('admin/staffcard/') . encode_id($row['staffid']); ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                                        <i class="fas fa-print"></i> Print Card
                                                    </a>
                                                    <a href="<?php echo site_url('admin/staffdetails/') . encode_id($row['staffid']); ?>"
                                                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                                                        <i class="fas fa-eye"></i> View Details
                                                    </a>
                                                    <button onclick="confirmdelete(<?php echo $row['id']; ?>, 'staff', 'staff')"
                                                        class="btn btn-sm btn-danger d-flex align-items-center gap-1">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No users found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-center">
                <?php echo $pager->links('default', 'custom') ?>
            </div>
        </div>
    </div>
    <?php include_once "include/footer.php"; ?>
</body>

</html>

<style>
    /* Make table elegant and consistent */
    .table thead th {
        background-color: #212529;
        color: #fff;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    .user-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border: 3px solid #dee2e6;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .user-img:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #adb5bd;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background-color: #6c757d;
    }

    .btn {
        font-size: 0.85rem;
        border-radius: 20px;
        padding: 6px 12px;
    }

    .btn i {
        font-size: 0.9rem;
    }

    .table-row {
        border-bottom: 1px solid #eee;
    }
</style>