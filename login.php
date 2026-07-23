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

// Process login
if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error_message = 'Please enter both username and password.';
    } else {
        require_once('pulilan_db_connect.php');

        $stmt = $con->prepare("SELECT * FROM mainuser_acc WHERE username = ? AND password = ? AND activate = '0'");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row  = $result->fetch_assoc();
            $type = $row['type'];

            $_SESSION['username']  = $username;
            $_SESSION['user_id']   = $row['user_id'];
            $_SESSION['type']      = $type;
            $_SESSION['lol']       = $row['brgy_location'] ?? '';
            $_SESSION['name']      = $row['name'] ?? $username;

            if ($type === 'admin')     { header("location: adminindex.php");    exit(); }
            if ($type === 'official')  { header("location: brgyindex.php");     exit(); }
            if ($type === 'resident')  { header("location: residentindex.php"); exit(); }
            if ($type === 'dilg')      { header("location: dilgindex.php");     exit(); }
            if ($type === 'executive') { header("location: executiveindex.php"); exit(); }

            // Fallback unknown type
            $error_message = 'Your account type is not recognized. Please contact the administrator.';
        } else {
            $error_message = 'Incorrect username or password. Please try again.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — CBMS Pulilan</title>
    <meta name="description" content="Log in to the Community-Based Monitoring System of Pulilan, Bulacan.">

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

        /* ===== LAYOUT ===== */
        .login-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        @media (max-width: 768px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .login-hero    { display: none; }
        }

        /* ===== HERO PANEL ===== */
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

        /* ===== FORM PANEL ===== */
        .login-form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #fff;
        }
        .login-box {
            width: 100%;
            max-width: 420px;
        }
        .login-box .brand-mark {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
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
            margin-bottom: 32px;
        }

        /* Form Controls */
        .form-floating .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 44px 14px 16px;
            height: 58px;
            font-size: 0.925rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #0f172a;
        }
        .form-floating .form-control:focus {
            border-color: var(--brand-secondary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }
        .form-floating label {
            padding: 14px 16px;
            color: #94a3b8;
            font-size: 0.875rem;
        }
        .input-group-wrap {
            position: relative;
            margin-bottom: 18px;
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
            height: 52px;
            font-size: 0.925rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #0f172a;
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
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        /* Submit Button */
        .btn-login {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border: none;
            border-radius: 12px;
            height: 52px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            color: #fff;
            width: 100%;
            margin-top: 8px;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
            color: #fff;
        }
        .btn-login:active { transform: translateY(0); }

        /* Alert */
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

        /* Footer link */
        .login-footer {
            text-align: center;
            margin-top: 28px;
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
            margin: 24px 0;
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
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- ===== HERO PANEL ===== -->
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

    <!-- ===== FORM PANEL ===== -->
    <div class="login-form-panel">
        <div class="login-box">

            <div class="brand-mark">
                <img src="assets/img/pulilan-logo.png" alt="Logo" onerror="this.style.display='none'">
                <span>CBMS Pulilan</span>
            </div>

            <h2>Welcome back</h2>
            <p class="tagline">Sign in to your account to continue.</p>

            <?php if (!empty($error_message)): ?>
            <div class="alert-login" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="login.php" autocomplete="on" novalidate>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label-custom">Username</label>
                    <div class="input-group-wrap">
                        <i class="fa fa-user input-icon"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control"
                            placeholder="Enter your username"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            autocomplete="username"
                            autofocus
                            required
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label-custom">Password</label>
                        <a href="change_password.php" style="font-size:0.8rem;color:#3b82f6;text-decoration:none;font-weight:500">Forgot password?</a>
                    </div>
                    <div class="input-group-wrap">
                        <i class="fa fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pass" id="togglePass" title="Show/hide password" aria-label="Toggle password visibility">
                            <i class="fa fa-eye" id="togglePassIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember me -->
                <div class="d-flex align-items-center mb-2">
                    <input type="checkbox" id="rememberMe" class="form-check-input me-2" style="border-radius:5px;cursor:pointer">
                    <label for="rememberMe" class="form-check-label" style="font-size:0.875rem;color:#475569;cursor:pointer">Remember me</label>
                </div>

                <button type="submit" name="submit" class="btn-login mt-2" id="loginBtn">
                    <i class="fa fa-sign-in me-2"></i> Sign In
                </button>

            </form>

            <div class="divider">or</div>

            <div class="login-footer">
                Don't have an account? <a href="registration.php">Register here</a>
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
    // Toggle password visibility
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

    // Loading state on submit
    document.querySelector('form').addEventListener('submit', function () {
        var btn = document.getElementById('loginBtn');
        btn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Signing in...';
        btn.disabled = true;
    });
</script>

</body>
</html>