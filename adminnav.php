<?php
error_reporting(E_ALL ^ E_NOTICE);

// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('pulilan_db_connect.php');

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Fallback connection if $con is not properly exposed by pulilan_db_connect.php
if (!isset($con) || !($con instanceof mysqli)) {
    $con = mysqli_connect("localhost", "root", "", "pulilan");
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }
}

// Properly initialize GET variables without using global in global scope
$memo = $_GET['memo'] ?? null;
$done = $_GET['done'] ?? null;
$view_memo = $_GET['view'] ?? null;

// Determine current page for active state detection
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('tab-name.php') ?>
    
    <!-- Bootstrap 5 CSS -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 58px;
            --sidebar-bg: #1e2430;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-active: rgba(59, 130, 246, 0.25);
            --sidebar-active-border: #3b82f6;
            --footer-height: 52px;
        }

        * { box-sizing: border-box; }

        body {
            padding-top: var(--navbar-height);
            padding-bottom: var(--footer-height);
            background-color: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* ===== WRAPPER ===== */
        #wrapper {
            display: flex;
            width: 100%;
            min-height: calc(100vh - var(--navbar-height));
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            height: var(--navbar-height);
            background: linear-gradient(135deg, #1a1f2e 0%, #2d3748 100%);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 2px 12px rgba(0,0,0,0.25);
        }
        .navbar-brand-text {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.3px;
            color: #fff !important;
        }
        .navbar-search .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            border-radius: 20px;
            padding: 5px 16px;
            width: 220px;
            transition: all 0.3s;
            font-size: 0.85rem;
        }
        .navbar-search .form-control::placeholder { color: rgba(255,255,255,0.5); }
        .navbar-search .form-control:focus {
            background: rgba(255,255,255,0.18);
            border-color: rgba(255,255,255,0.35);
            box-shadow: none;
            color: #fff;
            width: 270px;
        }
        .navbar-search .btn-search {
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .nav-icon-btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            color: rgba(255,255,255,0.75) !important;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .nav-icon-btn:hover, .nav-icon-btn.show {
            background: rgba(255,255,255,0.12);
            color: #fff !important;
        }
        .nav-icon-btn .badge-dot {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #1a1f2e;
            font-weight: 700;
        }
        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            color: #fff;
        }
        .dropdown-menu-dark-custom {
            background: #1e2430;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            min-width: 280px;
            padding: 8px;
        }
        .dropdown-menu-dark-custom .dropdown-header {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 8px 12px 4px;
        }
        .dropdown-menu-dark-custom .dropdown-item {
            border-radius: 8px;
            padding: 10px 12px;
            color: rgba(255,255,255,0.8);
            font-size: 0.875rem;
            transition: background 0.15s;
        }
        .dropdown-menu-dark-custom .dropdown-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .dropdown-menu-dark-custom .dropdown-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 6px 0;
        }
        .msg-preview-item { border-radius: 8px; transition: background 0.15s; }
        .msg-preview-item:hover { background: rgba(255,255,255,0.08); }
        .msg-preview-sender { font-weight: 600; color: #fff; font-size: 0.83rem; }
        .msg-preview-subject { color: rgba(255,255,255,0.6); font-size: 0.78rem; }
        .msg-preview-time { color: rgba(255,255,255,0.35); font-size: 0.72rem; white-space: nowrap; }
        .msg-unread-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #ef4444; flex-shrink: 0; margin-top: 6px;
        }
        .see-all-link {
            display: block;
            text-align: center;
            padding: 9px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #60a5fa !important;
            border-radius: 8px;
            transition: background 0.15s;
        }
        .see-all-link:hover { background: rgba(96, 165, 250, 0.1); text-decoration: none; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            height: calc(100vh - var(--navbar-height) - var(--footer-height));
            overflow-y: auto;
            background-color: var(--sidebar-bg);
            padding-top: 12px;
            z-index: 999;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.15) transparent;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }

        .sidebar .user-section {
            padding: 16px 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            margin-bottom: 8px;
        }
        .sidebar .user-section img {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.15);
        }
        .sidebar .user-name { color: #fff; font-weight: 600; font-size: 0.9rem; }
        .sidebar .user-role { color: rgba(255,255,255,0.45); font-size: 0.75rem; }

        .sidebar-section-label {
            padding: 10px 18px 4px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.3);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .65);
            padding: 9px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 1px 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: var(--sidebar-hover);
        }
        .sidebar .nav-link.active {
            color: #fff !important;
            background-color: var(--sidebar-active);
            border-left: 3px solid var(--sidebar-active-border);
            padding-left: 15px;
        }
        .sidebar .nav-link .fa { width: 18px; text-align: center; flex-shrink: 0; }
        .sidebar .nav-link .link-text { flex: 1; }
        .sidebar .nav-link .arrow { 
            font-size: 0.75rem; 
            transition: transform 0.25s; 
            margin-left: auto;
        }
        .sidebar .nav-link[aria-expanded="true"] .arrow { transform: rotate(90deg); }
        .sidebar .collapse-menu {
            background: rgba(0,0,0,0.15);
            border-radius: 8px;
            margin: 2px 8px;
            border-left: 2px solid rgba(255,255,255,0.08);
        }
        .sidebar .collapse-menu .nav-link {
            font-size: 0.82rem;
            padding: 7px 14px 7px 14px;
            margin: 1px 4px;
            color: rgba(255,255,255,0.55);
        }
        .sidebar .collapse-menu .nav-link:hover { color: #fff; }
        .sidebar .collapse-menu .nav-link.active { 
            color: #60a5fa !important;
            background: rgba(59, 130, 246, 0.12);
            border-left: 2px solid #3b82f6;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,0.07);
            margin: 10px 18px;
        }

        /* ===== PAGE WRAPPER ===== */
        .page-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 24px;
            min-height: calc(100vh - var(--navbar-height) - var(--footer-height));
        }

        /* ===== FOOTER ===== */
        .admin-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: var(--footer-height);
            background: #fff;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.06);
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        /* ===== SCROLL TO TOP ===== */
        #scrollTopBtn {
            position: fixed;
            right: 22px;
            bottom: 66px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            border: none;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(59,130,246,0.4);
            cursor: pointer;
            z-index: 1050;
            transition: opacity 0.3s, transform 0.3s;
        }
        #scrollTopBtn:hover { transform: translateY(-2px); }
        #scrollTopBtn.visible { display: flex; }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .page-wrapper {
                margin-left: 0;
                width: 100%;
            }
            .admin-footer { left: 0; }
        }
    </style>
