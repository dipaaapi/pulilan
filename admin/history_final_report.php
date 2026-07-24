<?php  
include __DIR__ . '/navbar.php';
?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-archive me-2"></i> History of Final Reports
            </h2>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="card-title mb-0">Generate Report by Year</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="../final_report.php" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="year" class="form-label">Select Year:</label>
                    <input type="number" class="form-control" name="year" id="year" placeholder="e.g., <?php echo date('Y'); ?>" min="2000" max="2099" step="1" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="filter" id="filter" class="btn btn-primary"><i class="fa fa-filter me-2"></i>Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>