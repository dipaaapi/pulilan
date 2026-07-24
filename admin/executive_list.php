<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

include('navbar.php');
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-user-secret me-2"></i> Executive & DILG Accounts
            </h2>
            <a href="addexecutive_grid.php" class="btn btn-sm btn-primary">
                <i class="fa fa-plus me-1"></i> Add New Account
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="execTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Username</th>
                            <th>Account Type</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($connection, "SELECT * FROM mainuser_acc WHERE type IN ('dilg', 'executive') AND visibility = '0' ORDER BY user_id DESC");
                        while ($result = mysqli_fetch_array($sql)):
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['name']); ?></td>
                            <td><?php echo htmlspecialchars($result['gender']); ?></td>
                            <td><?php echo htmlspecialchars($result['username']); ?></td>
                            <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($result['type']); ?></span></td>
                            <td class="text-end">
                                <a href="updateresidentregistration.php?user_id=<?php echo htmlspecialchars($result['user_id']); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fa fa-pencil-square-o me-1"></i> Edit
                                </a>
                                <a href="actions/delete_acc.php?user_id=<?php echo htmlspecialchars($result['user_id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to archive this account?');">
                                    <i class="fa fa-archive me-1"></i> Archive
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