</head>
<body>

    <div id="wrapper">
        <!-- ============================================================
             TOP NAVBAR COMPONENT
        ============================================================ -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom px-3">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="adminindex.php">
                <img src="../assets/img/pulilan-logo.png" alt="Pulilan Logo" height="28" class="d-inline-block">
                <span class="navbar-brand-text">CBMS Admin</span>
            </a>

            <!-- Search Bar (desktop) -->
            <div class="navbar-search position-relative d-none d-lg-block ms-3">
                <input type="text" id="navbarSearch" class="form-control" placeholder="Search pages, users...">
                <button class="btn-search"><i class="fa fa-search fa-sm"></i></button>
            </div>

            <button class="navbar-toggler border-0 ms-auto me-2" type="button" id="sidebarToggleMobile" style="color:rgba(255,255,255,0.75)">
                <i class="fa fa-bars fa-lg"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="topNavbar">
                <div class="d-flex align-items-center gap-2">

                    <!-- Messages Dropdown -->
                    <div class="dropdown">
                        <?php
                            $get_notif_query = mysqli_query($con, "SELECT COUNT(*) as count FROM message_tbl WHERE brgy_location = 'Admin' AND notification_status = 'UNSEEN'");
                            $notif_row = mysqli_fetch_assoc($get_notif_query);
                            $get_notif = $notif_row['count'] ?? 0;
                        ?>
                        <a href="#" class="nav-icon-btn dropdown-toggle" id="messagesDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Messages">
                            <i class="fa fa-envelope"></i>
                            <?php if ($get_notif > 0): ?>
                                <span class="badge-dot bg-danger"><?php echo $get_notif; ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark-custom" aria-labelledby="messagesDropdown">
                            <li><span class="dropdown-header">
                                <i class="fa fa-inbox me-1"></i> Messages
                                <?php if ($get_notif > 0): ?>
                                    <span class="badge bg-danger ms-1"><?php echo $get_notif; ?> new</span>
                                <?php endif; ?>
                            </span></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                                $msg_query = "SELECT m.*, u.name as sender_name, m.message_id
                                              FROM message_tbl m
                                              LEFT JOIN mainuser_acc u ON m.user_id = u.user_id
                                              WHERE m.brgy_location = 'Admin'
                                              ORDER BY m.message_id DESC LIMIT 6";
                                $get_notif2 = mysqli_query($con, $msg_query);

                                if ($get_notif2 && mysqli_num_rows($get_notif2) > 0) {
                                    while ($d = mysqli_fetch_array($get_notif2)) {
                                        $sender_name = htmlspecialchars($d['sender_name'] ?? 'Unknown');
                                        $is_unseen = $d['notification_status'] === 'UNSEEN';
                            ?>
                            <li>
                                <a class="dropdown-item d-flex align-items-start gap-2 msg-preview-item" href="admin_messages.php?type=<?php echo htmlspecialchars($d['message_id']); ?>">
                                    <div class="admin-avatar flex-shrink-0" style="width:30px;height:30px;font-size:0.7rem;border-radius:8px;">
                                        <?php echo strtoupper(substr($sender_name,0,1)); ?>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="msg-preview-sender"><?php echo $sender_name; ?></div>
                                        <div class="msg-preview-subject text-truncate"><?php echo htmlspecialchars($d['subject'] ?? ''); ?></div>
                                    </div>
                                    <?php if ($is_unseen): ?><div class="msg-unread-dot"></div><?php endif; ?>
                                </a>
                            </li>
                            <?php }} else { ?>
                            <li><span class="dropdown-item text-center py-3" style="color:rgba(255,255,255,0.4)"><i class="fa fa-inbox fa-2x d-block mb-2 mx-auto" style="opacity:.3"></i>No messages yet</span></li>
                            <?php } ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="see-all-link" href="admin_messages.php">View All Messages <i class="fa fa-angle-right ms-1"></i></a></li>
                        </ul>
                    </div>

                    <!-- Alerts / Notifications Dropdown -->
                    <div class="dropdown">
                        <?php
                            $req_count_query = mysqli_query($con, "SELECT COUNT(*) as count FROM mainuser_acc WHERE edit_status = 'request' AND edit_notif = 'UNSEEN'");
                            $req_row = mysqli_fetch_assoc($req_count_query);
                            $num = $req_row['count'] ?? 0;
                            $get_r = mysqli_query($con, "SELECT * FROM mainuser_acc WHERE edit_status = 'request' ORDER BY user_id DESC LIMIT 5");
                        ?>
                        <a href="#" class="nav-icon-btn dropdown-toggle" id="alertsDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                            <i class="fa fa-bell"></i>
                            <?php if ($num > 0): ?>
                                <span class="badge-dot bg-warning text-dark"><?php echo $num; ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark-custom" aria-labelledby="alertsDropdown">
                            <li><span class="dropdown-header">
                                <i class="fa fa-bell me-1"></i> Notifications
                                <?php if ($num > 0): ?>
                                    <span class="badge bg-warning text-dark ms-1"><?php echo $num; ?> pending</span>
                                <?php endif; ?>
                            </span></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                                if ($get_r && mysqli_num_rows($get_r) > 0) {
                                    while ($s = mysqli_fetch_array($get_r)) {
                            ?>
                            <li>
                                <a class="dropdown-item" href="see_request.php?did=<?php echo htmlspecialchars($s['user_id']); ?>">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-warning text-dark"><i class="fa fa-edit me-1"></i>Update Request</span>
                                        <span style="color:rgba(255,255,255,0.45);font-size:0.75rem"><?php echo htmlspecialchars($s['brgy_location']); ?></span>
                                    </div>
                                    <div style="color:rgba(255,255,255,0.55);font-size:0.8rem">Resident: <?php echo htmlspecialchars($s['name']); ?></div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php }} else { ?>
                            <li><span class="dropdown-item text-center py-3" style="color:rgba(255,255,255,0.4)"><i class="fa fa-bell-slash fa-2x d-block mb-2 mx-auto" style="opacity:.3"></i>No pending requests</span></li>
                            <?php } ?>
                            <li><a class="see-all-link" href="see_request.php?all=yes">View All Requests <i class="fa fa-angle-right ms-1"></i></a></li>
                        </ul>
                    </div>

                    <!-- Divider -->
                    <div style="width:1px;height:22px;background:rgba(255,255,255,0.12)"></div>

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="admin-avatar"><?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?></div>
                            <div class="d-none d-lg-block text-start">
                                <div style="color:#fff;font-size:0.83rem;font-weight:600;line-height:1.2"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
                                <div style="color:rgba(255,255,255,0.45);font-size:0.72rem">Administrator</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark-custom" aria-labelledby="userDropdown" style="min-width:200px">
                            <li>
                                <div class="px-3 py-2 d-flex align-items-center gap-2">
                                    <div class="admin-avatar" style="width:40px;height:40px;font-size:1rem"><?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?></div>
                                    <div>
                                        <div style="color:#fff;font-weight:600;font-size:0.88rem"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
                                        <div style="color:rgba(255,255,255,0.4);font-size:0.75rem">Super Administrator</div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="adminindex.php"><i class="fa fa-th-large fa-fw me-2" style="color:#60a5fa"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="change_password.php"><i class="fa fa-key fa-fw me-2" style="color:#a78bfa"></i>Change Password</a></li>
                            <!-- <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php" style="color:#f87171"><i class="fa fa-sign-out fa-fw me-2"></i>Logout</a></li> -->
                        </ul>
                    </div>

                </div>
            </div>
        </nav>

        <!-- ============================================================
             SIDEBAR COMPONENT
        ============================================================ -->
        <nav class="sidebar" id="mainSidebar">
            <div class="user-section text-center">
                <img src="../assets/img/pulilan-logo.png" alt="Admin Logo" class="img-fluid bg-light p-1 shadow-sm">
                <div class="user-name mt-2">Administrator</div>
                <div class="user-role">CBMS Pulilan</div>
            </div>

            <ul class="nav flex-column w-100 mt-1" id="side-menu">

                <div class="sidebar-section-label">Main</div>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'adminindex.php') ? 'active' : ''; ?>" href="adminindex.php">
                        <i class="fa fa-th-large fa-fw"></i>
                        <span class="link-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'admin_messages.php') ? 'active' : ''; ?>" href="admin_messages.php">
                        <i class="fa fa-envelope fa-fw"></i>
                        <span class="link-text">Messages</span>
                        <?php
                            $sidebar_msg_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location = 'Admin' AND notification_status = 'UNSEEN'"))['c'] ?? 0;
                            if ($sidebar_msg_count > 0) echo '<span class="badge bg-danger rounded-pill ms-auto">' . $sidebar_msg_count . '</span>';
                        ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'admin_memo.php') ? 'active' : ''; ?>" href="admin_memo.php">
                        <i class="fa fa-file-text fa-fw"></i>
                        <span class="link-text">Memos</span>
                    </a>
                </li>

                <div class="sidebar-divider"></div>
                <div class="sidebar-section-label">Management</div>

                <li class="nav-item">
                    <?php
                        $manage_pages = ['brgylist_table.php', 'executive_list.php', 'deleted_history_brgy.php', 'brgymonitoring.php', 'loghistory.php', 'history_final_report.php'];
                        $manage_active = in_array($current_page, $manage_pages) ? 'active' : '';
                        $manage_expanded = in_array($current_page, $manage_pages) ? 'true' : 'false';
                        $manage_show = in_array($current_page, $manage_pages) ? 'show' : '';
                    ?>
                    <a class="nav-link <?php echo $manage_active; ?>" href="#manageSettings" data-bs-toggle="collapse" role="button" aria-expanded="<?php echo $manage_expanded; ?>" aria-controls="manageSettings">
                        <i class="fa fa-wrench fa-fw"></i>
                        <span class="link-text">Manage Settings</span>
                        <i class="fa fa-angle-right arrow"></i>
                    </a>
                    <div class="collapse <?php echo $manage_show; ?> collapse-menu" id="manageSettings">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='brgylist_table.php')?'active':''; ?>" href="brgylist_table.php"><i class="fa fa-users fa-fw me-2"></i>Brgy. Account List</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='executive_list.php')?'active':''; ?>" href="executive_list.php"><i class="fa fa-user-tie fa-fw me-2"></i>Executive Account List</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='deleted_history_brgy.php')?'active':''; ?>" href="deleted_history_brgy.php"><i class="fa fa-trash fa-fw me-2"></i>Deleted History</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='brgymonitoring.php')?'active':''; ?>" href="brgymonitoring.php"><i class="fa fa-map-marker fa-fw me-2"></i>Barangay Monitoring</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='loghistory.php')?'active':''; ?>" href="loghistory.php"><i class="fa fa-history fa-fw me-2"></i>Log History</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='history_final_report.php')?'active':''; ?>" href="history_final_report.php"><i class="fa fa-archive fa-fw me-2"></i>History Final Report</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <?php
                        $forms_pages = ['addbrgygrid.php', 'addexecutive_grid.php', 'email.php'];
                        $forms_active = in_array($current_page, $forms_pages) ? 'active' : '';
                        $forms_expanded = in_array($current_page, $forms_pages) ? 'true' : 'false';
                        $forms_show = in_array($current_page, $forms_pages) ? 'show' : '';
                    ?>
                    <a class="nav-link <?php echo $forms_active; ?>" href="#formsMenu" data-bs-toggle="collapse" role="button" aria-expanded="<?php echo $forms_expanded; ?>" aria-controls="formsMenu">
                        <i class="fa fa-edit fa-fw"></i>
                        <span class="link-text">Forms</span>
                        <i class="fa fa-angle-right arrow"></i>
                    </a>
                    <div class="collapse <?php echo $forms_show; ?> collapse-menu" id="formsMenu">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='addbrgygrid.php')?'active':''; ?>" href="addbrgygrid.php"><i class="fa fa-plus fa-fw me-2"></i>Add Brgy Details</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='addexecutive_grid.php')?'active':''; ?>" href="addexecutive_grid.php"><i class="fa fa-plus-square fa-fw me-2"></i>Add Executive Details</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='email.php')?'active':''; ?>" href="email.php"><i class="fa fa-at fa-fw me-2"></i>E-mail</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <?php
                        $tables_pages = ['brgygrid.php', 'viewbrgyanswer.php'];
                        $tables_active = in_array($current_page, $tables_pages) ? 'active' : '';
                        $tables_expanded = in_array($current_page, $tables_pages) ? 'true' : 'false';
                        $tables_show = in_array($current_page, $tables_pages) ? 'show' : '';
                    ?>
                    <a class="nav-link <?php echo $tables_active; ?>" href="#tablesMenu" data-bs-toggle="collapse" role="button" aria-expanded="<?php echo $tables_expanded; ?>" aria-controls="tablesMenu">
                        <i class="fa fa-table fa-fw"></i>
                        <span class="link-text">Tables</span>
                        <i class="fa fa-angle-right arrow"></i>
                    </a>
                    <div class="collapse <?php echo $tables_show; ?> collapse-menu" id="tablesMenu">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='updatebrgygrid.php')?'active':''; ?>" href="updatebrgygrid.php"><i class="fa fa-grid fa-fw me-2"></i>Brgy &amp; Exec Grid Table</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='viewbrgyanswer.php')?'active':''; ?>" href="viewbrgyanswer.php"><i class="fa fa-bar-chart fa-fw me-2"></i>Barangay Answer Report</a></li>
                        </ul>
                    </div>
                </li>

                <div class="sidebar-divider"></div>
                <div class="sidebar-section-label">Reports</div>

                <li class="nav-item">
                    <?php
                        $reports_pages = ['civilreport.php', 'educationalreport.php', 'housingreport.php', 'religionreport.php'];
                        $reports_active = in_array($current_page, $reports_pages) ? 'active' : '';
                        $reports_expanded = in_array($current_page, $reports_pages) ? 'true' : 'false';
                        $reports_show = in_array($current_page, $reports_pages) ? 'show' : '';
                    ?>
                    <a class="nav-link <?php echo $reports_active; ?>" href="#reportsMenu" data-bs-toggle="collapse" role="button" aria-expanded="<?php echo $reports_expanded; ?>" aria-controls="reportsMenu">
                        <i class="fa fa-bar-chart fa-fw"></i>
                        <span class="link-text">Reports</span>
                        <i class="fa fa-angle-right arrow"></i>
                    </a>
                    <div class="collapse <?php echo $reports_show; ?> collapse-menu" id="reportsMenu">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link" href="reports/reports/civilreport.php"><i class="fa fa-venus-mars fa-fw me-2"></i>Civil Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="reports/reports/educationalreport.php"><i class="fa fa-graduation-cap fa-fw me-2"></i>Educational Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="reports/reports/housingreport.php"><i class="fa fa-home fa-fw me-2"></i>Housing Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="reports/reports/religionreport.php"><i class="fa fa-star fa-fw me-2"></i>Religion Reports</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($current_page=='history_final_report.php')?'active':''; ?>" href="history_final_report.php"><i class="fa fa-file-pdf-o fa-fw me-2"></i>Total Final Reports</a></li>
                        </ul>
                    </div>
                </li>

                <div class="sidebar-divider"></div>

                <li class="nav-item pb-3">
                    <a class="nav-link" href="logout.php" style="color:#f87171">
                        <i class="fa fa-sign-out fa-fw"></i>
                        <span class="link-text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Wrapper -->
        <div id="page-wrapper" class="page-wrapper">