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

if(isset($_GET['view'])){
    $view_memo = $_GET['view'];
}
global $view_memo;

?>
<style>
    .composed {
        padding: 10px;
        width: 50%;
    }
    .composed:hover {
        box-shadow: 0 0 10px;
        border-radius: 5px;
        transition: .5s;
        background: #fff;
        border: 1px solid #ddd;
    }
    #attachment-viewer {
        position: absolute;
        top: 14vh;
        right: 10vw;
        width: 45%;
        height: 70vh;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    #attachment-viewer:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>
<?php include('../pulilan/adminnav.php'); ?>
<?php
if($view_memo != ""){

    $con = mysqli_connect("localhost","root","","pulilan");
    

     $spec_memo = mysqli_query($con, "SELECT * from memo where memo_id = '$view_memo'"); 
     $sm = mysqli_fetch_array($spec_memo);
?>
<h1>View Memo</h1>
<!-- <input type="text" value="<?php echo $sm['project_name']; ?>" disabled>
<label>*Receiver</label>
<input type="text" value="<?php echo $sm['receiver']; ?>" disabled>
<label>*Project Description</label><br> -->
<div class="composed">
    <p><b>Subject:</b> <?php echo $sm['project_name']; ?></p>
    <p><b>Date:</b> <?php echo $sm['memo_date']; ?></p>
    <p><b>Status:</b> <?php echo $sm['memo_status']; ?></p>
    <p><b>Message:</b> <?php echo $sm['project_description']; ?></p>
    <p><b>Receiver:</b> <?php echo $sm['receiver']; ?></p>
</div>

<?php
    $attachment = $sm['picture'] ?? '';
    if (!empty($attachment)) {
        $file_path = 'achievment/temp/' . htmlspecialchars($attachment);
        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_extension, $image_extensions)) {
            echo '<img id="attachment-viewer" src="' . $file_path . '" alt="Memo Attachment">';
        } elseif ($file_extension === 'pdf') {
            echo '<embed id="attachment-viewer" src="' . $file_path . '" type="application/pdf">';
        }
    }
?>
<?php
}
?>
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
