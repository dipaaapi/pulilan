<?php
session_start();

// Initialize variables from REQUEST to persist form data across submissions
$brgy_location = $_REQUEST['brgy_location'] ?? '';
$name = $_REQUEST['name'] ?? '';
$username = $_REQUEST['username'] ?? '';
$password = $_REQUEST['password'] ?? '';
$nationality = $_REQUEST['nationality'] ?? '';
$brgy_id_num = $_REQUEST['brgy_id_num'] ?? '';
$present = $_REQUEST['present'] ?? '';
$gender = $_REQUEST['gender'] ?? '';

$error_message = '';
$success_message = '';

if (isset($_POST["submit"])) {
    if (!empty($username) && !empty($password)) {
        $accounttype = 'resident';
        
        $connection = mysqli_connect("localhost", "root", "", "pulilan");
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($connection, "SELECT id FROM mainuser_acc WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $present = "1";
            $error_message = "Username Already Exists";
        } else {
            // Insert new user using prepared statements
            $insert_stmt = mysqli_prepare($connection, "INSERT INTO mainuser_acc (brgy_location, name, gender, username, password, nationality, brgy_id_num, accounttype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            // Note: In a production environment, passwords should be hashed using password_hash()
            mysqli_stmt_bind_param($insert_stmt, "ssssssss", $brgy_location, $name, $gender, $username, $password, $nationality, $brgy_id_num, $accounttype);
            
            if (mysqli_stmt_execute($insert_stmt)) {
                echo '<script>alert("Successfully Registered!"); window.location.href="login.php";</script>';
                exit();
            } else {
                $error_message = "Registration failed: " . mysqli_error($connection);
            }
            mysqli_stmt_close($insert_stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
    } else {
        $error_message = "Username and password are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - CBMS 2017</title>
    <!-- Core CSS - Include with every page -->
    <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
</head>
<body class="body-Login-back">
    <div class="container">
        <div class="changep">
            <div class="row">
              <div class="col-md-4 offset-md-4">
                
                <?php if (!empty($error_message) || $present == "1"): ?>
                    <div style="position: absolute; z-index: 999; width: 90%; max-width: 400px;">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo !empty($error_message) ? htmlspecialchars($error_message) : "Username Already Exists"; ?>
                          </div>
                    </div>
                    <?php endif; ?>

                    <div class="login-card card">                  
                        <div class="card-header text-center">
                            <a href="nlanding.php">
                              <img src="../assets/img/pulilan-logo.png" alt="Logo"/>
                            </a>
                            <h1 class="card-title fa fa-user" style="text-shadow: 1px 1px 2px red, 0 0 25px orange, 0 0 5px yellow;"> CBMS 2017 | Registration form</h1>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="registration.php">
                                <div class="item">
                                    <div class="form-group">
                                        <input placeholder="Full name" type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($name); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Barangay Location" type="text" class="form-control" name="brgy_location" required value="<?php echo htmlspecialchars($brgy_location); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="col col-lg-6 col-md-6 col-sm-6 col-6 text-center" style="padding-top: 5px;">Gender:</label>
                                        <select class="col col-lg-6 col-md-6 col-sm-6 col-6 form-control" style="width: 50%;" name="gender" id="gender" required>
                                            <option value="" <?php if(empty($gender)) echo 'selected'; ?>></option>
                                            <option value="Male" <?php if($gender == 'Male') echo 'selected'; ?>>Male</option>
                                            <option value="Female" <?php if($gender == 'Female') echo 'selected'; ?>>Female</option>
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <?php if ($present == "1"): ?>
                                            <p style="color: red; margin-bottom: 5px; font-size: 12px;">*Please input a new username</p>
                                        <?php endif; ?>
                                        <input placeholder="Username" type="text" class="form-control" name="username" required value="<?php echo htmlspecialchars($username); ?>" <?php if($present == "1") echo 'style="border: 1px solid red;"'; ?>>
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Password" type="password" class="form-control" name="password" required value="<?php echo htmlspecialchars($password); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Nationality" type="text" class="form-control" name="nationality" value="<?php echo htmlspecialchars($nationality); ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <input placeholder="Barangay ID Number" type="text" class="form-control" name="brgy_id_num" required value="<?php echo htmlspecialchars($brgy_id_num); ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success" type="submit" name="submit">Register</button>
                                    </div>
                                    <div class="form-group text-center">
                                        <a href="login.php">Already have an account? Login here</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
</body>
</html>