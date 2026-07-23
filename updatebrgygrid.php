<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('pulilan_db_connect.php');
include('../pulilan/adminnav.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle form submission for updating using brgydetails_tbl
if(isset($_POST['submit'])){
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $fullname = mysqli_real_escape_string($connection, $_POST['name']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $contact = mysqli_real_escape_string($connection, $_POST['contact']);
    $brgy_location = mysqli_real_escape_string($connection, $_POST['brgy_location']);
    
    // Siguraduhing may id bago mag-update para iwas disgrasya
    if(!empty($id)){
        $update = mysqli_query($connection, "UPDATE brgydetails_tbl SET name='$fullname', position='$position', email='$email', gender='$gender', contact='$contact', brgy_location='$brgy_location' WHERE id='$id'");
        
        if($update){
            echo '<div class="alert alert-success alert-dismissible" role="alert" style="margin: 20px;">
                    <strong>Success!</strong> Barangay official information successfully updated. Refreshing...
                  </div>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href="updatebrgygrid.php";
                    }, 1500);
                  </script>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible" role="alert" style="margin: 20px;">
                    <strong>Error!</strong> Failed to update database: ' . mysqli_error($connection) . '
                  </div>';
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible" role="alert" style="margin: 20px;">
                <strong>Error!</strong> Invalid Record ID. Update aborted to protect data.
              </div>';
    }
}
?>

<!-- Custom CSS para sa DataTables alignment at Flexbox -->
<style>
    .dataTables_wrapper .row:first-child, 
    .dataTables_wrapper .row:last-child {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-left: 0;
        margin-right: 0;
    }
    .dataTables_wrapper .row:first-child > div,
    .dataTables_wrapper .row:last-child > div {
        padding-left: 0;
        padding-right: 0;
    }
    .dataTables_length {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: normal;
        margin-bottom: 0;
    }
    .dataTables_length select {
        display: inline-block;
        width: auto;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .dataTables_filter {
        text-align: right;
    }
    .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: normal;
        margin-bottom: 0;
    }
    .dataTables_filter input {
        display: inline-block;
        width: auto;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .dataTables_info {
        padding-top: 8px !important;
    }
    .dataTables_paginate {
        text-align: right;
        margin: 0;
    }
</style>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <h1 class="page-header" style="border-bottom: 2px solid #e7e7e7; padding-bottom: 10px;">Barangay & Executive Officials</h1>
    </div>
</div>

<?php 
if(!empty($id)):
    $get_info = mysqli_query($connection, "SELECT * FROM brgydetails_tbl WHERE id = '$id'");
    $info_data = mysqli_fetch_assoc($get_info);
    if($info_data):
        if($action == 'edit'):
?>
<!-- EDIT / UPDATE FORM SECTION -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <div class="panel panel-default shadow-sm" style="border: 1px solid #ccd6dd; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div class="panel-heading" style="background-color: #337ab7; color: white; padding: 12px 15px; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <b style="font-size: 16px;"><i class="fa fa-pencil-square-o"></i> Update Official Information: <?php echo $info_data['name']; ?></b>
                <a href="updatebrgygrid.php" class="btn btn-default btn-xs pull-right" style="color: #337ab7; font-weight: bold; padding: 3px 10px;">Close</a>
            </div>
            <div class="panel-body" style="padding: 20px;">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $info_data['id']; ?>">
                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-weight: 600; color: #444;">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $info_data['name']; ?>" required style="border-radius: 4px; height: 38px;">
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-weight: 600; color: #444;">Position</label>
                                <input type="text" name="position" class="form-control" value="<?php echo $info_data['position']; ?>" required style="border-radius: 4px; height: 38px;">   
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-weight: 600; color: #444;">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $info_data['email']; ?>" required style="border-radius: 4px; height: 38px;">   
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-weight: 600; color: #444;">Gender</label>
                                <select name="gender" class="form-control" required style="border-radius: 4px; height: 38px;">
                                    <option value="" disabled <?php echo empty($info_data['gender']) ? 'selected' : ''; ?>>Select Gender</option>
                                    <option value="Male" <?php echo ($info_data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($info_data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>   
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label style="font-weight: 600; color: #444;">Contact Number</label>
                                <input type="text" name="contact" class="form-control" value="<?php echo $info_data['contact']; ?>" required placeholder="e.g., 09123456789" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" style="border-radius: 4px; height: 38px;">   
                            </div>
                            <div class="form-group col-md-6">
                                <label style="font-weight: 600; color: #444;">Barangay Location</label>
                                <input type="text" name="brgy_location" class="form-control" value="<?php echo $info_data['brgy_location']; ?>" required style="border-radius: 4px; height: 38px;">   
                            </div>
                        </div>

                        <div class="row" style="margin-top: 15px;">
                            <div class="form-group col-md-12 text-right">
                                <button type="submit" name="submit" class="btn btn-primary" style="padding: 10px 25px; font-weight: bold; border-radius: 4px;"><i class="fa fa-save"></i> Save Changes</button>
                                <a href="updatebrgygrid.php" class="btn btn-default" style="padding: 10px 20px; border-radius: 4px; margin-left: 5px;">Cancel</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?php elseif($action == 'view'): ?>
<!-- VIEW OFFICIAL FULL INFORMATION CARD SECTION -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <div class="panel panel-info" style="border: 1px solid #bce8f1; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div class="panel-heading" style="background-color: #d9edf7; color: #31708f; border-color: #bce8f1; padding: 12px 15px; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <h3 class="panel-title" style="font-size: 16px; font-weight: bold; margin: 0;">
                    <i class="fa fa-user-circle"></i> Official Details: <?php echo $info_data['name']; ?>
                    <a href="updatebrgygrid.php" class="btn btn-default btn-xs pull-right" style="color: #31708f; font-weight: bold; padding: 3px 10px; margin-top: -3px;">Close View</a>
                </h3>
            </div>
            <div class="panel-body" style="background-color: #fcfcfc; padding: 20px;">
                <div class="row" style="margin-bottom: 12px;">
                    <div class="col-md-4">
                        <div style="background: #ffffff; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 5px;">
                            <span style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 3px;">Full Name</span>
                            <span style="font-size: 15px; color: #2d3748; font-weight: 600;"><?php echo $info_data['name']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #ffffff; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 5px;">
                            <span style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 3px;">Position</span>
                            <span style="font-size: 15px; color: #2d3748; font-weight: 600;"><?php echo $info_data['position']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #ffffff; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 5px;">
                            <span style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 3px;">Brgy. Location</span>
                            <span style="font-size: 15px; color: #2d3748; font-weight: 600;"><?php echo $info_data['brgy_location']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div style="background: #ffffff; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 5px;">
                            <span style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 3px;">Email Address</span>
                            <span style="font-size: 15px; color: #2d3748; font-weight: 600;"><?php echo $info_data['email']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #ffffff; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 5px;">
                            <span style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 3px;">Gender</span>
                            <span style="font-size: 15px; color: #2d3748; font-weight: 600;"><?php echo $info_data['gender']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #ffffff; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 5px;">
                            <span style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 3px;">Contact Number</span>
                            <span style="font-size: 15px; color: #2d3748; font-weight: 600;"><?php echo $info_data['contact']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12 text-right">
                        <a href="updatebrgygrid.php?id=<?php echo $info_data['id']; ?>&action=edit" class="btn btn-primary btn-sm" style="padding: 8px 18px; font-weight: bold;"><i class="fa fa-pencil"></i> Edit This Official</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
        endif;
    endif;
endif; 
?>

<!-- OFFICIALS TABLE LIST -->
<div class="panel panel-default" style="border: 1px solid #ccd6dd; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <div class="panel-heading" style="background-color: #f5f5f5; border-bottom: 1px solid #e2e8f0; padding: 15px; border-top-left-radius: 5px; border-top-right-radius: 5px;">
        <b style="font-size: 16px; color: #333;"><i class="fa fa-list"></i> List of Officials</b>
    </div>
    <div class="panel-body" style="padding: 20px;">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width: 100%; margin-bottom: 0;">
            <thead>
                <tr style="background-color: #fafafa;">  
                    <th style="vertical-align: middle;">Full Name</th>
                    <th style="vertical-align: middle;">Position</th>
                    <th style="vertical-align: middle;">Brgy. Location</th>
                    <th class="warning text-center" style="width: 110px; vertical-align: middle;">View</th>
                    <th class="info text-center" style="width: 110px; vertical-align: middle;">Update</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $results = mysqli_query($connection, "SELECT * FROM brgydetails_tbl WHERE position = 'Chairman' OR position = 'DILG' OR position = 'executive'");
                while ($row = mysqli_fetch_assoc($results)):
                ?>
                <tr>
                    <td style="vertical-align: middle; padding: 12px;"><?php echo $row['name']; ?></td>
                    <td style="vertical-align: middle; padding: 12px;"><?php echo $row['position']; ?></td>
                    <td style="vertical-align: middle; padding: 12px;"><?php echo $row['brgy_location']; ?></td>
                    <td class="text-center" style="vertical-align: middle; padding: 10px;">
                        <a href="updatebrgygrid.php?id=<?php echo $row['id'];?>&action=view" class="btn btn-outline btn-info btn-sm" style="padding: 6px 12px; font-weight: 600;"><i class="fa fa-user"></i> View</a>
                    </td>
                    <td class="text-center" style="vertical-align: middle; padding: 10px;">
                        <a href="updatebrgygrid.php?id=<?php echo $row['id'];?>&action=edit" class="btn btn-outline btn-primary btn-sm" style="padding: 6px 12px; font-weight: 600;"><i class="fa fa-pencil"></i> Edit</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Core Scripts - Include with every page -->
<script src="assets/plugins/jquery-1.10.2.js"></script>
<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
<script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="assets/scripts/siminta.js"></script>

<!-- Page-Level Plugin Scripts-->
<script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#dataTables-example').DataTable();
        
        if (table.data().count() <= 10) {
            $('.dataTables_length, .dataTables_paginate, .dataTables_info').hide();
        }
    });
</script>

<?php include('../pulilan/adminfooter.php'); ?>