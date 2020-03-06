<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();

if (!isset($_SESSION['username'])) {
  
}
?>
<?php include('brgynav.php') ?>
<h1>Message</h1>
<?php

if(isset($_SESSION['notif'])&&!empty($_SESSION['notif'])){
    $notif = $_SESSION['notif'];
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#alert").fadeOut(10000);
        });
    </script>
    <div class="alert alert-success" id="alert"><?php echo $notif; ?></div>


    <?php
}

?>
<?php

if(isset($_GET['type'])){
    $type = $_GET['type'];
}
global $type;

if(isset($_GET['view'])){
    $view = $_GET['view'];
}
global $view;
if($view == "memo"){

 $ll = mysqli_query($con, "UPDATE memo set notification_status = 'SEEN' where receiver = '$uid' && memo_status = 'APPROVED' && notification_status = 'UNSEEN'");

 $view_memo = mysqli_query($con, "SELECT * from memo where receiver = '$uid' && memo_status = 'APPROVED' && notification_status = 'SEEN'");
 $chec = mysqli_num_rows($view_memo);
 if($chec > 0){
 while($c = mysqli_fetch_array($view_memo)){
    ?>
<!--MEmo View -->
<fieldset>
<legend>Project Name: <?php echo $c['project_name']; ?></legend>
<strong>Receiver:</strong><?php echo $c['receiver']; ?><br>
<strong>Project Description: </strong>
<br>
<textarea disabled><?php echo $c['project_description']; ?></textarea>

</fieldset>

<center>******************************</center>



    <?php
}
}
else{
    echo '<p style="color: red;">No Records To Show<p>';
}
}
else{
if($type !=""){


    $update = mysqli_query($con, "UPDATE message_tbl set notification_status = 'SEEN' where message_id = '$type'");
    $sql3 = mysqli_query($con, "SELECT * from message_tbl where message_id = '$type'");
    $h = mysqli_fetch_array($sql3);


    $sender = $h['user_id'];


    $getSender_1 = mysqli_query($con, "SELECT * FROM mainuser_acc where user_id = '$sender'");
    $gg = mysqli_fetch_array($getSender_1);
    $senderName = $gg['name'];
    $brgy = $gg['brgy_location'];

    ?>
        
        <div class="col col-lg-4 col-md-4" align="center">
            Sender:<input type="text" disabled value="<?php echo $senderName; ?>" class="form-control">
        </div>
        <div class="col col-lg-4 col-md-4" align="center">
            Subject:<input type="text" disabled value="<?php echo $h['subject']; ?>" class="form-control">
        </div>
        <div class="col col-lg-4 col-md-4" align="center">
            Receiver:<input type="text" disabled value="<?php echo $h['brgy_location']; ?>" class="form-control">
        </div>
        <div class="col col-lg-12 col-md-12" align="center">
            Message:<textarea rows="5" cols="100%" class="form-control" disabled><?php echo $h['message']; ?></textarea>
        </div>
        
    <?php

}
else{

?>
            <div class="alert alert-success alert-dismissible fade in" style="text-transform: uppercase;">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <i class="fa fa-folder-open"></i>Welcome to<b> brgy. <?php echo $_SESSION['username'];?></b> dashboard
            </div>

            <form method="POST" action="notification_process/official_message_process.php">
                <input type="text" name="receiver" data-placement="right" placeholder="Receiver" required>
                <input type="text" id="subject" name="subject" placeholder="Subject" required>
                <textarea id="message" name="message" placeholder="Write something.." style="height:200px"></textarea>
                <button type="submit" name="send_message" class="btn btn-primary" style="background-color: green;">Send Message</button>
        </div><!-- end wrapper -->
        </form>
        <?php
    }
        if(isset($_POST['send'])){

            include "pulilan_db_connect.php";
            $receiver = $_POST['receiver'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

           $insert = "INSERT INTO mainmessage(receiver,subject,message) VALUES ('{$receiver}','{$subject}','{$message}')";
           $query = mysqli_query($connection, $insert);
           if($query){

              echo'<script>';
              echo'alert("MESSAGE SUCCESSFULLY SEND!");';
              echo'window.location.href="brgyindex.php";';
              echo'</script>'; 
           }
           else{
                echo"failed";
           }
        }
    }

        ?>
            
<?php include('../pulilan/adminfooter.php'); ?>