<?php
$current_page = basename($_SERVER['PHP_SELF']);

function is_active($page_name, $current_page) {
    if (is_array($page_name)) {
        return in_array($current_page, $page_name) ? 'active' : '';
    }
    return ($current_page == $page_name) ? 'active' : '';
}

$manage_pages = ['brgylist_table.php', 'executive_list.php', 'deleted_history_brgy.php', 'brgymonitoring.php', 'loghistory.php', 'history_final_report.php', 'edit_brgy.php'];
$forms_pages = ['addbrgygrid.php', 'addexecutive_grid.php', 'email.php', 'admin_memo.php'];
$tables_pages = ['updatebrgygrid.php', 'viewbrgyanswer.php', 'brgyanswer.php'];
?>
<nav class="sidebar" id="mainSidebar">
    <div class="user-section">
        <img src="/pulilan/assets/img/pulilan-logo.png" alt="Admin Logo" class="user-avatar-img">
        <div>
            <div class="user-name text-uppercase"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
            <div class="user-role">Administrator</div>
        </div>
    </div>

    <ul id="side-menu">
        <li class="sidebar-section-label">Main</li>
        <li><a class="nav-link <?php echo is_active('index.php', $current_page); ?>" href="index.php"><i class="fa fa-dashboard fa-fw"></i><span class="link-text">Dashboard</span></a></li>
        <li><a class="nav-link <?php echo is_active('admin_messages.php', $current_page); ?>" href="admin_messages.php"><i class="fa fa-envelope fa-fw"></i><span class="link-text">Messages</span><?php if (isset($sidebar_msg_count) && $sidebar_msg_count > 0) echo '<span class="badge bg-danger rounded-pill ms-auto">' . htmlspecialchars($sidebar_msg_count) . '</span>'; ?></a></li>

        <li class="sidebar-section-label">Management</li>
        <li>
            <button class="submenu-trigger <?php echo is_active($manage_pages, $current_page); ?>" type="button" data-submenu="manageSettings" aria-expanded="<?php echo is_active($manage_pages, $current_page) ? 'true' : 'false'; ?>">
                <i class="fa fa-wrench fa-fw"></i><span class="link-text">Manage Settings</span><i class="fa fa-angle-right arrow"></i>
            </button>
            <div class="submenu <?php echo is_active($manage_pages, $current_page) ? 'open' : ''; ?>" id="manageSettings">
                <ul>
                    <li><a class="nav-link <?php echo is_active('brgylist_table.php', $current_page); ?>" href="brgylist_table.php"><i class="fa fa-users fa-fw me-2"></i>Brgy. Accounts</a></li>
                    <li><a class="nav-link <?php echo is_active('executive_list.php', $current_page); ?>" href="executive_list.php"><i class="fa fa-user-secret fa-fw me-2"></i>Executive Accounts</a></li>
                    <li><a class="nav-link <?php echo is_active('deleted_history_brgy.php', $current_page); ?>" href="deleted_history_brgy.php"><i class="fa fa-archive fa-fw me-2"></i>Archived Accounts</a></li>
                    <li><a class="nav-link <?php echo is_active('brgymonitoring.php', $current_page); ?>" href="brgymonitoring.php"><i class="fa fa-map-marker fa-fw me-2"></i>Barangay Monitoring</a></li>
                    <li><a class="nav-link <?php echo is_active('loghistory.php', $current_page); ?>" href="loghistory.php"><i class="fa fa-history fa-fw me-2"></i>Log History</a></li>
                    <li><a class="nav-link <?php echo is_active('history_final_report.php', $current_page); ?>" href="history_final_report.php"><i class="fa fa-file-archive-o fa-fw me-2"></i>History Final Report</a></li>
                </ul>
            </div>
        </li>
        <li>
            <button class="submenu-trigger <?php echo is_active($forms_pages, $current_page); ?>" type="button" data-submenu="formsMenu" aria-expanded="<?php echo is_active($forms_pages, $current_page) ? 'true' : 'false'; ?>">
                <i class="fa fa-edit fa-fw"></i><span class="link-text">Forms</span><i class="fa fa-angle-right arrow"></i>
            </button>
            <div class="submenu <?php echo is_active($forms_pages, $current_page) ? 'open' : ''; ?>" id="formsMenu">
                <ul>
                    <li><a class="nav-link <?php echo is_active('addbrgygrid.php', $current_page); ?>" href="addbrgygrid.php"><i class="fa fa-plus fa-fw me-2"></i>Add Brgy Details</a></li>
                    <li><a class="nav-link <?php echo is_active('addexecutive_grid.php', $current_page); ?>" href="addexecutive_grid.php"><i class="fa fa-plus-square fa-fw me-2"></i>Add Executive Details</a></li>
                    <li><a class="nav-link <?php echo is_active('admin_memo.php', $current_page); ?>" href="admin_memo.php"><i class="fa fa-file-text fa-fw me-2"></i>Memos</a></li>
                    <li><a class="nav-link <?php echo is_active('email.php', $current_page); ?>" href="email.php"><i class="fa fa-at fa-fw me-2"></i>E-mail</a></li>
                </ul>
            </div>
        </li>
        <li>
            <button class="submenu-trigger <?php echo is_active($tables_pages, $current_page); ?>" type="button" data-submenu="tablesMenu" aria-expanded="<?php echo is_active($tables_pages, $current_page) ? 'true' : 'false'; ?>">
                <i class="fa fa-table fa-fw"></i><span class="link-text">Tables</span><i class="fa fa-angle-right arrow"></i>
            </button>
            <div class="submenu <?php echo is_active($tables_pages, $current_page) ? 'open' : ''; ?>" id="tablesMenu">
                <ul>
                    <li><a class="nav-link <?php echo is_active('updatebrgygrid.php', $current_page); ?>" href="updatebrgygrid.php"><i class="fa fa-table fa-fw me-2"></i>Brgy &amp; Exec Grid Table</a></li>
                    <li><a class="nav-link <?php echo is_active('viewbrgyanswer.php', $current_page); ?>" href="viewbrgyanswer.php"><i class="fa fa-bar-chart fa-fw me-2"></i>Barangay Answer Report</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>

<main class="page-content">