<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();

if (!isset($_SESSION['username'])) {
  
}
?>
<?php 
if (!isset($_SESSION['brgy_id'])) {
  
}
  if(isset($_GET['name'])){
              $name = $_GET['name'];
            }
  if(isset($_GET['username'])){
              $username = $_GET['username'];
            }
  if(isset($_GET['password'])){
              $password = $_GET['password'];
            }
  if(isset($_GET['brgy_id'])){
            $brgy_id = $_GET['brgy_id'];
          }
  if(isset($_GET['email'])){
              $email =$_GET['email'];
            }
  if(isset($_GET['contact'])){
              $brgy_id_num =$_GET['contact'];
            }
  if(isset($_GET['brgy_location'])){
              $brgy_location =$_GET['brgy_location'];
            }
  if(isset($_GET['province'])){
              $province =$_GET['province'];
            }    
  if(isset($_GET['city_municipality'])){
              $city_municipality = $_GET['city_municipality'];
            }
  if(isset($_GET['purok_district'])){
              $purok_district = $_GET['purok_district'];
            }
  if(isset($_GET['no_son'])){
              $no_son =$_GET['no_son'];
            }
  if(isset($_GET['no_daughter'])){
              $no_daughter =$_GET['no_daughter'];
            }          
  if(isset($_GET['no_nephew'])){
              $no_nephew =$_GET['no_nephew'];
            }
  if(isset($_GET['no_niece'])){
              $no_niece =$_GET['no_niece'];
            }  
  if(isset($_GET['present'])){
              $present =$_GET['present'];
            }

