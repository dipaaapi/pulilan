<?php include('../pulilan/adminnav.php');?>
  <style>
    form {
      padding: 10px 20%;
      margin-top: 5vh;
      border-radius: 5px;
      box-shadow: 0 0 4px;
      background-color: rgb(1, 1, 0, .8);
    }
    input[type="input"] {
      padding: 10px 0;
      margin: 10px 0;
      width: 100%;
      border-radius: 5px;
      display: block;
    }
    .button {
      color: #fff;
      background-color: #008e00;
      text-align: center;
      width: 50%;
      border: none;
      border-radius: 5px;
      text-transform: uppercase;
    }
    .button:hover {
      box-shadow: 0 0 7px black;
    }
    .submit-btn {
      width: 100%;
      text-align: center;
    }
    @media(min-width:425px) {
      .button {
        width: 100%;
      }
      form {
        padding: 10px 20%;
        margin-top: 5vh;
        border-radius: 5px;
        box-shadow: 0 0 4px;
        background-color: rgba(0, 142, 0, 0.5);
      }
    }
  </style>
  <h1 class="page-header">Barangay Official's Information</h1>
  <link rel="stylesheet" href="css/jquery-ui.css">
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>
    <form method="POST">
      <input id="fullname" type="input" name="fullname"  placeholder="Enter Full Name" value="" required>
      <input  id="" type="input" name="position"  placeholder="Enter Position" value="" required>   
      <input  id="email" type="input" name="email"  placeholder="Enter Email" value="" required>   
      <input  id="gender" type="input" name="gender"  placeholder="Enter Gender" value="" required>
      <input  id="" type="input" name="contact" placeholder="Enter Contact Number" value="" required>
      <input  id="" type="input" name="brgy_location" placeholder="Enter Department" value="" required>
      <div class="submit-btn">
        <button type="submit" name="submit" class="button">Add Information</button>
      </div>
    </form>
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
            $type = 'executive';

            $connection = mysqli_connect("localhost", "root", "", "pulilan");

            $query = mysqli_query($connection, "INSERT INTO mainuser_acc(name, position, email, gender, contact, brgy_location, type) VALUES('$fullname', '$position', '$email', '$gender', '$contact', '$brgy_location','$type')");

            if($query)
            {

               echo'<script>';
               echo'alert("successfully Added!");';
               echo'window.location.href="addexecutive_grid.php";';
               echo'</script>';
            }


          }
        ?>

<?php include('../pulilan/adminfooter.php'); ?>