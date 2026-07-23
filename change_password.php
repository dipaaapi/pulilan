<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>
<?php include 'minnav.php'; ?>
                    <div>
                        <a class="img img-fluid" href="nlanding.php">
                          <img class="col col-lg-12 col-md-12 col-sm-12 col-12" src="../assets/img/pulilan-logo.png" alt="pulilan logo"/>
                        </a>
                        <h1 class="card-title fa fa-user" style="text-shadow: 1px 1px 2px red, 0 0 25px orange, 0 0 5px yellow;"> CBMS 2017 | Change Password Form</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Current Password" name="currentpassword" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Password" name="newpassword" type="password">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm Password" name="confirmpassword" type="password">
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="submit" value="Change & Submit" class="btn btn-outline btn-success btn-block">
                            </fieldset>
                        </form>
                        <?php
                        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                            $currentpassword = $_POST['currentpassword'];
                            $newpassword = $_POST['newpassword'];
                            $confirmpassword = $_POST['confirmpassword'];
                            
                            // Check connection and database
                            $connection = mysqli_connect("localhost", "root", "", "pulilan");
                            if (!$connection) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $getquery = "SELECT password FROM mainuser_acc WHERE username = '$username'";
                            $result = mysqli_query($connection, $getquery);
                            
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result); 
                                $currentpassworddb = $row['password'];
                                
                                if ($currentpassword == $currentpassworddb) {
                                    if ($newpassword == $confirmpassword) {
                                        // Change password in database
                                        $querychange = "UPDATE mainuser_acc SET password='$newpassword' WHERE username = '$username'";
                                        $update_query = mysqli_query($connection, $querychange);
                                        
                                        if (!$update_query) {
                                            echo '<div class="alert alert-danger" style="margin-top:10px;">Error updating password.</div>';
                                        } else {
                                            echo '<script>';
                                            echo 'alert("Successfully changed!");';
                                            echo 'window.location.href="brgyindex.php";';
                                            echo '</script>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-warning" style="margin-top:10px;">New password and confirmation do not match.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" style="margin-top:10px;">Current password is incorrect.</div>';
                                }
                            }
                            mysqli_close($connection);
                        }
                        ?>
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