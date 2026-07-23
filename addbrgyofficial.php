<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('pulilan_db_connect.php'); // O kaya ay mysqli_connect("localhost", "root", "", "pulilan");

// Handle form submission for adding new barangay official
if(isset($_POST['submit'])) {
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $contact = mysqli_real_escape_string($connection, $_POST['contact']);
        $brgy_location = mysqli_real_escape_string($connection, $_POST['brgy_location']);
        $no_purok = mysqli_real_escape_string($connection, $_POST['no_purok']);
        $major_sources = mysqli_real_escape_string($connection, $_POST['major_sources']);
        $brgy_classification = mysqli_real_escape_string($connection, $_POST['brgy_classification']);
        $char_brgy = mysqli_real_escape_string($connection, $_POST['char_brgy']);
        $gender = mysqli_real_escape_string($connection, $_POST['gender']);
        $position = mysqli_real_escape_string($connection, $_POST['position']);
        $male_tanod = mysqli_real_escape_string($connection, $_POST['male_tanod']);
        $female_tanod = mysqli_real_escape_string($connection, $_POST['female_tanod']);
        $male_health_worker = mysqli_real_escape_string($connection, $_POST['male_health_worker']);
        $female_health_worker = mysqli_real_escape_string($connection, $_POST['female_health_worker']);
        $male_nutrition_scholar = mysqli_real_escape_string($connection, $_POST['male_nutrition_scholar']);
        $female_nutrition_scholar = mysqli_real_escape_string($connection, $_POST['female_nutrition_scholar']);
        $male_purok_leaders = mysqli_real_escape_string($connection, $_POST['male_purok_leaders']);
        $female_purok_leaders = mysqli_real_escape_string($connection, $_POST['female_purok_leaders']);
        $male_librarian = mysqli_real_escape_string($connection, $_POST['male_librarian']);
        $female_librarian = mysqli_real_escape_string($connection, $_POST['female_librarian']);
        $male_day_care_worker = mysqli_real_escape_string($connection, $_POST['male_day_care_worker']);
        $female_day_care_worker = mysqli_real_escape_string($connection, $_POST['female_day_care_worker']);
        $male_utility_worker = mysqli_real_escape_string($connection, $_POST['male_utility_worker']);
        $female_utility_worker = mysqli_real_escape_string($connection, $_POST['female_utility_worker']);
        $type = 'official';
        
        $query = mysqli_query($connection, "INSERT INTO brgydetails_tbl(name, email, username, password, contact, brgy_location, no_purok, major_sources, brgy_classification, char_brgy, gender, position, male_tanod, female_tanod, male_health_worker, female_health_worker, male_nutrition_scholar, female_nutrition_scholar, male_purok_leaders, female_purok_leaders, male_librarian, female_librarian, male_day_care_worker, female_day_care_worker, male_utility_worker, female_utility_worker, type) VALUES('$name', '$email', '$username', '$password', '$contact', '$brgy_location', '$no_purok', '$major_sources', '$brgy_classification', '$char_brgy', '$gender', '$position', '$male_tanod', '$female_tanod', '$male_health_worker', '$female_health_worker', '$male_nutrition_scholar', '$female_nutrition_scholar', '$male_purok_leaders', '$female_purok_leaders', '$male_librarian', '$female_librarian', '$male_day_care_worker', '$female_day_care_worker', '$male_utility_worker', '$female_utility_worker', '$type')");

        if($query) {
            echo '<script>';
            echo 'alert("Successfully Added!");';
            echo 'window.location.href="updatebrgygrid.php";';
            echo '</script>';
        } else {
            echo '<script>alert("Error: ' . mysqli_error($connection) . '");</script>';
        }
    }
}

include('../pulilan/adminnav.php');
?>

<!-- Optional styles / scripts -->
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <h1 class="page-header" style="border-bottom: 2px solid #e7e7e7; padding-bottom: 10px;">Barangay Officials Information Form</h1>
    </div>
</div>

