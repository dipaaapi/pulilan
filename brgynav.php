<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <link href="css/brgy.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <style>
input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
   </head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-button" href="brgyindex.php">
                    <img src="../pulilan/img/logo.png" alt="pulilan logo"/>
                </a>
            </div><!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul>
                <!-- main dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                            <?php
                            $con = mysqli_connect("localhost", "root", "", "pulilan");
                                    if(isset($_SESSION['lol'])&&!empty($_SESSION['lol'])){
                                        $uid = $_SESSION['lol'];
                                            }
                                        global $uid;
                            $get_notif = mysqli_num_rows(mysqli_query($con, "SELECT * from message_tbl where notification_status = 'UNSEEN' && brgy_location = '$uid'"));


                            ?>


                        <span class="top-label label label-danger"><?php echo $get_notif; ?></span><i class="fa fa-comments fa-3x"></i>
                    </a>
                    <!-- dropdown-messages -->
                    <ul class="dropdown-menu dropdown-messages">

                        <?php


                            $get_notif2 = mysqli_query($con, "SELECT * from message_tbl where brgy_location = '$uid' && notification_status = 'UNSEEN'");
                            while($d = mysqli_fetch_array($get_notif2)){
                                $sender = $d['user_id'];
                                $get_sender = mysqli_query($con, "SELECT * from mainuser_acc where user_id = '$sender'");
                                while($g = mysqli_fetch_array($get_sender)){
                                    $name = $g['name'];
                        ?>
                        <li>
                            <a href="brgyindex.php?type=<?php echo $d['message_id']; ?>">
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

                            $get_memo = mysqli_query($con, "SELECT * from memo where receiver = '$uid' && memo_status = 'APPROVED' && notification_status = 'UNSEEN'");
                            $count_total = mysqli_num_rows($get_memo);

                        ?>
                    
                        <span class="top-label label label-warning"><?php echo $count_total; ?></span>  <i class="fa fa-bell fa-3x"></i>
                    </a>
                    <!-- dropdown alerts-->
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="brgyindex.php?view=memo">
                                View Memo (Detected: <?php echo $count_total; ?>)
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
                    </ul>
                    <!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->

        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="side-nav" role="navigation">
            <!-- sidebar-collapse -->
                <!-- user image section-->
                <div class="user-section">
                    <img src="../pulilan/img/blogo.jpg" alt="brgy logo" class="img img-responsive">
                    <p class="user-p">Brgy. <?php echo $_SESSION['username']; ?></p>
                </div>
                <!--end user image section-->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <!-- second-level-items -->
                    <li>
                        <a href="brgyindex.php"><i class="fa fa-user fa-fw"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> Manage Settings<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                           
                            <li>
                                <a href="addofficials.php"> Add Brgy Officials</a>
                            </li>
                             <li>
                                <a href="addnewresident.php"> Add Resident</a>
                            </li>
                            <li>
                                <a href="brgy_resident_account_table.php"> Update Resident Details</a>
                            </li>
                            <li>
                                <a href="deleted_history_resident.php"> Deleted Resident Details</a>
                            </li>
                             <li>
                                <a href="deactivatedresidenthistory.php"> Deactivated Resident History</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i> Forms<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="brgyquestion.php"> Barangay Profile Questionnaire</a>
                            </li>
                            <li>
                                <a href="viewresidentanswer.php"> Resident Answer</a>
                            </li>
                            <li>
                                <a href="brgyemail.php"> E-mail</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-floppy-o fa-fw "></i> Tables<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="viewofficial_list.php"> View Officials</a>
                            </li>
                            <li>
                                <a href="brgyviewmemo.php"> View Brgy Memo</a>
                            </li>
                             <li>
                                <a href="viewresidentdetail.php"> View Resident Details</a>
                            </li>
                            <li>
                                <a href="brgy_resident_account_table.php"> Resident Account Table</a>
                            </li>
                           
                            <li>
                                <a href="brgy_final_report1.php"> Brgy. Final Report</a>
                            </li>
                        </ul>
                    </li><!-- second-level-items -->
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">