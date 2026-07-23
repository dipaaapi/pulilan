<?php
// 1. Initialize session if not started
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

// 2. INCLUDE YOUR DATABASE CONNECTION
if (file_exists(__DIR__ . '/../config/db.php')) {
    require_once __DIR__ . '/../config/db.php';
} elseif (file_exists(__DIR__ . '/../db.php')) {
    require_once __DIR__ . '/../db.php';
}

// 3. SELF-PROCESSING FORM HANDLER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $fullname = trim(filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    $contact_info = trim(filter_input(INPUT_POST, 'contact_info', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

    if (!empty($fullname) && !empty($contact_info) && !empty($message)) {
        
        $inserted = false;

        // --- OPTION A: Using PDO ($pdo or $conn) ---
        if (isset($pdo) && $pdo instanceof PDO) {
            $stmt = $pdo->prepare("INSERT INTO message_tbl (name, email, message, date_created) VALUES (:name, :email, :message, NOW())");
            $inserted = $stmt->execute([
                ':name' => $fullname,
                ':email' => $contact_info,
                ':message' => $message
            ]);
        } 
        // --- OPTION B: Using MySQLi ($conn or $db) ---
        elseif (isset($conn) && $conn instanceof mysqli) {
            $stmt = $conn->prepare("INSERT INTO message_tbl (name, email, message, date_created) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $fullname, $contact_info, $message);
            $inserted = $stmt->execute();
        } 
        // --- OPTION C: Fallback Direct MySQLi Connection ---
        else {
            $host = 'localhost';
            $user = 'root';
            $pass = '';
            $dbname = 'pulilan';

            $fallback_conn = new mysqli($host, $user, $pass, $dbname);
            if (!$fallback_conn->connect_error) {
                $stmt = $fallback_conn->prepare("INSERT INTO message_tbl (name, email, message, date_created) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $fullname, $contact_info, $message);
                $inserted = $stmt->execute();
                $fallback_conn->close();
            }
        }

        if ($inserted) {
            $_SESSION['contact_status'] = "Thank you, {$fullname}! Your message has been sent successfully.";
            $_SESSION['contact_status_type'] = 'success';
        } else {
            $_SESSION['contact_status'] = "Failed to save message to the database. Please try again.";
            $_SESSION['contact_status_type'] = 'error';
        }

    } else {
        $_SESSION['contact_status'] = "Submission failed! Please complete all required fields.";
        $_SESSION['contact_status_type'] = 'error';
    }

    // Explicitly redirect to index.php with status and anchor
    $redirect_url = "index.php?status=" . $_SESSION['contact_status_type'] . "#section4";

    // Safe Redirect (Handles case where headers were already sent by index.php)
    if (headers_sent()) {
        echo "<script>window.location.href = '$redirect_url';</script>";
        exit();
    } else {
        header("Location: " . $redirect_url);
        exit();
    }
}

// 4. DETECT TOAST MESSAGE FROM SESSION OR GET PARAMS
$toast_type = '';
$toast_message = '';

if (isset($_SESSION['contact_status'])) {
    $toast_type = $_SESSION['contact_status_type'] ?? 'info';
    $toast_message = $_SESSION['contact_status'];
    unset($_SESSION['contact_status'], $_SESSION['contact_status_type']);
} elseif (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $toast_type = 'success';
            $toast_message = 'Thank you! Your message has been sent successfully.';
            break;
        case 'error':
        case 'failed':
            $toast_type = 'error';
            $toast_message = 'Submission failed! Please check your details and try again.';
            break;
        case 'canceled':
        case 'cancelled':
            $toast_type = 'warning';
            $toast_message = 'Form submission was canceled.';
            break;
    }
}
?>

