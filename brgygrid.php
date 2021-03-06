<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('pulilan_db_connect.php');
?>
<link rel="stylesheet" href="js/brgygrid.js">
<?php include('../pulilan/adminnav.php'); ?>

<h1>Barangay & Executive Officials</h1>
<div class="panel panel-heading">

  <table class="table table-responsive table-hover">
    <thead>
        <tr class="table-bordered">  
            <th>Full Name</th>
            <th>Position</th>
            <th>Brgy. Location</th>
            <th class="warning">View</th>
            <th class="info">Update </th>
        </tr>
    </thead>
            
            <?php  $results = mysqli_query($connection, "SELECT * FROM mainuser_acc where position = 'Chairman' OR position = 'DILG' OR position = 'executive'");
                while ($row = mysqli_fetch_assoc($results)):
            ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['position']; ?></td>
            <td><?php echo $row['brgy_location'] ?></td>
           
            <td>
                <a href="viewofficial.php?user_id=<?php echo $row['user_id'];?>" class="btn btn-outline btn-info fa fa-profile"> View Official</a>
            </td>
            <td>
                <a href="updatebrgygrid.php?user_id=<?php echo $row['user_id'];?>" class="btn btn-outline btn-info fa fa-pencil"> Update</a>
            </td>
         
        </tr>


<?php endwhile; ?>

          

 </table>

 <script>


$("table").DataTable();

$('.dataTables_filter').addClass('pull-right');


</script>

</div>

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
<?php include('../pulilan/adminfooter.php'); ?>