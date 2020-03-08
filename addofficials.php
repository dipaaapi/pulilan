<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$username = $_SESSION['username'];
require('pulilan_db_connect.php');
?>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<?php include('brgynav.php'); ?>
  <h1>Add Barangay Official's Information</h1>

  <div class="col col-lg-12 col-md-12 panel panel-default">
    <form method="POST">        
      <fieldset>

          <div class="form-group col-md-12">
            <label>Enter Full Name</label>
            <input type="input" name="fullname" class="form-control" required>
          </div>

          <div class="form-group col-md-12">
           <label>Enter Position</label>
           <input type="input" name="position" class="form-control" required>   
          </div>

          <div class="form-group col-md-12">
           <label>Enter Email</label>
           <input type="input" name="email" class="form-control" required>   
          </div>

          <div class="form-group col-md-12">
           <label>Enter Contact Number</label>
           <input type="input" name="contact" class="form-control" required>   
          </div>
          
          <div class="form-group col-md-12">
           <label>Enter Brgy. Location</label>
           <input type="input" name="brgy_location" value="<?php echo $_SESSION['username'], $username;?>" class="form-control" required>
          </div>

          <div class="form-group col-md-12">
           <label>Select Gender</label>
           <select class="form-control" name="gender" required>
             <option value=""></option>
             <option value="Male">Male</option>
             <option value="Female">Female</option>
           </select>
          </div>
          
          <div class="form-group" align="center">
            <button type="submit" name="submit" class="btn btn-primary btn-outline fa fa-pencil"> Add Personnel</button>
          </div>

      </fieldset>
    </form>

  </div>
        <?php
          session_start();

          if(isset($_POST['submit']))
          {

            $fullname = $_POST['fullname'];
            $position = $_POST['position'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $contact = $_POST['contact'];
            $brgy_location = $_POST['brgy_location'];
            $type = 'personnel';

            $connection = mysqli_connect("localhost", "root", "", "pulilan");

            $query = mysqli_query($connection, "INSERT INTO brgydetails_tbl(fullname, position, email, gender, contact, brgy_location, type) VALUES('$fullname', '$position', '$email', '$gender', '$contact', '$brgy_location','$type')");

            if($query)
            {

               echo'<script>';
               echo'alert("successfully Added!");';
               echo'window.location.href="addofficials.php";';
               echo'</script>';
            }


          }
        ?>

<?php include('../pulilan/adminfooter.php'); ?>