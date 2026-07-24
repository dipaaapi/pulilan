<?php
include('navbar.php');
?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-bar-chart me-2"></i> Barangay Answer Reports
            </h2>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="brgyAnswerTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Brgy. Location</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $results = mysqli_query($connection, "SELECT * FROM brgy_q WHERE type = 'official' AND visibility = '0'");
                        while ($row = mysqli_fetch_assoc($results)):
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['position']); ?></td>
                            <td><?php echo htmlspecialchars($row['brgy_location']); ?></td>
                            <td class="text-end">
                                <a href="brgyanswer.php?user_id=<?php echo htmlspecialchars($row['user_id']); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fa fa-eye me-1"></i> View Answer
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