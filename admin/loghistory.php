<?php
include __DIR__ . '/navbar.php';
?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-history me-2"></i> Log History
            </h2>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="logHistoryTable">
                    <thead class="table-light">
                        <tr>
                            <th>Log ID</th>
                            <th>Username</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $show_record_query = mysqli_query($connection, "SELECT * FROM loghistory ORDER BY log_id DESC");
                        if ($show_record_query && mysqli_num_rows($show_record_query) > 0) {
                            while ($result = mysqli_fetch_assoc($show_record_query)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['log_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['username']); ?></td>
                            <td><?php echo htmlspecialchars($result['datetime']); ?></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="3" class="text-center">No log history found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>