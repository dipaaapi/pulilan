<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$done = $_GET['done'] ?? '';

include('navbar.php');
?>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-file-text me-2"></i> Memos
            </h2>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <?php if ($done == "memo"): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>Success!</strong> Memo was created successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Create Memo Form -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fa fa-plus me-2"></i> Create New Memo</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="../achievment/create_memo.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Memo Name / Memo No</label>
                            <input type="text" name="memo" class="form-control" placeholder="e.g. Memo No. 2024-001" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Memo Body</label>
                            <textarea name="memo_body" class="form-control" placeholder="Enter memo content..." rows="7" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="receiver" class="form-label fw-bold text-muted">Receiver</label>
                            <select name="receiver" id="receiver" class="form-select" required>
                                <option value="" disabled selected>- Select a Receiver -</option>
                                <?php
                                    // Fetch officials from the database to populate the dropdown
                                    $officials_query = mysqli_query($connection, "SELECT name FROM mainuser_acc WHERE type IN ('official', 'dilg', 'executive') ORDER BY name ASC");
                                    while ($official = mysqli_fetch_assoc($officials_query)) {
                                        echo '<option value="' . htmlspecialchars($official['name']) . '">' . htmlspecialchars($official['name']) . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="picture" class="form-label fw-bold text-muted">Attachment <span class="text-muted fw-normal">(Images or PDF only)</span></label>
                            <input type="file" name="picture" id="picture" class="form-control" accept="image/*,application/pdf">
                        </div>
                        <button type="submit" name="send_memo" class="btn btn-info text-white w-100">
                            <i class="fa fa-upload me-2"></i> Create Memo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Memo List -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0"><i class="fa fa-list me-2"></i> All Memos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Memo / Project Name</th>
                                    <th class="py-3">Status</th>
                                    <th class="text-end px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $view_memo_query = mysqli_query($connection, "SELECT * FROM memo ORDER BY memo_id DESC");
                                    $memo_count = $view_memo_query ? mysqli_num_rows($view_memo_query) : 0;
                                    if ($memo_count > 0) {
                                        while ($view_m = mysqli_fetch_array($view_memo_query)):
                                ?>
                                <tr>
                                    <td class="align-middle px-4"><?php echo htmlspecialchars($view_m['project_name'] ?? ''); ?></td>
                                    <td class="align-middle">
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($view_m['memo_status'] ?? ''); ?></span>
                                    </td>
                                    <td class="text-end align-middle px-4">
                                        <a href="memo.php?view=<?php echo htmlspecialchars($view_m['memo_id']); ?>" class="btn btn-sm btn-primary shadow-sm">
                                            <i class="fa fa-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; } else { ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="fa fa-folder-open fa-3x mb-3 d-block" style="opacity:.2;"></i>
                                        No memos found. Create your first memo!
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>