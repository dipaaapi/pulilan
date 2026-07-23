<?php
session_start();

// If already logged in, redirect to proper dashboard
if (isset($_SESSION['username'])) {
    $type = $_SESSION['type'] ?? '';
    if ($type === 'admin')     { header("location: adminindex.php"); exit(); }
    if ($type === 'official')  { header("location: brgyindex.php");  exit(); }
    if ($type === 'resident')  { header("location: residentindex.php"); exit(); }
    if ($type === 'dilg')      { header("location: dilgindex.php");  exit(); }
    if ($type === 'executive') { header("location: executiveindex.php"); exit(); }
}

$error_message = '';
$success_message = '';

// Process initial registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $contact   = trim($_POST['contact'] ?? '');
    $password  = trim($_POST['password'] ?? '');
    $cpassword = trim($_POST['cpassword'] ?? '');
    $type      = trim($_POST['type'] ?? 'resident');

    // Validation para sa mga essential registration fields lamang
    if (empty($username) || empty($email) || empty($contact) || empty($password) || empty($cpassword) || empty($type)) {
        $error_message = 'Please fill in all required fields to proceed.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } elseif ($password !== $cpassword) {
        $error_message = 'Passwords do not match. Please try again.';
    } elseif (strlen($password) < 6) {
        $error_message = 'Password must be at least 6 characters long.';
    } else {
        require_once('pulilan_db_connect.php');

        if (!isset($connection) || !$connection) {
            $error_message = 'Database connection failed.';
        } else {
            // Check if username already exists
            $check_stmt = $connection->prepare("SELECT user_id FROM mainuser_acc WHERE username = ?");
            if ($check_stmt) {
                $check_stmt->bind_param("s", $username);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {
                    $error_message = 'Username is already taken. Please choose another one.';
                } else {
                    $check_stmt->close();

                    /* 
                     * ANTICIPATED FIX: 
                     * Ibinigay ang lahat ng posibleng NOT NULL fields na walang default value sa database 
                     * (tulad ng name, gender, brgy_id, brgy_location, position, atbp.) ng may default safe values 
                     * para hindi mag-throw ng mysqli_sql_exception. Maaari na lamang itong i-edit sa loob ng profile.
                     */
                    $default_name          = $username; // Pwedeng gamitin muna ang username as placeholder name
                    $default_gender        = 'Not Specified';
                    $default_brgy_id       = 0;
                    $default_brgy_location = 'Unassigned';
                    $default_position      = 'Resident';
                    $default_activate      = '0';

                    $insert_stmt = $connection->prepare("INSERT INTO mainuser_acc (username, email, contact, password, type, name, gender, brgy_id, brgy_location, position, activate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    if ($insert_stmt) {
                        $insert_stmt->bind_param(
                            "sssssssisss", 
                            $username, 
                            $email, 
                            $contact, 
                            $password, 
                            $type, 
                            $default_name, 
                            $default_gender, 
                            $default_brgy_id, 
                            $default_brgy_location, 
                            $default_position, 
                            $default_activate
                        );

                        if ($insert_stmt->execute()) {
                            $success_message = 'Registration successful! You may now sign in.';
                        } else {
                            $error_message = 'An error occurred during registration: ' . $connection->error;
                        }
                        $insert_stmt->close();
                    } else {
                        $error_message = 'SQL prepare failed: ' . $connection->error;
                    }
                }
            } else {
                $error_message = 'SQL prepare failed: ' . $connection->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — CBMS Pulilan</title>
    <meta name="description" content="Register an account for the Community-Based Monitoring System of Pulilan, Bulacan.">

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
        .input-group-wrap .form-control,
        .input-group-wrap .form-select {
            padding-left: 42px !important;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            height: 50px;
            font-size: 0.925rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #0f172a;
            background-color: #fff;
        }
        .input-group-wrap .form-control:focus,
        .input-group-wrap .form-select:focus {
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
        .alert-success-login {
            border-radius: 12px;
            border: 1.5px solid #86efac;
            background: #f0fdf4;
            color: #15803d;
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

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #cbd5e1;
            font-size: 0.8rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

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
        <div class="hero-logo">
            <img src="assets/img/pulilan-logo.png" alt="Pulilan Logo" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fa fa-building fa-3x\' style=\'color:rgba(255,255,255,0.8)\'></i>';">
        </div>
        <h1 class="hero-title">CBMS Pulilan</h1>
        <p class="hero-subtitle">
            Community-Based Monitoring System for Pulilan, Bulacan. Centralized data management for barangays and residents.
        </p>
        <div class="hero-badges">
            <span class="hero-badge"><i class="fa fa-shield"></i> Secure Access</span>
            <span class="hero-badge"><i class="fa fa-database"></i> Centralized Data</span>
            <span class="hero-badge"><i class="fa fa-users"></i> Multi-Role</span>
        </div>
    </div>

    <!-- FORM PANEL -->
    <div class="login-form-panel">
        <div class="login-box">

            <div class="brand-mark">
                <img src="assets/img/pulilan-logo.png" alt="Logo" onerror="this.style.display='none'">
                <span>CBMS Pulilan</span>
            </div>

            <h2>Create account</h2>
            <p class="tagline">Register your account details to get started.</p>

            <?php if (!empty($error_message)): ?>
            <div class="alert-login" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
            <div class="alert-success-login" role="alert">
                <i class="fa fa-check-circle"></i>
                <?php echo htmlspecialchars($success_message); ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="registration.php" autocomplete="on" novalidate>

                <!-- Username -->
                <div class="mb-2">
                    <label for="username" class="form-label-custom">
                        <span>Username</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-user input-icon"></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Choose a username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" autocomplete="username" required>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mb-2">
                    <label for="email" class="form-label-custom">
                        <span>Email Address</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" autocomplete="email" required>
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="mb-2">
                    <label for="contact" class="form-label-custom">
                        <span>Contact Number</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-phone input-icon"></i>
                        <input type="text" id="contact" name="contact" class="form-control" placeholder="e.g. 09123456789" value="<?php echo htmlspecialchars($_POST['contact'] ?? ''); ?>" autocomplete="tel" required>
                    </div>
                </div>

                <!-- Account Type / Role -->
                <div class="mb-2">
                    <label for="type" class="form-label-custom">
                        <span>Account Type</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-users input-icon"></i>
                        <select id="type" name="type" class="form-select" required>
                            <option value="" disabled <?php echo empty($_POST['type']) ? 'selected' : ''; ?>>Select account type</option>
                            <option value="resident" <?php echo (($_POST['type'] ?? '') === 'resident') ? 'selected' : ''; ?>>Resident</option>
                            <option value="official" <?php echo (($_POST['type'] ?? '') === 'official') ? 'selected' : ''; ?>>Barangay Official</option>
                            <option value="admin" <?php echo (($_POST['type'] ?? '') === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="dilg" <?php echo (($_POST['type'] ?? '') === 'dilg') ? 'selected' : ''; ?>>DILG</option>
                            <option value="executive" <?php echo (($_POST['type'] ?? '') === 'executive') ? 'selected' : ''; ?>>Executive</option>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="form-label-custom">
                        <span>Password</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create a password (min. 6 chars)" autocomplete="new-password" required>
                        <button type="button" class="toggle-pass" id="togglePass" title="Show/hide password" aria-label="Toggle password visibility">
                            <i class="fa fa-eye" id="togglePassIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="cpassword" class="form-label-custom">
                        <span>Confirm Password</span>
                        <span class="badge-req badge-required">Required</span>
                    </label>
                    <div class="input-group-wrap">
                        <i class="fa fa-lock input-icon"></i>
                        <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Confirm your password" autocomplete="new-password" required>
                        <button type="button" class="toggle-pass" id="toggleCPass" title="Show/hide password" aria-label="Toggle confirm password visibility">
                            <i class="fa fa-eye" id="toggleCPassIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-login" id="registerBtn">
                    <i class="fa fa-user-plus me-2"></i> Register Account
                </button>

            </form>

            <div class="divider">or</div>

            <div class="login-footer">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>

            <p class="copyright">
                &copy; <?php echo date('Y'); ?> CBMS Pulilan &mdash; All rights reserved.
            </p>

        </div>
    </div>

</div>

<!-- Bootstrap 5 JS -->
<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
<script>
    document.getElementById('togglePass').addEventListener('click', function () {
        var pwd = document.getElementById('password');
        var icon = document.getElementById('togglePassIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.className = 'fa fa-eye-slash';
        } else {
            pwd.type = 'password';
            icon.className = 'fa fa-eye';
        }
    });

    document.getElementById('toggleCPass').addEventListener('click', function () {
        var pwd = document.getElementById('cpassword');
        var icon = document.getElementById('toggleCPassIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.className = 'fa fa-eye-slash';
        } else {
            pwd.type = 'password';
            icon.className = 'fa fa-eye';
        }
    });
</script>

</body>
</html>