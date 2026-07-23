<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$type = $_GET['type'] ?? '';
$active_tab = $_GET['tab'] ?? 'inbox'; // inbox | sent | drafts

include('../pulilan/adminnav.php');
?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-2 mb-3 border-bottom pb-3">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-envelope me-2"></i> Messages
            </h2>
            <a href="adminindex.php" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <?php if (!empty($type)): ?>
    <!-- ============================================================
         VIEW A SINGLE MESSAGE
    ============================================================ -->
    <?php
        mysqli_query($con, "UPDATE message_tbl SET notification_status = 'SEEN' WHERE message_id = '$type'");
        $sql3 = mysqli_query($con, "SELECT * FROM message_tbl WHERE message_id = '$type'");
        $h = mysqli_fetch_array($sql3);
        $sender = $h['user_id'] ?? null;
        $getSender = mysqli_query($con, "SELECT * FROM mainuser_acc WHERE user_id = '$sender'");
        $gg = mysqli_fetch_array($getSender);
        $senderName = $gg['name'] ?? 'Unknown';
    ?>
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0"><i class="fa fa-envelope-open me-2"></i> Message Details</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">From</label>
                    <input type="text" disabled value="<?php echo htmlspecialchars($senderName); ?>" class="form-control bg-light">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Subject</label>
                    <input type="text" disabled value="<?php echo htmlspecialchars($h['subject'] ?? ''); ?>" class="form-control bg-light">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">To</label>
                    <input type="text" disabled value="<?php echo htmlspecialchars($h['brgy_location'] ?? ''); ?>" class="form-control bg-light">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Message</label>
                    <textarea rows="6" class="form-control bg-light" disabled><?php echo htmlspecialchars($h['message'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 d-flex gap-2">
            <a href="admin_messages.php" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back to Inbox</a>
            <!-- Quick reply button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal">
                <i class="fa fa-reply me-1"></i> Reply
            </button>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fa fa-reply me-2"></i>Reply to <?php echo htmlspecialchars($senderName); ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="notification_process/admin_message_process.php">
                        <input type="hidden" name="receiver" value="<?php echo htmlspecialchars($h['brgy_location'] ?? ''); ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Subject</label>
                            <input type="text" name="subject" class="form-control" value="RE: <?php echo htmlspecialchars($h['subject'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Write your reply..." required></textarea>
                        </div>
                        <button type="submit" name="send_message" class="btn btn-primary w-100">
                            <i class="fa fa-send me-2"></i>Send Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- ============================================================
         MAIN MESSAGES VIEW — COMPOSE + TABS
    ============================================================ -->
    <div class="row g-4">

        <!-- ===== LEFT COLUMN: Compose + Drafts ===== -->
        <div class="col-lg-4">
            <!-- Compose Button -->
            <button class="btn btn-primary w-100 mb-3 shadow-sm" data-bs-toggle="collapse" data-bs-target="#composePanel" aria-expanded="false">
                <i class="fa fa-pencil-square-o me-2"></i> Compose New Message
            </button>

            <!-- Compose Panel (collapsible) -->
            <div class="collapse show" id="composePanel">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                        <h6 class="card-title mb-0"><i class="fa fa-paper-plane me-2"></i> New Message</h6>
                        <button class="btn btn-sm btn-outline-light py-0 px-2" data-bs-toggle="collapse" data-bs-target="#composePanel"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="notification_process/admin_message_process.php" id="composeForm">
                            <div class="mb-3">
                                <label for="receiver" class="form-label fw-bold text-muted small">To (Receiver)</label>
                                <input class="form-control form-control-sm" type="text" id="receiver" name="receiver" placeholder="Barangay name or location" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label fw-bold text-muted small">Subject</label>
                                <input class="form-control form-control-sm" type="text" id="subject" name="subject" placeholder="Enter subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message_body" class="form-label fw-bold text-muted small">Message</label>
                                <textarea class="form-control form-control-sm" id="message_body" name="message" placeholder="Write your message..." rows="5" required></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="send_message" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fa fa-send me-1"></i> Send
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="saveDraftBtn" title="Save Draft">
                                    <i class="fa fa-floppy-o me-1"></i> Draft
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Cards -->
            <div class="row g-2">
                <div class="col-6">
                    <div class="card border-0 shadow-sm text-center p-2" style="background:linear-gradient(135deg,#3b82f6,#6366f1)">
                        <div class="text-white" style="font-size:1.5rem;font-weight:700">
                            <?php
                                $res = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location = 'Admin'"));
                                echo $res['c'] ?? 0;
                            ?>
                        </div>
                        <div class="text-white small opacity-75">Total Received</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm text-center p-2" style="background:linear-gradient(135deg,#10b981,#059669)">
                        <div class="text-white" style="font-size:1.5rem;font-weight:700">
                            <?php
                                $res2 = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location != 'Admin'"));
                                echo $res2['c'] ?? 0;
                            ?>
                        </div>
                        <div class="text-white small opacity-75">Total Sent</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm text-center p-2" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
                        <div class="text-white" style="font-size:1.5rem;font-weight:700">
                            <?php
                                $res3 = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location = 'Admin' AND notification_status = 'UNSEEN'"));
                                echo $res3['c'] ?? 0;
                            ?>
                        </div>
                        <div class="text-white small opacity-75">Unread</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm text-center p-2" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">
                        <div class="text-white" style="font-size:1.5rem;font-weight:700" id="draftCountBadge">
                            <?php echo count(json_decode($_COOKIE['admin_drafts'] ?? '[]', true)); ?>
                        </div>
                        <div class="text-white small opacity-75">Drafts</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: Inbox / Sent / Drafts Tabs ===== -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <!-- Tab Navigation -->
                <div class="card-header bg-dark p-0">
                    <ul class="nav nav-tabs border-0 mb-0" id="messagesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-light border-0 px-4 py-3 <?php echo ($active_tab == 'inbox') ? 'active bg-primary text-white' : ''; ?>"
                                id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inboxPane" type="button" role="tab">
                                <i class="fa fa-inbox me-2"></i>Inbox
                                <?php
                                    $unread = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location='Admin' AND notification_status='UNSEEN'"))['c'] ?? 0;
                                    if ($unread > 0) echo '<span class="badge bg-danger ms-1">' . $unread . '</span>';
                                ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-light border-0 px-4 py-3 <?php echo ($active_tab == 'sent') ? 'active bg-success text-white' : ''; ?>"
                                id="sent-tab" data-bs-toggle="tab" data-bs-target="#sentPane" type="button" role="tab">
                                <i class="fa fa-send me-2"></i>Sent
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-light border-0 px-4 py-3 <?php echo ($active_tab == 'drafts') ? 'active bg-warning text-dark' : ''; ?>"
                                id="drafts-tab" data-bs-toggle="tab" data-bs-target="#draftsPane" type="button" role="tab">
                                <i class="fa fa-file-text-o me-2"></i>Drafts
                                <span class="badge bg-warning text-dark ms-1 border" id="draftTabCount"></span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="messagesTabContent">

                    <!-- ===== INBOX PANE ===== -->
                    <div class="tab-pane fade <?php echo ($active_tab == 'inbox' || $active_tab == '') ? 'show active' : ''; ?>" id="inboxPane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">From</th>
                                        <th class="py-3">Subject</th>
                                        <th class="py-3">Status</th>
                                        <th class="text-end px-4 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $inbox_query = "SELECT m.*, u.name as sender_name
                                                        FROM message_tbl m
                                                        LEFT JOIN mainuser_acc u ON m.user_id = u.user_id
                                                        WHERE m.brgy_location = 'Admin'
                                                        ORDER BY m.message_id DESC LIMIT 30";
                                        $inbox = mysqli_query($con, $inbox_query);
                                        if ($inbox && mysqli_num_rows($inbox) > 0) {
                                            while ($row = mysqli_fetch_assoc($inbox)):
                                    ?>
                                    <tr class="<?php echo ($row['notification_status'] == 'UNSEEN') ? 'table-warning fw-semibold' : ''; ?>">
                                        <td class="align-middle px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem;flex-shrink:0">
                                                    <?php echo strtoupper(substr($row['sender_name'] ?? 'U', 0, 1)); ?>
                                                </div>
                                                <span><?php echo htmlspecialchars($row['sender_name'] ?? 'Unknown'); ?></span>
                                            </div>
                                        </td>
                                        <td class="align-middle"><?php echo htmlspecialchars($row['subject'] ?? ''); ?></td>
                                        <td class="align-middle">
                                            <?php if ($row['notification_status'] == 'UNSEEN'): ?>
                                                <span class="badge bg-warning text-dark"><i class="fa fa-circle me-1" style="font-size:0.5rem;vertical-align:middle"></i>New</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Read</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end align-middle px-4">
                                            <a href="admin_messages.php?type=<?php echo htmlspecialchars($row['message_id']); ?>" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa fa-inbox fa-3x mb-3 d-block" style="opacity:.15"></i>
                                            Your inbox is empty.
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== SENT PANE ===== -->
                    <div class="tab-pane fade <?php echo ($active_tab == 'sent') ? 'show active' : ''; ?>" id="sentPane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3">To</th>
                                        <th class="py-3">Subject</th>
                                        <th class="py-3">Delivered</th>
                                        <th class="text-end px-4 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Sent messages = messages sent BY admin (user_id = admin's session or brgy_location != Admin)
                                        $sent_query = "SELECT m.*
                                                       FROM message_tbl m
                                                       WHERE m.brgy_location != 'Admin'
                                                       ORDER BY m.message_id DESC LIMIT 30";
                                        $sent = mysqli_query($con, $sent_query);
                                        if ($sent && mysqli_num_rows($sent) > 0) {
                                            while ($srow = mysqli_fetch_assoc($sent)):
                                    ?>
                                    <tr>
                                        <td class="align-middle px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem;flex-shrink:0">
                                                    <?php echo strtoupper(substr($srow['brgy_location'] ?? 'B', 0, 1)); ?>
                                                </div>
                                                <span><?php echo htmlspecialchars($srow['brgy_location'] ?? 'Unknown'); ?></span>
                                            </div>
                                        </td>
                                        <td class="align-middle"><?php echo htmlspecialchars($srow['subject'] ?? ''); ?></td>
                                        <td class="align-middle">
                                            <?php if ($srow['notification_status'] == 'SEEN'): ?>
                                                <span class="badge bg-success"><i class="fa fa-check-circle me-1"></i>Seen</span>
                                            <?php else: ?>
                                                <span class="badge bg-info text-dark"><i class="fa fa-clock-o me-1"></i>Delivered</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end align-middle px-4">
                                            <a href="admin_messages.php?type=<?php echo htmlspecialchars($srow['message_id']); ?>" class="btn btn-sm btn-outline-success">
                                                <i class="fa fa-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa fa-send fa-3x mb-3 d-block" style="opacity:.15"></i>
                                            No sent messages yet.
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== DRAFTS PANE ===== -->
                    <div class="tab-pane fade <?php echo ($active_tab == 'drafts') ? 'show active' : ''; ?>" id="draftsPane" role="tabpanel">
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small"><i class="fa fa-info-circle me-1"></i> Drafts are saved locally in your browser.</span>
                                <button class="btn btn-sm btn-outline-danger" id="clearAllDrafts"><i class="fa fa-trash me-1"></i> Clear All</button>
                            </div>
                        </div>
                        <div id="draftsList">
                            <!-- Rendered by JS from localStorage -->
                        </div>
                        <div id="noDraftsMsg" class="text-center py-5 text-muted d-none">
                            <i class="fa fa-file-text-o fa-3x mb-3 d-block" style="opacity:.15"></i>
                            No drafts saved.
                        </div>
                    </div>

                </div><!-- end tab-content -->
            </div>
        </div>
    </div><!-- end row -->
    <?php endif; ?>

</div><!-- end container-fluid -->

<!-- Drafts JavaScript -->
<script>
(function() {
    var DRAFT_KEY = 'admin_cbms_drafts';

    function getDrafts() {
        try { return JSON.parse(localStorage.getItem(DRAFT_KEY) || '[]'); } catch(e) { return []; }
    }
    function saveDrafts(drafts) {
        localStorage.setItem(DRAFT_KEY, JSON.stringify(drafts));
    }

    function renderDrafts() {
        var drafts = getDrafts();
        var list = document.getElementById('draftsList');
        var noMsg = document.getElementById('noDraftsMsg');
        var count = document.getElementById('draftTabCount');
        var countBadge = document.getElementById('draftCountBadge');
        if (count) count.textContent = drafts.length > 0 ? drafts.length : '';
        if (countBadge) countBadge.textContent = drafts.length;

        if (!list) return;
        if (drafts.length === 0) {
            list.innerHTML = '';
            if (noMsg) noMsg.classList.remove('d-none');
            return;
        }
        if (noMsg) noMsg.classList.add('d-none');

        var html = '<div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th class="px-4 py-3">To</th><th>Subject</th><th class="py-3">Saved</th><th class="text-end px-4 py-3">Actions</th></tr></thead><tbody>';
        drafts.forEach(function(d, i) {
            var savedAt = new Date(d.savedAt).toLocaleString();
            html += '<tr>' +
                '<td class="align-middle px-4">' + escHtml(d.receiver || '—') + '</td>' +
                '<td class="align-middle">' + escHtml(d.subject || '(No subject)') + '</td>' +
                '<td class="align-middle text-muted small">' + savedAt + '</td>' +
                '<td class="text-end align-middle px-4 d-flex gap-1 justify-content-end">' +
                    '<button class="btn btn-sm btn-warning text-dark load-draft" data-index="' + i + '"><i class="fa fa-edit me-1"></i>Edit</button>' +
                    '<button class="btn btn-sm btn-outline-danger delete-draft" data-index="' + i + '"><i class="fa fa-trash"></i></button>' +
                '</td>' +
            '</tr>';
        });
        html += '</tbody></table></div>';
        list.innerHTML = html;

        // Bind events
        list.querySelectorAll('.load-draft').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var draft = getDrafts()[parseInt(this.dataset.index)];
                if (!draft) return;
                document.getElementById('receiver').value = draft.receiver || '';
                document.getElementById('subject').value = draft.subject || '';
                document.getElementById('message_body').value = draft.message || '';
                // Show compose panel
                var panel = document.getElementById('composePanel');
                if (panel && !panel.classList.contains('show')) {
                    new bootstrap.Collapse(panel).show();
                }
                // Switch to inbox tab to see compose
                var inboxTab = document.getElementById('inbox-tab');
                if (inboxTab) inboxTab.click();
                alert('Draft loaded into the compose form!');
            });
        });

        list.querySelectorAll('.delete-draft').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var drafts = getDrafts();
                drafts.splice(parseInt(this.dataset.index), 1);
                saveDrafts(drafts);
                renderDrafts();
            });
        });
    }

    function escHtml(s) {
        var d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    // Save Draft button
    var saveDraftBtn = document.getElementById('saveDraftBtn');
    if (saveDraftBtn) {
        saveDraftBtn.addEventListener('click', function() {
            var receiver = document.getElementById('receiver').value.trim();
            var subject = document.getElementById('subject').value.trim();
            var message = document.getElementById('message_body').value.trim();
            if (!receiver && !subject && !message) {
                alert('Please write something before saving a draft.');
                return;
            }
            var drafts = getDrafts();
            drafts.unshift({ receiver: receiver, subject: subject, message: message, savedAt: new Date().toISOString() });
            saveDrafts(drafts);
            renderDrafts();
            // Clear form
            document.getElementById('composeForm').reset();
            alert('Draft saved!');
        });
    }

    // Clear all drafts
    var clearBtn = document.getElementById('clearAllDrafts');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (confirm('Delete all drafts?')) {
                saveDrafts([]);
                renderDrafts();
            }
        });
    }

    // Open correct tab if ?tab= in URL
    var urlParams = new URLSearchParams(window.location.search);
    var tabParam = urlParams.get('tab');
    if (tabParam) {
        var tabEl = document.getElementById(tabParam + '-tab');
        if (tabEl) { new bootstrap.Tab(tabEl).show(); }
    }

    // Initial render
    renderDrafts();
})();
</script>

<?php include('adminfooter.php'); ?>