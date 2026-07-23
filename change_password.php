<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

// Redirect kung hindi naka-login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$error_message = '';
$success_message = '';
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $currentpassword  = trim($_POST['currentpassword'] ?? '');
    $newpassword      = trim($_POST['newpassword'] ?? '');
    $confirmpassword  = trim($_POST['confirmpassword'] ?? '');
    
    if (empty($currentpassword) || empty($newpassword) || empty($confirmpassword)) {
        $error_message = 'Please fill in all password fields.';
    } elseif (strlen($newpassword) < 6) {
        $error_message = 'New password must be at least 6 characters long.';
    } elseif ($newpassword !== $confirmpassword) {
        $error_message = 'New password and confirmation do not match.';
    } else {
        $connection = mysqli_connect("localhost", "root", "", "pulilan");
        if (!$connection) {
            $error_message = 'Database connection failed: ' . mysqli_connect_error();
        } else {
            $stmt = $connection->prepare("SELECT password FROM mainuser_acc WHERE username = ?");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $currentpassworddb = $row['password'];
                    
                    if ($currentpassword === $currentpassworddb) {
                        $stmt->close();
                        
                        $update_stmt = $connection->prepare("UPDATE mainuser_acc SET password = ? WHERE username = ?");
                        if ($update_stmt) {
                            $update_stmt->bind_param("ss", $newpassword, $username);
                            if ($update_stmt->execute()) {
                                echo '<script>';
                                echo 'alert("Successfully changed!");';
                                echo 'window.location.href="brgyindex.php";';
                                echo '</script>';
                                exit();
                            } else {
                                $error_message = 'Error updating password in database.';
                            }
                            $update_stmt->close();
                        } else {
                            $error_message = 'SQL prepare failed: ' . $connection->error;
                        }
                    } else {
                        $error_message = 'Current password is incorrect.';
                        $stmt->close();
                    }
                } else {
                    $error_message = 'User account not found.';
                    $stmt->close();
                }
            } else {
                $error_message = 'SQL prepare failed: ' . $connection->error;
            }
            mysqli_close($connection);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password — CBMS Pulilan</title>
    <meta name="description" content="Change your account password for the Community-Based Monitoring System of Pulilan, Bulacan.">

    <!-- Bootstrap 5 -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --brand-primary: #1e40af;
            --brand-secondary: #3b82f6;
            --brand-accent: #60a5fa;
            --sidebar-bg: #0f172a;
            --card-radius: 20px;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: #f0f4f8;
        }

        .login-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        @media (max-width: 992px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .login-hero    { display: none; }
        }

        .login-hero {
            background: linear-gradient(145deg, #0f172a 0%, #1e3a8a 60%, #1d4ed8 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }
        .login-hero::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.15);
            pointer-events: none;
        }
        .login-hero::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(96, 165, 250, 0.1);
            pointer-events: none;
        }
        .hero-logo {
            width: 110px;
            height: 110px;
            border-radius: 24px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .hero-logo img { width: 72px; height: 72px; object-fit: contain; }
        .hero-title {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 12px;
            line-height: 1.2;
        }
        .hero-subtitle {
            color: rgba(255,255,255,0.6);
            font-size: 0.95rem;
            text-align: center;
            max-width: 320px;
            line-height: 1.6;
        }
        .hero-badges {
            display: flex;
            gap: 12px;
            margin-top: 48px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .hero-badge {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 8px 18px;
            color: rgba(255,255,255,0.75);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .login-form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #fff;
            overflow-y: auto;
        }
        .login-box {
            width: 100%;
            max-width: 440px;
        }
        .login-box .brand-mark {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .login-box .brand-mark img { width: 40px; }
        .login-box .brand-mark span {
            font-weight: 700;
            font-size: 1.1rem;
            color: #0f172a;
        }
        .login-box h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .login-box .tagline {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 24px;
        }

        .input-group-wrap {
            position: relative;
            margin-bottom: 16px;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            z-index: 5;
            pointer-events: none;
        }
        .input-group-wrap .form-control {
            padding-left: 42px !important;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            height: 50px;
            font-size: 0.925rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #0f172a;
            background-color: #fff;
        }
        .input-group-wrap .form-control:focus {
            border-color: var(--brand-secondary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
            outline: none;
        }
        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            z-index: 5;
            padding: 0;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .toggle-pass:hover { color: var(--brand-secondary); }

        .form-label-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }
        .badge-req {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .badge-required {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border: none;
            border-radius: 12px;
            height: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            color: #fff;
            width: 100%;
            margin-top: 6px;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
            color: #fff;
        }
        .btn-login:active { transform: translateY(0); }

        .alert-login {
            border-radius: 12px;
            border: 1.5px solid #fca5a5;
            background: #fff1f2;
            color: #b91c1c;
            font-size: 0.875rem;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            color: #64748b;
            font-size: 0.875rem;
        }
        .login-footer a {
            color: var(--brand-secondary);
            font-weight: 600;
            text-decoration: none;
        }
        .login-footer a:hover { text-decoration: underline; }

        .copyright {
            text-align: center;
            color: #94a3b8;
            font-size: 0.75rem;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- HERO PANEL -->
    <div class="login-hero">
        <a href="nlanding.php" class="hero-logo text-decoration-none">
            <img src="assets/img/pulilan-logo.png" alt="Pulilan Logo" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fa fa-building fa-3x\' style=\'color:rgba(255,255,255,0.8)\'></i>';">
        </a>
        <h1 class="hero-title">CBMS Pulilan</h1>
        <p class="hero-subtitle">
            Community-Based Monitoring System. Update your account security credentials securely.
        </p>
        <div class="hero-badges">
            <span class="hero-badge"><i class="fa fa-shield"></i> Secure Encryption</span>
            <span class="hero-badge"><i class="fa fa-key"></i> Password Management</span>
        </div>
    </div>

    <!-- FORM PANEL -->
    <div class="login-form-panel">
        <div class="login-box">

            <div class="brand-mark">
                <img src="assets/img/pulilan-logo.png" alt="Logo" onerror="this.style.display='none'">
                <span>CBMS Pulilan</span>
            </div>

            <h2>Change Password</h2>
            <p class="tagline">Enter your current password and choose a new one.</p>

            <?php if (!empty($error_message)): ?>
            <div class="alert-login" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="" autocomplete="off" novalidate>

                <!-- Current Password -->
                <div class="mb-3">
                    <label for="currentpassword" class="form-label-custom">
                        <span>Current Password</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" id="currentpassword" name="currentpassword" class="form-control" placeholder="Enter current password" required autofocus>
                        <button type="button" class="toggle-pass" id="toggleCurrPass" title="Show/hide password" aria-label="Toggle password visibility">
                            <i class="fa fa-eye" id="toggleCurrPassIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label for="newpassword" class="form-label-custom">
                        <span>New Password</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-key input-icon"></i>
                        <input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="Enter new password (min. 6 chars)" required>
                        <button type="button" class="toggle-pass" id="toggleNewPass" title="Show/hide password" aria-label="Toggle password visibility">
                            <i class="fa fa-eye" id="toggleNewPassIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="confirmpassword" class="form-label-custom">
                        <span>Confirm New Password</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-key input-icon"></i>
                        <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm new password" required>
                        <button type="button" class="toggle-pass" id="toggleConfPass" title="Show/hide password" aria-label="Toggle password visibility">
                            <i class="fa fa-eye" id="toggleConfPassIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-login" id="submitBtn">
                    <i class="fa fa-check-circle me-2"></i> Update Password
                </button>

            </form>

            <div class="login-footer">
                <a href="adminindex.php"><i class="fa fa-arrow-left me-1"></i> Back to Dashboard</a>
            </div>

            <p class="copyright">
                &copy; <?php echo date('Y'); ?> CBMS Pulilan &mdash; All rights reserved.
            </p>

        </div>
    </div>

</div>

<!-- Core Scripts -->
<script src="assets/plugins/jquery-1.10.2.js"></script>
<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
<script>
    // Toggle Password Visibility Helpers
    function setupToggle(buttonId, inputId, iconId) {
        document.getElementById(buttonId).addEventListener('click', function () {
            var pwd = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'fa fa-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'fa fa-eye';
            }
        });
    }

    setupToggle('toggleCurrPass', 'currentpassword', 'toggleCurrPassIcon');
    setupToggle('toggleNewPass', 'newpassword', 'toggleNewPassIcon');
    setupToggle('toggleConfPass', 'confirmpassword', 'toggleConfPassIcon');
</script>

</body>
</html>