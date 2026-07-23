<?php
if (!function_exists('admin_escape')) {
    function admin_escape($value): string {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(__DIR__ . '/../../tab-name.php'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/pulilan/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 58px;
            --sidebar-bg: #1e2430;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-active: rgba(59, 130, 246, 0.25);
            --sidebar-active-border: #3b82f6;
            --footer-height: 52px;
            --surface: #ffffff;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding-top: var(--navbar-height);
            padding-bottom: var(--footer-height);
            background-color: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #111827;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }

        #wrapper { width: 100%; min-height: calc(100vh - var(--navbar-height)); }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            background: linear-gradient(135deg, #1a1f2e 0%, #2d3748 100%);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 2px 12px rgba(0,0,0,0.25);
            z-index: 1100;
        }
        .brand { display: flex; align-items: center; gap: 10px; color: #fff; font-weight: 700; }
        .brand img { height: 38px; object-fit: contain; }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .mobile-toggle {
            display: none;
            background: transparent;
            border: 0;
            color: rgba(255,255,255,0.8);
            cursor: pointer;
            padding: 6px 8px;
            margin-right: 6px;
        }
        .icon-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: rgba(255,255,255,0.8);
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .icon-btn:hover, .icon-btn.open { background: rgba(255,255,255,0.12); color: #fff; }
        .icon-btn .badge-dot {
            position: absolute; top: 4px; right: 4px; min-width: 18px; height: 18px; padding: 0 4px;
            border-radius: 999px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center;
            border: 2px solid #1a1f2e; font-weight: 700; color: #fff;
        }
        .user-pill {
            display: flex; align-items: center; gap: 10px; padding: 4px 8px; border-radius: 999px;
            color: #fff; cursor: pointer;
        }
        .avatar { width: 32px; height: 32px; border-radius: 9px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; color: #fff; }
        .dropdown-wrap { position: relative; }
        .dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 8px); min-width: 280px; padding: 8px;
            display: none; background: #1e2430; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4); z-index: 1200;
        }
        .dropdown-menu.show { display: block; }
        .dropdown-menu .dropdown-item, .dropdown-menu .dropdown-header, .dropdown-menu .dropdown-divider {
            display: block; width: 100%;
        }
        .dropdown-menu .dropdown-header { color: rgba(255,255,255,0.5); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; padding: 8px 12px 4px; }
        .dropdown-menu .dropdown-item { border-radius: 8px; padding: 10px 12px; color: rgba(255,255,255,0.8); font-size: 0.875rem; transition: background 0.15s; }
        .dropdown-menu .dropdown-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .dropdown-menu .dropdown-divider { border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 6px 0; }

        .sidebar {
            position: fixed; top: var(--navbar-height); left: 0; bottom: var(--footer-height);
            width: var(--sidebar-width); overflow-y: auto; background-color: var(--sidebar-bg); padding-top: 12px;
            z-index: 1000; border-right: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar .user-section { padding: 16px 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .sidebar .user-section img { width: 64px; height: 64px; border-radius: 14px; object-fit: cover; border: 2px solid rgba(255,255,255,0.15); }
        .sidebar .user-name { color: #fff; font-weight: 600; font-size: 0.9rem; }
        .sidebar .user-role { color: rgba(255,255,255,0.45); font-size: 0.75rem; }
        .sidebar-section-label { padding: 10px 18px 4px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.3); }
        .sidebar .nav-link, .sidebar .submenu-trigger {
            color: rgba(255,255,255,.65); padding: 9px 18px; font-size: 0.875rem; font-weight: 500; border-radius: 8px; margin: 1px 8px;
            display: flex; align-items: center; gap: 10px; transition: background 0.15s, color 0.15s; position: relative; text-decoration: none; border: 0; background: transparent; width: calc(100% - 16px); text-align: left; cursor: pointer;
        }
        .sidebar .nav-link:hover, .sidebar .submenu-trigger:hover { color: #fff; background-color: var(--sidebar-hover); }
        .sidebar .nav-link.active, .sidebar .submenu-trigger.active { color: #fff !important; background-color: var(--sidebar-active); border-left: 3px solid var(--sidebar-active-border); padding-left: 15px; }
        .sidebar .nav-link .fa, .sidebar .submenu-trigger .fa { width: 18px; text-align: center; flex-shrink: 0; }
        .sidebar .nav-link .link-text { flex: 1; }
        .sidebar .submenu { display: none; padding: 4px 0; margin: 2px 8px; background: rgba(0,0,0,0.15); border-radius: 8px; border-left: 2px solid rgba(255,255,255,0.08); }
        .sidebar .submenu.open { display: block; }
        .sidebar .submenu .nav-link { font-size: 0.82rem; padding: 7px 14px; margin: 1px 4px; color: rgba(255,255,255,0.55); }
        .sidebar .submenu .nav-link:hover { color: #fff; }
        .sidebar .submenu .nav-link.active { color: #60a5fa !important; background: rgba(59, 130, 246, 0.12); border-left: 2px solid #3b82f6; }
        .sidebar .arrow { font-size: 0.75rem; margin-left: auto; transition: transform 0.25s; }
        .sidebar .submenu-trigger[aria-expanded="true"] .arrow { transform: rotate(90deg); }

        .page-content { margin-left: var(--sidebar-width); padding: 24px; min-height: calc(100vh - var(--navbar-height) - var(--footer-height)); }
        .admin-footer { position: fixed; bottom: 0; left: 0; right: 0; height: var(--footer-height); background: #fff; border-top: 1px solid var(--border-color); box-shadow: 0 -2px 10px rgba(0,0,0,0.06); z-index: 1000; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; color: #6b7280; font-size: 0.9rem; }
        #scrollTopBtn { position: fixed; right: 22px; bottom: 66px; width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #3b82f6, #6366f1); color: #fff; border: 0; display: none; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(59,130,246,0.4); cursor: pointer; z-index: 1050; }
        #scrollTopBtn.visible { display: flex; }
        .page-content .container-fluid { width: 100%; }
        .page-content .row { display: flex; flex-wrap: wrap; margin: 0 -12px; }
        .page-content [class^="col"] { padding: 0 12px; }
        .page-content .col-12 { flex: 0 0 100%; max-width: 100%; }
        .page-content .col-lg-4 { flex: 0 0 33.3333%; max-width: 33.3333%; }
        .page-content .col-lg-5 { flex: 0 0 41.6667%; max-width: 41.6667%; }
        .page-content .col-lg-7 { flex: 0 0 58.3333%; max-width: 58.3333%; }
        .page-content .col-lg-8 { flex: 0 0 66.6667%; max-width: 66.6667%; }
        .page-content .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        .page-content .col-xl-3 { flex: 0 0 25%; max-width: 25%; }
        .page-content .g-2 { gap: 0.5rem; display: flex; flex-wrap: wrap; }
        .page-content .g-3 { gap: 1rem; display: flex; flex-wrap: wrap; }
        .page-content .g-4 { gap: 1.25rem; display: flex; flex-wrap: wrap; }
        .page-content .mb-3 { margin-bottom: 1rem; }
        .page-content .mb-4 { margin-bottom: 1.5rem; }
        .page-content .mt-1 { margin-top: 0.25rem; }
        .page-content .mt-2 { margin-top: 0.5rem; }
        .page-content .mt-3 { margin-top: 1rem; }
        .page-content .me-1 { margin-right: 0.25rem; }
        .page-content .me-2 { margin-right: 0.5rem; }
        .page-content .ms-1 { margin-left: 0.25rem; }
        .page-content .ms-2 { margin-left: 0.5rem; }
        .page-content .px-3 { padding-left: 1rem; padding-right: 1rem; }
        .page-content .px-4 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .page-content .py-3 { padding-top: 1rem; padding-bottom: 1rem; }
        .page-content .py-5 { padding-top: 3rem; padding-bottom: 3rem; }
        .page-content .p-0 { padding: 0; }
        .page-content .p-2 { padding: 0.5rem; }
        .page-content .p-3 { padding: 1rem; }
        .page-content .text-center { text-align: center; }
        .page-content .text-end { text-align: right; }
        .page-content .text-muted, .page-content .text-secondary { color: var(--text-muted) !important; }
        .page-content .text-white { color: #fff !important; }
        .page-content .text-light { color: rgba(255,255,255,0.9) !important; }
        .page-content .border-0 { border: 0 !important; }
        .page-content .border-bottom { border-bottom: 1px solid var(--border-color); }
        .page-content .border-top-0 { border-top: 0 !important; }
        .page-content .bg-primary { background: linear-gradient(135deg,#3b82f6,#6366f1) !important; color: #fff !important; }
        .page-content .bg-info { background: linear-gradient(135deg,#06b6d4,#0891b2) !important; color: #fff !important; }
        .page-content .bg-success { background: linear-gradient(135deg,#10b981,#059669) !important; color: #fff !important; }
        .page-content .bg-dark { background: #111827 !important; color: #fff !important; }
        .page-content .bg-light { background: #f3f4f6 !important; }
        .page-content .bg-white { background: #fff !important; }
        .page-content .bg-danger { background: #dc2626 !important; color: #fff !important; }
        .page-content .bg-warning { background: #f59e0b !important; color: #111827 !important; }
        .page-content .rounded-pill { border-radius: 999px; }
        .page-content .shadow-sm { box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .page-content .w-100 { width: 100%; }
        .page-content .d-flex { display: flex; }
        .page-content .justify-content-between { justify-content: space-between; }
        .page-content .align-items-center { align-items: center; }
        .page-content .flex-grow-1 { flex: 1 1 auto; }
        .page-content .flex-column { flex-direction: column; }
        .page-content .gap-2 { gap: 0.5rem; }
        .page-content .gap-3 { gap: 1rem; }
        .page-content .card { background: #fff; border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; }
        .page-content .card-header, .page-content .card-footer { padding: 1rem 1.25rem; background: #f9fafb; border-bottom: 1px solid var(--border-color); }
        .page-content .card-footer { border-top: 1px solid var(--border-color); border-bottom: 0; }
        .page-content .card-body { padding: 1.25rem; }
        .page-content .card-title { margin: 0; font-size: 1rem; }
        .page-content .card-text { margin: 0; color: var(--text-muted); }
        .page-content .alert { padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1rem; }
        .page-content .alert-success { background: #ecfdf3; color: #166534; border: 1px solid #a7f3d0; }
        .page-content .alert-dismissible { position: relative; }
        .page-content .btn-close { position: absolute; top: 12px; right: 12px; background: transparent; border: 0; cursor: pointer; color: inherit; }
        .page-content .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; border-radius: 10px; padding: 0.7rem 1rem; border: 1px solid var(--border-color); background: #fff; color: #111827; cursor: pointer; }
        .page-content .btn-primary { background: linear-gradient(135deg,#3b82f6,#6366f1); color: #fff; border-color: transparent; }
        .page-content .btn-info { background: linear-gradient(135deg,#06b6d4,#0891b2); color: #fff; border-color: transparent; }
        .page-content .btn-outline-secondary { background: transparent; color: #4b5563; }
        .page-content .btn-outline-light { background: transparent; color: #fff; border-color: rgba(255,255,255,0.3); }
        .page-content .btn-sm { padding: 0.45rem 0.7rem; font-size: 0.85rem; }
        .page-content .form-control { width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 0.65rem 0.8rem; background: #fff; color: #111827; }
        .page-content .form-label { display: block; margin-bottom: 0.4rem; font-weight: 600; color: #4b5563; }
        .page-content .table { width: 100%; border-collapse: collapse; background: #fff; }
        .page-content .table th, .page-content .table td { padding: 0.8rem 1rem; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .page-content .table thead { background: #f9fafb; }
        .page-content .table-hover tbody tr:hover { background: #f9fafb; }
        .page-content .table-striped tbody tr:nth-child(odd) { background: #fdfdfd; }
        .page-content .table-responsive { overflow-x: auto; }
        .page-content .badge { display: inline-flex; align-items: center; justify-content: center; padding: 0.25rem 0.58rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; }
        .page-content .badge.bg-danger { background: #dc2626; color: #fff; }
        .page-content .badge.bg-success { background: #10b981; color: #fff; }
        .page-content .badge.bg-warning { background: #f59e0b; color: #111827; }
        .page-content .badge.bg-secondary { background: #6b7280; color: #fff; }
        .page-content .collapse { display: none; }
        .page-content .collapse.show, .page-content .collapse.open { display: block; }
        .page-content .nav-tabs { display: flex; gap: 0.25rem; border-bottom: 1px solid var(--border-color); padding: 0; list-style: none; }
        .page-content .nav-tabs .nav-link { border: 0; background: transparent; padding: 0.75rem 1rem; color: #4b5563; cursor: pointer; border-radius: 0; }
        .page-content .nav-tabs .nav-link.active { background: #fff; color: #111827; border-bottom: 2px solid #3b82f6; }
        .page-content .tab-pane { display: none; }
        .page-content .tab-pane.active { display: block; }
        .page-content .modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 20px; background: rgba(17,24,39,0.6); z-index: 2000; }
        .page-content .modal.show { display: flex; }
        .page-content .modal-dialog { width: min(600px, 100%); background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.25); }
        .page-content .modal-header, .page-content .modal-body, .page-content .modal-footer { padding: 1rem 1.25rem; }
        .page-content .modal-header { display: flex; align-items: center; justify-content: space-between; background: #f9fafb; }
        .page-content .modal-body { background: #fff; }
        .page-content .modal-footer { display: flex; justify-content: flex-end; gap: 0.5rem; border-top: 1px solid var(--border-color); }
        .page-content .h-100 { height: 100%; }
        .page-content .text-decoration-none { text-decoration: none; }
        .page-content .small { font-size: 0.85rem; }
        .page-content .opacity-75 { opacity: 0.75; }
        .page-content .opacity-25 { opacity: 0.25; }
        .page-content .d-block { display: block; }

        @media (max-width: 768px) {
            .mobile-toggle { display: inline-flex; }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .page-content { margin-left: 0; width: 100%; }
            .page-content .col-lg-4, .page-content .col-lg-5, .page-content .col-lg-7, .page-content .col-lg-8, .page-content .col-md-6, .page-content .col-xl-3 { flex: 0 0 100%; max-width: 100%; }
            .topbar-actions .user-pill .user-meta { display: none; }
            .admin-footer { left: 0; padding: 0 16px; }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="topbar">
            <a class="brand" href="index.php">
                <img src="/pulilan/img/logo.png" alt="Pulilan Logo">
            </a>
            <button class="mobile-toggle" id="sidebarToggleMobile" type="button" aria-label="Toggle sidebar">
                <i class="fa fa-bars fa-lg"></i>
            </button>
            <div class="topbar-actions">
                <div class="dropdown-wrap">
                    <?php
                    $get_notif_query = mysqli_query($con, "SELECT COUNT(*) as count FROM message_tbl WHERE brgy_location = 'Admin' AND notification_status = 'UNSEEN'");
                    $notif_row = mysqli_fetch_assoc($get_notif_query);
                    $get_notif = $notif_row['count'] ?? 0;
                    ?>
                    <button class="icon-btn" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Messages">
                        <i class="fa fa-envelope"></i>
                        <?php if ($get_notif > 0): ?><span class="badge-dot bg-danger"><?php echo admin_escape($get_notif); ?></span><?php endif; ?>
                    </button>
                    <div class="dropdown-menu" id="messagesMenu">
                        <div class="dropdown-header"><i class="fa fa-inbox me-1"></i> Messages <?php if ($get_notif > 0): ?><span class="badge bg-danger" style="margin-left:6px;"><?php echo admin_escape($get_notif); ?> new</span><?php endif; ?></div>
                        <div class="dropdown-divider"></div>
                        <?php
                        $msg_query = "SELECT m.*, u.name as sender_name, m.message_id FROM message_tbl m LEFT JOIN mainuser_acc u ON m.user_id = u.user_id WHERE m.brgy_location = 'Admin' ORDER BY m.message_id DESC LIMIT 6";
                        $get_notif2 = mysqli_query($con, $msg_query);
                        if ($get_notif2 && mysqli_num_rows($get_notif2) > 0) {
                            while ($d = mysqli_fetch_array($get_notif2)) {
                                $sender_name = admin_escape($d['sender_name'] ?? 'Unknown');
                                $is_unseen = ($d['notification_status'] ?? '') === 'UNSEEN';
                                echo '<a class="dropdown-item" href="admin_messages.php?type=' . admin_escape($d['message_id']) . '"><div style="display:flex;gap:8px;align-items:flex-start"><div class="avatar" style="width:30px;height:30px;font-size:0.7rem;border-radius:8px;">' . strtoupper(substr($sender_name, 0, 1)) . '</div><div><div style="font-weight:600;color:#fff;">' . $sender_name . '</div><div style="color:rgba(255,255,255,0.6);font-size:0.78rem;">' . admin_escape($d['subject'] ?? '') . '</div></div>' . ($is_unseen ? '<span style="width:7px;height:7px;border-radius:50%;background:#ef4444;flex-shrink:0;margin-top:6px"></span>' : '') . '</div></a>';
                            }
                        } else {
                            echo '<span class="dropdown-item" style="text-align:center;color:rgba(255,255,255,0.4)"><i class="fa fa-inbox fa-2x d-block mb-2" style="opacity:.3"></i>No messages yet</span>';
                        }
                        ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="admin_messages.php">View All Messages <i class="fa fa-angle-right ms-1"></i></a>
                    </div>
                </div>
                <div class="dropdown-wrap">
                    <?php
                    $req_count_query = mysqli_query($con, "SELECT COUNT(*) as count FROM mainuser_acc WHERE edit_status = 'request' AND edit_notif = 'UNSEEN'");
                    $req_row = mysqli_fetch_assoc($req_count_query);
                    $num = $req_row['count'] ?? 0;
                    ?>
                    <button class="icon-btn" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="Notifications">
                        <i class="fa fa-bell"></i>
                        <?php if ($num > 0): ?><span class="badge-dot bg-warning" style="color:#111827;"><?php echo admin_escape($num); ?></span><?php endif; ?>
                    </button>
                    <div class="dropdown-menu" id="alertsMenu">
                        <div class="dropdown-header"><i class="fa fa-bell me-1"></i> Notifications <?php if ($num > 0): ?><span class="badge bg-warning" style="margin-left:6px; color:#111827;"><?php echo admin_escape($num); ?> pending</span><?php endif; ?></div>
                        <div class="dropdown-divider"></div>
                        <?php
                        $get_r = mysqli_query($con, "SELECT * FROM mainuser_acc WHERE edit_status = 'request' ORDER BY user_id DESC LIMIT 5");
                        if ($get_r && mysqli_num_rows($get_r) > 0) {
                            while ($s = mysqli_fetch_array($get_r)) {
                                echo '<a class="dropdown-item" href="see_request.php?did=' . admin_escape($s['user_id']) . '"><div style="display:flex;flex-direction:column;gap:4px"><span class="badge bg-warning" style="width:max-content;color:#111827"><i class="fa fa-edit me-1"></i>Update Request</span><span style="color:rgba(255,255,255,0.45);font-size:0.75rem">' . admin_escape($s['brgy_location']) . '</span><span style="color:rgba(255,255,255,0.55);font-size:0.8rem">Resident: ' . admin_escape($s['name']) . '</span></div></a><div class="dropdown-divider"></div>';
                            }
                        } else {
                            echo '<span class="dropdown-item" style="text-align:center;color:rgba(255,255,255,0.4)"><i class="fa fa-bell-slash fa-2x d-block mb-2" style="opacity:.3"></i>No pending requests</span>';
                        }
                        ?>
                        <a class="dropdown-item" href="see_request.php?all=yes">View All Requests <i class="fa fa-angle-right ms-1"></i></a>
                    </div>
                </div>
                <div class="dropdown-wrap">
                    <button class="user-pill" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <span class="avatar"><?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?></span>
                        <span class="user-meta">
                            <span style="display:block;font-size:0.83rem;font-weight:600;line-height:1.2"><?php echo admin_escape($_SESSION['username'] ?? 'Admin'); ?></span>
                            <span style="display:block;color:rgba(255,255,255,0.45);font-size:0.72rem">Administrator</span>
                        </span>
                    </button>
                    <div class="dropdown-menu" id="userMenu">
                        <div class="dropdown-item" style="display:flex;align-items:center;gap:10px">
                            <span class="avatar" style="width:40px;height:40px;font-size:1rem"><?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?></span>
                            <div>
                                <div style="color:#fff;font-weight:600;font-size:0.88rem"><?php echo admin_escape($_SESSION['username'] ?? 'Admin'); ?></div>
                                <div style="color:rgba(255,255,255,0.4);font-size:0.75rem">Super Administrator</div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php"><i class="fa fa-th-large fa-fw me-2"></i>Dashboard</a>
                        <a class="dropdown-item" href="change_password.php"><i class="fa fa-key fa-fw me-2"></i>Change Password</a>
                    </div>
                </div>
            </div>
        </nav>