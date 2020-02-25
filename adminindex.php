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
        margin: 0;
        margin-top: 5vh;
        border-radius: 5px;
    }
    #memo {
        border-radius: 5px;
        padding: 5px;
        margin: 0;
        box-shadow: 0 0 7px;
    }
    h3 {
        margin: 0;
        padding: 10px;
    }
    form {
        padding: 10px 0;
    }
    form:hover, table:hover {
        box-shadow: 0 0 7px;
        padding: 10px;
        transition: .5s;
    }
    form input[name=receiver], form input[name=subject] {
        margin-bottom: 10px;
    }
    button[name=send_message], button[name=send_memo] {
        background-color: green;
        border: 1px solid green;
        text-align: center;
        text-transform: uppercase;
        color: white;
    }
    .submit_btn {
        text-align: center;
    }
    form input[name=picture], form textarea[name=memo_body] {
        margin-bottom: 10px;
    }
</style>
<?php include('../pulilan/adminnav.php'); ?> 
    <h1>Message</h1>
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
                <input class="form-control" type="text" name="receiver" data-placement="right" placeholder="Receiver" required>
                <input class="form-control" type="text" id="subject" name="subject" placeholder="Subject" required>
                <textarea id="message" name="message" placeholder="Write something.." rows="5" cols="100%"></textarea>
                <div class="submit_btn">
                    <button type="submit" name="send_message" class="btn">Send Message</button>
                </div>
        </div><!-- end wrapper -->
        </form>
       
    </div>
    <?php

}
elseif($type =="" && $memo == "true"){
    ?>

    <form method="POST" action="achievment/create_memo.php" enctype="multipart/form-data">
        <p>Add Memo</p>
        <input type="text" name="memo" placeholder="Memo Name / Memo No" required>
        <!-- <div class="item" name="receiver" required>
            <input type="text" name="receiver" data-placement="right">
        </div> -->
        <textarea name="memo_body" placeholder="Memo Body" rows="5" cols="100%" required></textarea>
        <input type="file" name="picture" id="picture" class="form-control">
        <div class="submit_btn">
            <button type="submit" name="send_memo" class="btn">Create Memo</button>
        </div>
    </form>

    <?php
}
elseif($type =="" && $memo == "view"){

    $view_memo = mysqli_query($con, "SELECT * from memo");
    ?>

    <table class="table">
        <tr class="label-info">
            <th>Memo Status</th>
            <th>View Memo</th>
            <th>Action</th>
        </tr>
        <?php
        while($view_m = mysqli_fetch_array($view_memo)){
        ?>
        <tr>
            <td>
                <?php echo $view_m['project_name']; ?>
            </td>
            <td>
                <?php echo $view_m['memo_status']; ?>
            </td>
            <td>
                <a href="memo.php?view=<?php echo $view_m['memo_id']; ?>" class="btn btn-primary">
                    View Memo
                </a>
            </td>
        </tr>
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