<div class="panel panel-default" style="border: 1px solid #ccd6dd; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <div class="panel-heading" style="background-color: #f5f5f5; border-bottom: 1px solid #e2e8f0; padding: 15px; border-top-left-radius: 5px; border-top-right-radius: 5px;">
        <b style="font-size: 16px; color: #333;"><i class="fa fa-user-plus"></i> Add New Barangay Official & Details</b>
    </div>
    <div class="panel-body" style="padding: 20px;">
        <form method="POST">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Full Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required style="border-radius: 4px; height: 38px;">
                </div>

                <div class="form-group col-md-4">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-4">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required style="border-radius: 4px; height: 38px;">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required style="border-radius: 4px; height: 38px;">
                </div>
                 
                <div class="form-group col-md-4">
                    <label>Contact Number:</label>
                    <input type="text" name="contact" class="form-control" placeholder="Enter Contact Number" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-4">
                    <label>Barangay Location:</label>
                    <input type="text" name="brgy_location" class="form-control" placeholder="Enter Barangay Location" required style="border-radius: 4px; height: 38px;">   
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Number of Purok/Sitios:</label>
                    <input type="text" name="no_purok" class="form-control" placeholder="Enter Number of Purok/Sitios" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-6">
                    <label>Major Source of Livelihood:</label>
                    <input type="text" name="major_sources" class="form-control" placeholder="Enter Major Source of Livelihood" required style="border-radius: 4px; height: 38px;">   
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Brgy Classification:</label>
                    <select class="form-control" name="brgy_classification" required style="border-radius: 4px; height: 38px;">
                        <option value="">Select Classification</option>
                        <option value="Urban">Urban</option>
                        <option value="Rural">Rural</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Brgy. Characteristic:</label>
                    <select class="form-control" name="char_brgy" required style="border-radius: 4px; height: 38px;">
                        <option value="">Select Characteristic</option>
                        <option value="Plain">Plain</option>
                        <option value="Upland">Upland</option>
                        <option value="Mountainious">Mountainious</option>
                        <option value="Coastal">Coastal</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Gender:</label>
                    <select class="form-control" name="gender" required style="border-radius: 4px; height: 38px;">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Position:</label>
                    <select class="form-control" name="position" required style="border-radius: 4px; height: 38px;">
                        <option value="">Select Position</option>
                        <option value="Chairman">Chairman</option>
                        <option value="Secretary">Secretary</option>
                    </select>
                </div>
            </div>

            <hr style="margin: 20px 0; border-top: 1px solid #e2e8f0;">
            <h4 style="margin-bottom: 15px; font-weight: bold; color: #333;">Staff / Workforce Breakdown</h4>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Male Tanod:</label>
                    <input type="text" name="male_tanod" class="form-control" placeholder="Male Tanod" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Female Tanod:</label>
                    <input type="text" name="female_tanod" class="form-control" placeholder="Female Tanod" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Male Health Worker:</label>
                    <input type="text" name="male_health_worker" class="form-control" placeholder="Male Health Worker" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Female Health Worker:</label>
                    <input type="text" name="female_health_worker" class="form-control" placeholder="Female Health Worker" required style="border-radius: 4px; height: 38px;">   
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Male Nutrition Scholar:</label>
                    <input type="text" name="male_nutrition_scholar" class="form-control" placeholder="Male Nutrition Scholar" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Female Nutrition Scholar:</label>
                    <input type="text" name="female_nutrition_scholar" class="form-control" placeholder="Female Nutrition Scholar" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Male Purok Leaders:</label>
                    <input type="text" name="male_purok_leaders" class="form-control" placeholder="Male Purok Leaders" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Female Purok Leaders:</label>
                    <input type="text" name="female_purok_leaders" class="form-control" placeholder="Female Purok Leaders" required style="border-radius: 4px; height: 38px;">   
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Male Librarian:</label>
                    <input type="text" name="male_librarian" class="form-control" placeholder="Male Librarian" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Female Librarian:</label>
                    <input type="text" name="female_librarian" class="form-control" placeholder="Female Librarian" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Male Day Care Worker:</label>
                    <input type="text" name="male_day_care_worker" class="form-control" placeholder="Male Day Care Worker" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-3">
                    <label>Female Day Care Worker:</label>
                    <input type="text" name="female_day_care_worker" class="form-control" placeholder="Female Day Care Worker" required style="border-radius: 4px; height: 38px;">   
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Male Utility Worker:</label>
                    <input type="text" name="male_utility_worker" class="form-control" placeholder="Male Utility Worker" required style="border-radius: 4px; height: 38px;">   
                </div>

                <div class="form-group col-md-6">
                    <label>Female Utility Worker:</label>
                    <input type="text" name="female_utility_worker" class="form-control" placeholder="Female Utility Worker" required style="border-radius: 4px; height: 38px;">
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="form-group col-md-12 text-right">
                    <button type="submit" name="submit" class="btn btn-primary" style="padding: 10px 25px; font-weight: bold; border-radius: 4px;"><i class="fa fa-save"></i> Add Information</button>
                    <a href="updatebrgygrid.php" class="btn btn-default" style="padding: 10px 20px; border-radius: 4px; margin-left: 5px;">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include('../pulilan/adminfooter.php'); ?>