session_start();

          if(isset($_POST['submit']))
          {
            if(!empty($_POST['username']) && !empty(['password'])){

                $name = $_POST['name'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $brgy_id = $_POST['brgy_id'];
                $email = $_POST['email'];
                $contact = $_POST['contact'];
                $brgy_location = $_POST['brgy_location'];
                $province = $_POST['province'];
                $address = $_POST['address'];
                $city_municipality = $_POST['city_municipality'];
                $purok_district = $_POST['purok_district'];
                $gender = $_POST['gender'];
                $position = $_POST['position'];
                $civil_status = $_POST['civil_status'];
                $registered_voter = $_POST['registered_voter'];
                $no_son = $_POST['no_son'];
                $no_daughter = $_POST['no_daughter'];
                $no_nephew = $_POST['no_nephew'];
                $no_niece = $_POST['no_niece'];
                $type = 'resident';

                 $connection = mysqli_connect("localhost","root","","pulilan");
                  if(($check = mysqli_num_rows(mysqli_query($connection, "SELECT * from mainuser_acc where brgy_id = '$brgy_id'"))) > 0){
           

                      header("location: addnewresident.php?brgy_id=".$brgy_id."&&name=".$name."&&username=".$username."&&password=".$password."&&email=".$email."&&contact=".$contact."&&brgy_location=".$brgy_location."&&province=".$province."&&address=".$address."&&city_municipality=".$city_municipality."&&purok_district=".$purok_district."&&no_son=".$no_son."&&no_daughter=".$no_daughter."&&no_nephew=".$no_nephew."&&no_niece=".$no_niece."&&present=1");

              }
              else{
                 $query = mysqli_query($connection, "INSERT INTO mainuser_acc(name, username, password, brgy_id, email, contact, brgy_location, province, address, city_municipality, purok_district, gender, position, civil_status, registered_voter, no_son, no_daughter, no_nephew, no_niece, type) VALUES ('$name', '$username', '$password', '$brgy_id', '$email', '$contact', '$brgy_location', '$province', '$address', '$city_municipality', '$purok_district', '$gender', '$position', '$civil_status', '$registered_voter', '$no_son', '$no_daughter', '$no_nephew', '$no_niece', '$type')");

                 if($query)
                 {
                  echo'<script>';
               echo'alert("successfully Added!");';
               echo'window.location.href="addnewresident.php";';
               echo'</script>';

                 }
                 else
                 {
                   echo 'mysqli_error';
                 }
}
           }
         }
         include('brgynav.php'); 
?>



  <!-- Page Header -->
    <h1>Add New Resident</h1>
  <!--End Page Header -->


<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
  <form method="POST">
      <input placeholder="Enter Full Name" type="input" name="name" class="form-control" value="<?php echo $name; ?>" required>
      <input placeholder="Enter username" type="input" name="username" class="form-control" value="<?php echo $username; ?>" required>
      <input placeholder="Enter Password" type="input" name="password" class="form-control" value="<?php echo $password; ?>" required>
      <?php
      if($present =="1"){
      ?>
      <p style="color: red">*Please input new username</p>
      <?php
      }
      ?>
      <input type="input" name="brgy_id" class="form-control" placeholder="Enter Five Digit Number Only..." value="<?php echo $brgy_id; ?>"  required 
      <?php  if($present =="1"){
      ?>  
      style="border: 1px solid red;"
      <?php
      }
      ?>
        >
      <input placeholder="Enter Email" type="input" name="email" class="form-control" value="<?php echo $email; ?>" required>
      <input placeholder="Enter Contact Number" type="input" name="contact" class="form-control" value="<?php echo $contact; ?>" required>
      <input placeholder="Enter Barangay Location" type="input" name="brgy_location" class="form-control" value="<?php echo $_SESSION['username']; ?>" required>
      <input placeholder="Enter Province" type="input" name="province" class="form-control" value="Bulacan" required>
      <input placeholder="Enter Address" type="input" name="address" class="form-control" value="<?php echo $address; ?>" required>
      <input placeholder="Enter City/Municipality" type="input" name="city_municipality" class="form-control" value="Pulilan" required>
      <input placeholder="Enter Purok/District" type="input" name="purok_district" class="form-control" value="<?php echo $purok_district; ?>" required>
      <select class="form-control" name="gender" data-placement="right"  required>
        <option value="" selected="selected">-Select Gender-</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
      <select class="form-control" name="position" data-placement="right" required>
        <option value="" selected="selected">-Select Family Position-</option>
        <option value="Grand Father">Grand Father</option>
        <option value="Grand Mother">Grand Mother</option>
        <option value="Father">Father</option>
        <option value="Mother">Mother</option>
        <option value="Daughter">Daughter</option>
        <option value="Son">Son</option>
        <option value="Father-in-law">Father-in-law</option>
        <option value="Mother-in-law">Mother-in-law</option>
        <option value="Daughter-in-law">Daughter-in-law</option>
        <option value="Son-in-law">Son-in-law</option>
        <option value="Grand Daughter">Grand Daughter</option>
        <option value="Grand Son">Grand Son</option>
        <option value="Nephew">Nephew</option>
        <option value="Niece">Niece</option>
        <option value="Aunt">Aunt</option>
        <option value="Uncle">Uncle</option>
      </select>
      <select class="form-control" name="civil_status" data-placement="right" required>
        <option value=""> --Select Civil Status-- </option>
        <option value="Single">Single</option>
        <option value="Legally Married">Legally Married</option>
        <option value="Divorced/Separated">Divorced/Separated</option>
        <option value="Common Law/Live in">Common Law/Live in</option>
        <option value="Widowed">Widowed</option>
      </select>
      <select class="form-control" name="registered_voter" data-placement="right" required>
        <option value="" selected="selected">-Select Voters Status-</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
      </select>
      <input placeholder="Number of Son" type="input" name="no_son" value="<?php echo $no_son; ?>" class="form-control">
      <input placeholder="Number of Daughter" type="input" name="no_daughter" value="<?php echo $no_daughter; ?>"  class="form-control">
      <input placeholder="Number of Nephew" type="input" name="no_nephew"  value="<?php echo $no_nephew; ?>" class="form-control">
      <input placeholder="Number of Niece" type="input" name="no_niece" value="<?php echo $no_niece; ?>" class="form-control">
      
      <div class="form-group" align="center">
        <button type="submit" name="submit" class="fa fa-pencil btn btn-outline btn-primary"> Add Family Member</button>
      </div>
  </form>

<?php include('../pulilan/adminfooter.php'); ?>
