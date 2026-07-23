<nav class="sidebar" id="mainSidebar">
    <div class="user-section">
        <img src="/pulilan/assets/img/user.jpg" alt="Admin Logo">
        <div>
            <div class="user-name text-uppercase"><?php echo admin_escape($_SESSION['username'] ?? 'Admin'); ?></div>
            <div class="user-role">CBMS Pulilan</div>
        </div>
    </div>

    <ul id="side-menu">
        <div class="sidebar-section-label">Main</div>
        <li><a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php"><i class="fa fa-th-large fa-fw"></i><span class="link-text">Dashboard</span></a></li>
        <li><a class="nav-link <?php echo ($current_page == 'admin_messages.php') ? 'active' : ''; ?>" href="admin_messages.php"><i class="fa fa-envelope fa-fw"></i><span class="link-text">Messages</span><?php $sidebar_msg_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as c FROM message_tbl WHERE brgy_location = 'Admin' AND notification_status = 'UNSEEN'"))['c'] ?? 0; if ($sidebar_msg_count > 0) echo '<span class="badge bg-danger rounded-pill" style="margin-left:auto">' . admin_escape($sidebar_msg_count) . '</span>'; ?></a></li>
        <li><a class="nav-link <?php echo ($current_page == 'admin_memo.php') ? 'active' : ''; ?>" href="admin_memo.php"><i class="fa fa-file-text fa-fw"></i><span class="link-text">Memos</span></a></li>

        <div class="sidebar-section-label">Management</div>
        <li>
            <button class="submenu-trigger <?php echo in_array($current_page, ['brgylist_table.php','executive_list.php','deleted_history_brgy.php','brgymonitoring.php','loghistory.php','history_final_report.php']) ? 'active' : ''; ?>" type="button" data-submenu="manageSettings" aria-expanded="<?php echo in_array($current_page, ['brgylist_table.php','executive_list.php','deleted_history_brgy.php','brgymonitoring.php','loghistory.php','history_final_report.php']) ? 'true' : 'false'; ?>">
                <i class="fa fa-wrench fa-fw"></i><span class="link-text">Manage Settings</span><i class="fa fa-angle-right arrow"></i>
            </button>
            <div class="submenu <?php echo in_array($current_page, ['brgylist_table.php','executive_list.php','deleted_history_brgy.php','brgymonitoring.php','loghistory.php','history_final_report.php']) ? 'open' : ''; ?>" id="manageSettings">
                <ul>
                    <li><a class="nav-link <?php echo ($current_page=='brgylist_table.php')?'active':''; ?>" href="brgylist_table.php"><i class="fa fa-users fa-fw me-2"></i>Brgy. Account List</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='executive_list.php')?'active':''; ?>" href="executive_list.php"><i class="fa fa-user-secret fa-fw me-2"></i>Executive Account List</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='deleted_history_brgy.php')?'active':''; ?>" href="deleted_history_brgy.php"><i class="fa fa-archive fa-fw me-2"></i>Archived Accounts</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='brgymonitoring.php')?'active':''; ?>" href="brgymonitoring.php"><i class="fa fa-map-marker fa-fw me-2"></i>Barangay Monitoring</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='loghistory.php')?'active':''; ?>" href="loghistory.php"><i class="fa fa-history fa-fw me-2"></i>Log History</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='history_final_report.php')?'active':''; ?>" href="history_final_report.php"><i class="fa fa-archive fa-fw me-2"></i>History Final Report</a></li>
                </ul>
            </div>
        </li>
        <li>
            <button class="submenu-trigger <?php echo in_array($current_page, ['addbrgygrid.php','addexecutive_grid.php','email.php']) ? 'active' : ''; ?>" type="button" data-submenu="formsMenu" aria-expanded="<?php echo in_array($current_page, ['addbrgygrid.php','addexecutive_grid.php','email.php']) ? 'true' : 'false'; ?>">
                <i class="fa fa-edit fa-fw"></i><span class="link-text">Forms</span><i class="fa fa-angle-right arrow"></i>
            </button>
            <div class="submenu <?php echo in_array($current_page, ['addbrgygrid.php','addexecutive_grid.php','email.php']) ? 'open' : ''; ?>" id="formsMenu">
                <ul>
                    <li><a class="nav-link <?php echo ($current_page=='addbrgygrid.php')?'active':''; ?>" href="addbrgygrid.php"><i class="fa fa-plus fa-fw me-2"></i>Add Brgy Details</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='addexecutive_grid.php')?'active':''; ?>" href="addexecutive_grid.php"><i class="fa fa-plus-square fa-fw me-2"></i>Add Executive Details</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='email.php')?'active':''; ?>" href="email.php"><i class="fa fa-at fa-fw me-2"></i>E-mail</a></li>
                </ul>
            </div>
        </li>
        <li>
            <button class="submenu-trigger <?php echo in_array($current_page, ['brgygrid.php','viewbrgyanswer.php']) ? 'active' : ''; ?>" type="button" data-submenu="tablesMenu" aria-expanded="<?php echo in_array($current_page, ['brgygrid.php','viewbrgyanswer.php']) ? 'true' : 'false'; ?>">
                <i class="fa fa-table fa-fw"></i><span class="link-text">Tables</span><i class="fa fa-angle-right arrow"></i>
            </button>
            <div class="submenu <?php echo in_array($current_page, ['brgygrid.php','viewbrgyanswer.php']) ? 'open' : ''; ?>" id="tablesMenu">
                <ul>
                    <li><a class="nav-link <?php echo ($current_page=='updatebrgygrid.php')?'active':''; ?>" href="updatebrgygrid.php"><i class="fa fa-grid fa-fw me-2"></i>Brgy &amp; Exec Grid Table</a></li>
                    <li><a class="nav-link <?php echo ($current_page=='viewbrgyanswer.php')?'active':''; ?>" href="viewbrgyanswer.php"><i class="fa fa-bar-chart fa-fw me-2"></i>Barangay Answer Report</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>

<main class="page-content">