<style>
    /* ==========================================
       CONTACT SECTION STYLES
    ========================================== */
    .contact-v2-section {
        padding: 90px 20px;
        background: #f8fafc;
        position: relative;
    }

    body.night-mode .contact-v2-section {
        background: #090d16 !important;
    }

    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .contact-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 50px;
    }

    .contact-header h2 {
        font-size: 2.3rem;
        font-weight: 800;
        color: #0f172a !important;
        margin-bottom: 12px;
    }

    .contact-header p {
        color: #64748b !important;
        font-size: 1rem;
    }

    /* Grid Layout for Form & Map */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
    }

    .contact-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.05);
    }

    body.night-mode .contact-card {
        background: #0f172a;
        border-color: #1e293b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: #334155 !important;
        margin-bottom: 8px;
    }

    body.night-mode .form-group label {
        color: #cbd5e1 !important;
    }

    .form-control-input {
        width: 100%;
        padding: 12px 18px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #0f172a;
        font-size: 0.95rem;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    body.night-mode .form-control-input {
        background: #1e293b;
        border-color: #334155;
        color: #f8fafc;
    }

    .form-control-input:focus {
        outline: none;
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
    }

    body.night-mode .form-control-input:focus {
        background: #0f172a;
    }

    .contact-btn-group {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-submit {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .btn-cancel {
        background: transparent;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* Embedded Map Styling */
    .map-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 16px;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.05);
        height: 100%;
        min-height: 480px;
        display: flex;
        flex-direction: column;
    }

    body.night-mode .map-card {
        background: #0f172a;
        border-color: #1e293b;
    }

    .map-card iframe {
        width: 100%;
        height: 100%;
        min-height: 440px;
        border: 0;
        border-radius: 16px;
    }

    body.night-mode .map-card iframe {
        filter: grayscale(80%) invert(90%) hue-rotate(180deg);
    }

    /* ==========================================
       UPPER-RIGHT TOAST NOTIFICATION SYSTEM
    ========================================== */
    .toast-container {
        position: fixed;
        top: 90px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .toast-notif {
        pointer-events: auto;
        min-width: 320px;
        max-width: 420px;
        padding: 14px 18px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .toast-notif.hide {
        animation: toastSlideOut 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toast-icon {
        font-size: 1.3rem;
        line-height: 1;
    }

    .toast-message {
        font-size: 0.88rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .toast-close-btn {
        background: transparent;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .toast-close-btn:hover {
        opacity: 1;
    }

    .toast-success {
        background: rgba(240, 253, 244, 0.95);
        border-color: #86efac;
        color: #14532d;
    }

    .toast-error {
        background: rgba(254, 242, 242, 0.95);
        border-color: #fca5a5;
        color: #7f1d1d;
    }

    .toast-warning {
        background: rgba(254, 252, 232, 0.95);
        border-color: #fde047;
        color: #713f12;
    }

    body.night-mode .toast-success {
        background: rgba(20, 83, 45, 0.92);
        border-color: #15803d;
        color: #f0fdf4;
    }

    body.night-mode .toast-error {
        background: rgba(127, 29, 29, 0.92);
        border-color: #991b1b;
        color: #fef2f2;
    }

    body.night-mode .toast-warning {
        background: rgba(113, 63, 18, 0.92);
        border-color: #854d0e;
        color: #fefce8;
    }

    body.night-mode .toast-close-btn {
        color: #ffffff;
    }

    @keyframes toastSlideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes toastSlideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .map-card {
            min-height: 350px;
        }

        .map-card iframe {
            min-height: 320px;
        }
    }

    @media (max-width: 600px) {
        .toast-container {
            right: 12px;
            left: 12px;
            top: 80px;
        }

        .toast-notif {
            min-width: unset;
            width: 100%;
        }
    }
</style>

<!-- Floating Toast Container -->
<div class="toast-container" id="toastContainer">
    <?php if (!empty($toast_message)): ?>
        <?php
            $icon = 'ℹ️';
            if ($toast_type === 'success') $icon = '✅';
            if ($toast_type === 'error') $icon = '⚠️';
            if ($toast_type === 'warning') $icon = '🚫';
        ?>
        <div class="toast-notif toast-<?php echo htmlspecialchars($toast_type); ?>" id="contactToast">
            <div class="toast-content">
                <span class="toast-icon"><?php echo $icon; ?></span>
                <span class="toast-message"><?php echo htmlspecialchars($toast_message); ?></span>
            </div>
            <button type="button" class="toast-close-btn" onclick="dismissToast(this.parentElement)">&times;</button>
        </div>
    <?php endif; ?>
</div>

<!-- Contact Section Container (#section4 matches the navbar anchor) -->
<section id="section4" class="contact-v2-section">
    <div class="contact-container">
        <div class="contact-header">
            <h2>Get in Touch with Town Hall</h2>
            <p>Have questions about registration or municipal assistance? Send us a message directly or visit our office.</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Form (Self-Submitting) -->
            <div class="contact-card">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>#section4" method="POST">
                    <input type="hidden" name="contact_submit" value="1">

                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-control-input" placeholder="e.g., Juan Cruz" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address / Contact Number</label>
                        <input type="text" id="email" name="contact_info" class="form-control-input" placeholder="e.g., juan@example.com or 0917XXXXXXX" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message / Inquiry</label>
                        <textarea id="message" name="message" rows="5" class="form-control-input" placeholder="How can we assist you today?" required></textarea>
                    </div>

                    <div class="contact-btn-group">
                        <button type="submit" class="btn-submit">Send Message</button>
                        <button type="button" class="btn-cancel" onclick="triggerCancelToast()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Embedded Google Map -->
            <div class="map-card">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.2482431776947!2d120.84656637590858!3d14.901529169002237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339655e8c1ab5047%3A0x6b4ef84c71ef66b1!2sPulilan%20Municipal%20Hall!5e0!3m2!1sen!2sph!4v1700000000000!5m2!1sen!2sph" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<script>
function dismissToast(toastElement) {
    if (!toastElement) return;
    toastElement.classList.add('hide');
    setTimeout(() => {
        if (toastElement.parentNode) {
            toastElement.remove();
        }
    }, 350);
}

function triggerCancelToast() {
    showToast('warning', 'Form submission was canceled.', '🚫');
}

function showToast(type, message, icon) {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast-notif toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <span class="toast-icon">${icon}</span>
            <span class="toast-message">${message}</span>
        </div>
        <button type="button" class="toast-close-btn" onclick="dismissToast(this.parentElement)">&times;</button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        dismissToast(toast);
    }, 4000);
}

document.addEventListener('DOMContentLoaded', function() {
    const initialToast = document.getElementById('contactToast');
    if (initialToast) {
        setTimeout(() => {
            dismissToast(initialToast);
        }, 4000);
    }
});
</script>