<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

include('navbar.php');
?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="mt-3 mb-3 border-bottom pb-2 text-secondary">
                <i class="fa fa-dashboard me-2"></i> Dashboard
            </h2>
        </div>
    </div>

    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fa fa-folder-open me-2"></i> Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-md-6 col-xl-3">
            <a href="admin_messages.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 text-center p-3 bg-primary text-white">
                    <div class="card-body">
                        <i class="fa fa-envelope fa-3x mb-3"></i>
                        <h5 class="card-title">Messages</h5>
                        <p class="card-text small opacity-75">View and send messages to barangays.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="admin_memo.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 text-center p-3 bg-info text-white">
                    <div class="card-body">
                        <i class="fa fa-file-text fa-3x mb-3"></i>
                        <h5 class="card-title">Memos</h5>
                        <p class="card-text small opacity-75">Create and manage official memos.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="brgylist_table.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 text-center p-3 bg-success text-white">
                    <div class="card-body">
                        <i class="fa fa-users fa-3x mb-3"></i>
                        <h5 class="card-title">Accounts</h5>
                        <p class="card-text small opacity-75">Manage barangay & executive accounts.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="history_final_report.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 text-center p-3 bg-dark text-white">
                    <div class="card-body">
                        <i class="fa fa-bar-chart fa-3x mb-3"></i>
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text small opacity-75">View final CBMS reports.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>