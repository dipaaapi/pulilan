<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('pulilan_db_connect.php');
?>

<?php include('../pulilan/brgynav.php'); ?>

           <title>Community Based Barangay Answer</title>
            <div class="row">
                 <!--  page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Barangay & Executive Officials</h1>
                </div>
                 <!-- end  page header -->
                  <script> 
    function printpage() {

    //Get the print button and put it into a variable
    var printButton = document.getElementById("printpagebutton");
    var searchButton = document.getElementById("search");
    // var submitButton = document.getElementById("submit");
    var displayButton = document.getElementById("display");
     var form1 = document.getElementById("form1");
      var form2 = document.getElementById("form2");
    //Set the button visibility to 'hidden' 

    printButton.style.visibility = 'hidden';
    searchButton.style.visibility = 'hidden';
    // submitButton.style.visibility = 'hidden';
    displayButton.style.visibility = 'hidden';
    form1.style.visibility = 'hidden';
    form2.style.visibility = 'hidden';
    //Print the page content
    window.print()

    //Restore button visibility
    printButton.style.visibility = 'visible';
    searchButton.style.visibility = 'visible';
    // submitButton.style.visibility = 'visible';
    displayButton.style.visibility = 'visible';
    form1.style.visibility = 'visible';
    form2.style.visibility = 'visible';
  

}
  </script>
            </div>

<div class="panel panel-heading">

  <table class="table table-responsive table-hover">
    <thead>
        <tr class="table-bordered">  
            <th>Full Name</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Barangay Location</th>
            <th class="warning">View Resident Answer</th>
            
        </tr>
    </thead>
            
            <?php 
             if(isset($_SESSION['lol'])&&!empty($_SESSION['lol'])){
                    $lol = $_SESSION['lol'];
                }
                global $lol;

             $results = mysqli_query($connection, "SELECT * FROM resident_q where brgy_location = 'Dampol 1st'");
                while ($row = mysqli_fetch_assoc($results)):
            ?>
        <tr>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['contact'] ?></td>
            <td><?php echo $row['brgy_location'] ?></td>
           
            <td>
                <a href="viewresidentanswer.php?question_id=<?php echo $row['question_id'];?>" class="btn btn-outline btn-info fa fa-profile">  View Resident Answer</a>
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