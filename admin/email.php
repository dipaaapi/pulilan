<?php include __DIR__ . '/../functions.php'; ?>
<?php email_send(); ?>
<?php
include __DIR__ . '/navbar.php';
?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-at me-2"></i> E-mail Utility
            </h2>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-muted">Recipient Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter recipient's email address" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold text-muted">Message</label>
                    <textarea class="form-control" id="message" name="fullname" rows="6" placeholder="Write your message here..."></textarea>
                </div>
                <button type="submit" name="send" class="btn btn-primary"><i class="fa fa-send me-2"></i>Send Email</button>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>