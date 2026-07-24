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
                <i class="fa fa-users me-2"></i> Barangay Accounts
            </h2>
            <a href="addbrgygrid.php" class="btn btn-sm btn-primary">
                <i class="fa fa-plus me-1"></i> Add New Barangay
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['update_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa fa-check-circle me-2"></i>
            <?php echo $_SESSION['update_success']; unset($_SESSION['update_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="brgyTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Brgy. Location</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Account Type</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($connection, "SELECT * FROM brgydetails_tbl WHERE date = null AND type = 'official' ORDER BY brgydetails_id DESC");
                        while ($result = mysqli_fetch_array($sql)):
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['brgydetails_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['brgy_location']); ?></td>
                            <td><?php echo htmlspecialchars($result['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($result['username']); ?></td>
                            <td><span class="badge bg-success"><?php echo htmlspecialchars($result['type']); ?></span></td>
                            <td class="text-end">
                                <a href="edit_brgy.php?brgydetails_id=<?php echo htmlspecialchars($result['brgydetails_id']); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fa fa-pencil-square-o me-1"></i> Edit
                                </a>
                                <a href="actions/archive_brgy.php?brgydetails_id=<?php echo htmlspecialchars($result['brgydetails_id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to archive this account?');">
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

<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<script>
$(document).ready(function() {
    $('#brgyTable').DataTable({
        "order": [[ 0, "desc" ]], // Default sort by ID descending
        "language": {
            "search": "Search in table:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>
