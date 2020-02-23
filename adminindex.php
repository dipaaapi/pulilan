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
<style>
    table {
        width: 100%;
        padding: 0;
        margin: 0;
        margin-top: 5vh;
        box-shadow: 0 0 4px;
        border-radius: 5px;
    }
</style>
<?php include('../pulilan/adminnav.php'); ?> 
    <h1 class="page-header">Message</h1>
    <?php
        if($done =="memo"){
    ?>

    <div class="alert alert-success"><div class="close" data-dismiss="alert">&times</div>Successfully Uploaded Memo</div>

    <?php
}

if(isset($_SESSION['notif'])&&!empty($_SESSION['notif'])){
    $notif = $_SESSION['notif'];
    ?>
    


    <?php
}

?>

<?php

if(isset($_GET['memo'])){
    $memo = $_GET['memo'];
}
global $memo;

if(isset($_GET['type'])){
    $type = $_GET['type'];
}
global $type;

if($type !="" && $memo == ""){

        $updateNotif = mysqli_query($con, "UPDATE message_tbl set notification_status = 'SEEN' where message_id = '$type'");



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
elseif($type =="" && $memo == ""){

?>


            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
                    <div class="alert alert-success alert-dismissible fade in" style="text-transform: uppercase;">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <i class="fa fa-folder-open"></i>Welcome to<b> <?php echo $_SESSION['username'];?></b> dashboard
                    </div>
                </div>
            </div><!--end  Welcome -->

            <form method="POST" action="notification_process/official_message_process.php">

            <div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" name="receiver" data-placement="right" placeholder="Receiver" required>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="text" id="subject" name="subject" placeholder="Subject" required>
            </div>
         
            <textarea id="message" name="message" placeholder="Write something.." style="height:200px"></textarea>

            <button type="submit" name="send_message" class="btn btn-primary" style="background-color: green;">Send Message</button>
        </div><!-- end wrapper -->
        </form>
       
    </div>
    <?php

}
elseif($type =="" && $memo == "true"){
    ?>

<form method="POST" action="achievment/create_memo.php" enctype="multipart/form-data">
    <h3>Add Memo</h3>

<input type="text" name="memo" placeholder="Memo Name / Memo No" required>

             <div class="item" name="receiver" required>
                    <input type="text" name="receiver" data-placement="right">
                      
                    </select>
                </div>

<textarea name="memo_body" required>Memo Body</textarea>
<input type="file" name="picture" id="picture"> <br><br/>



<button type="submit" name="send_memo" class="btn btn-primary">Create Memo</button>

</form>



    <?php
}
elseif($type =="" && $memo == "view"){

    $view_memo = mysqli_query($con, "SELECT * from memo");
    ?>

    <table class="table-hover">
        <tr><th style="background-color: white; padding: 1em;">Memo</th><th style="background-color: white; padding: 1em;">Memo Status</th><th style="background-color: white; padding: 1em;">View Memo</th></tr>

        <?php
        while($view_m = mysqli_fetch_array($view_memo)){
        ?>
        <tr><td style="background-color: green; padding: 1em; color: white;"><?php echo $view_m['project_name']; ?></td><td style="background-color: green; padding: 1em; color: white;"><?php echo $view_m['memo_status']; ?></td><td style="background-color: green; padding: 1em; color: white;"><a href="memo.php?view=<?php echo $view_m['memo_id']; ?>" class="btn btn-primary">View Memo</a></td></tr>
        <?php
}

        ?>
    </table>



<?php
}
?>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/dashboard-demo.js"></script>
</body>

</html>
