<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('pulilan_db_connect.php');
?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("location: login.php");
}

if(isset($_GET['memo'])){
    $memo = $_GET['memo'];
}
global $memo;
if(isset($_GET['done'])){
    $done = $_GET['done'];
}
global $done;

if(isset($_Get['view'])){
    $view_memo = $_GET['view'];
}
global $view_memo;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('tab-name.php') ?>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <link href="css/admin.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/vue.min.js">
</head>
<body>

    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav id="navbar" class="navbar navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <a class="brand" href="adminprofile.php">
                    <img src="../pulilan/img/logo.png" alt="pulilan logo" class="img-responsive" />
                </a>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul id="navigation" class="nav navbar-top-links navbar-right">
                <!-- main dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <!--Get notification count -->

                            <?php
                            $con = mysqli_connect("localhost", "root", "", "pulilan");

                            $get_notif = mysqli_num_rows(mysqli_query($con, "SELECT * from message_tbl where brgy_location = 'Admin' && notification_status = 'UNSEEN'"));


                            ?>

                    <script>
                        const Libelo = document.querySelectorAll(".label");
                        if(Labelo => 1) {
                            Labelo.style.padding = "2rem";
                            Labelo.style.transition = ".5s";
                        }else {
                            console.log("no message");
                        }
                    </script>

                        <span class="top-label label label-danger"><?php 
                    if($get_notif > 0){

                        echo $get_notif; 
                    }?></span><i class="fa fa-comments fa-3x"></i>
                    </a>
                    <!-- dropdown-messages -->
                    <ul class="dropdown-menu dropdown-messages">

                        <?php


                            $get_notif2 = mysqli_query($con, "SELECT * from message_tbl where brgy_location = 'Admin' && notification_status = 'UNSEEN'");
                            while($d = mysqli_fetch_array($get_notif2)){
                                $sender = $d['user_id'];
                                $get_sender = mysqli_query($con, "SELECT * from mainuser_acc where user_id = '$sender'");
                                while($g = mysqli_fetch_array($get_sender)){
                                    $name = $g['name'];
                        ?>
                        <li>
                            <a href="adminprofile.php?type=<?php echo $d['message_id']; ?>">
                                <div>
                                    <strong><span class=" label label-danger"><?php echo $name; ?></span></strong>
                                    <span class="pull-right text-muted">
                                        <em><?php echo $g['date_created']; ?></em>
                                    </span>
                                </div>
                                <div><?php echo $d['subject']; ?></div>
                            </a>
                        </li>
                        <?php
                                }
                            }


                        ?>
                    </ul>
                    <!-- end dropdown-messages -->
                </li>
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                        <?php
                        $get_req = mysqli_query($con, "SELECT * from mainuser_acc where edit_status = 'request' && edit_notif = 'UNSEEN'");
                        $get_r = mysqli_query($con, "SELECT * from mainuser_acc where edit_status = 'request'");
                        $num = mysqli_num_rows($get_req);
                        ?>
                        <span class="top-label label label-warning"><?php echo $num; ?></span>  <i class="fa fa-bell fa-3x"></i>
                    </a>
                    <!-- dropdown alerts-->
                    <ul class="dropdown-menu dropdown-alerts">
                        <?php

                            while($s = mysqli_fetch_array($get_r)){
                        ?>
                        <li>
                            <a href="see_request.php?did=<?php echo $s['user_id']; ?>">
                                <div>
                                    <i class="fa fa-bell"></i>Request Resident Update
                                    <span class="pull-right text-muted small"><?php echo $s['brgy_location']; ?></span>
                                    <p>Resident: <?php echo $s['name']; ?></p>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <?php

                    }
                    ?>
                     <li>
                            <a href="see_request.php?all=yes">
                                <div>
                                    <a href="see_request.php?all=yes" style="text-decoration: none;">See All Request</a>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- end dropdown-alerts -->
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-arrow-right fa-3x"></i>
                    </a>
                    <!-- dropdown user-->
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li>
                        <li><a href="change_password.php"><i class="fa fa-gear fa-fw"></i>Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul><!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->
        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
            <div class="sidebar-collapse">
       <nav id="nav-back" class="navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
                <!-- side-menu -->
                <!-- user image section-->
                <div class="user-section">
                    <img src="../pulilan/img/plogo.png" alt="admin logo" class="img img-responsive">
                    <h3 class="user-tag">admin</h3>
                </div>
                <!--end user image section-->
                <ul class="nav" id="side-menu">
                    <!-- second-level-items -->
                    <li>
                        <a href="adminindex.php"><i class="fa fa-user fa-fw"></i>Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i>Manage Setting<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                                
                            <li>
                                <a href="brgylist_table.php">Brgy. Account List</a>
                            </li>
                            <li>
                                <a href="executive_list.php">Executive Account List</a>
                            </li>
                            <li class="">
                                <a href="deleted_history_brgy.php">Deleted History</a>
                            </li>
                              <li>
                                <a href="brgymonitoring.php">Barangay Monitoring</a>
                            </li>
                             <li class="">
                                <a href="loghistory.php">Log History</a>
                            </li>
                            <li>
                                <a href="history_final_report.php">History Final Report</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i>Forms<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="adminindex.php?memo=true">Add Memo</a>
                            </li>
                            <li>
                                <a href="adminindex.php?memo=view">View Memo</a>
                            </li>
                            <li>
                                <a href="addbrgygrid.php">Add Brgy Details</a>
                            </li>
                             <li>
                                <a href="addexecutive_grid.php">Add Executive Details</a>
                            </li>
                            <li>
                                <a href="email.php">E-mail</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-floppy-o fa-fw "></i>Tables<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="brgygrid.php">Barangay & Executive Grid Table</a>
                            </li>
                             <li>
                                <a href="viewbrgyanswer.php">Barangay Answer Report</a>
                            </li>
                        </ul>
                    </li><!-- second-level-items -->
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw "></i> Final Reports<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="reports/reports/civilreport.php">Civil Reports</a>
                            </li>
                            <li>
                                <a href="reports/reports/educationalreport.php">Educational Reports</a>
                            </li>
                            <li>
                                <a href="reports/reports/housingreport.php">Housing Reports</a>
                            </li>
                            <li>
                                <a href="reports/reports/religionreport.php">Religion Reports</a>
                            </li>
                            <li>
                                <a href="history_final_report.php">Total Final Reports</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="last_menu">
                        <a href="#"><i class="fa fa-cogs fa-fw"></i> Actions<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="admin_messages.php">Messages</a>
                            </li>
                            <li>
                                <a href="reports/reports/educationalreport.php">Notifications</a>
                            </li>
                            <li>
                                <a href="logout.php">Logout</a>
                            </li>
                            
                        </ul>
                    </li>
                </ul><!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper" class="page-wrapper">