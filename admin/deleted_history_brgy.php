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
                <i class="fa fa-archive me-2"></i> Archived Barangay Accounts
            </h2>
            <a href="brgylist_table.php" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to Accounts
            </a>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="archivedTable">
                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Brgy location</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Date Archived</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $show_record = "SELECT * FROM brgydetails_tbl WHERE visibility = 1 ORDER BY archived_date DESC";
                        $show_record_query = mysqli_query($con, $show_record);
                        if ($show_record_query && mysqli_num_rows($show_record_query) > 0):
                            while ($result = mysqli_fetch_assoc($show_record_query)):
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['brgydetails_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['brgy_location']); ?></td>
                            <td><?php echo htmlspecialchars($result['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($result['username']); ?></td>
                            <td><?php echo htmlspecialchars(date('M d, Y h:i A', strtotime($result['archived_date']))); ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-success" href="actions/restore_brgy.php?brgydetails_id=<?php echo $result['brgydetails_id']; ?>" onclick="return confirm('Are you sure you want to restore this account?');">
                                    <i class="fa fa-undo me-1"></i> Restore
                                </a>
                                <a class="btn btn-sm btn-danger" href="actions/permanent_delete_brgy.php?brgydetails_id=<?php echo $result['brgydetails_id']; ?>" onclick="return confirm('PERMANENT DELETE: This action cannot be undone. Are you absolutely sure?');">
                                    <i class="fa fa-trash me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No archived accounts found.</td>
                        </tr>
                        <?php endif; ?>
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
    $('#archivedTable').DataTable({
        "order": [[ 4, "desc" ]], // Default sort by date archived descending
        "language": {
            "search": "Search in table:",
            "paginate": {
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>