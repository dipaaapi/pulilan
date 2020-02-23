<?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "pulilan");
$query = "SELECT * FROM mainuser_acc where type IN ('brgy_official','executive','dilg') ORDER BY user_id ASC";
$result = mysqli_query($connection, $query);


?>
<style>
  .container {
    width: auto;
    padding: 0;
    margin: 0;
  }
  .prnt {
    background-color: #008e00;
    color: white;
    position: absolute;
    right: 0;
  }
  .page-wrapper {
    top: 25vh;
  }
</style>
<?php include('../pulilan/adminnav.php'); ?>
<script> // Print
function printpage() {

    //Get the print button and put it into a variable
    var printButton = document.getElementById("printpagebutton");
    var filter = document.getElementById("filter");
  

    //Set the button visibility to 'hidden' 
    printButton.style.visibility = 'hidden';
     filter.style.visibility = 'hidden';
   
    //Print the page content
    window.print()

    //Restore button visibility
    printButton.style.visibility = 'visible';
     filter.style.visibility = 'visible';
}

</script>
<script src="../js/jquery-ui.js"></script>  
<link rel="stylesheet" href="../css/jquery-ui.css">
   <div class="col-md-12">  
     <h1 class="page-header">Barangay Monitoring List Report</h1>
</div> 
  <form class="form-inline">
  <label>FROM</label>
     <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
  <label>TO</label>
   <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
    <label class="form-check-label">
        <input type="button" name="filter" id="filter" value="Filter" class="btn btn-default" />  
    </label>
   <div class="col-md-1 pull-right">  
     <a class="btn prnt" id="printpagebutton" onclick="printpage()">Print this page</a>
  </div> 
</form>
   
                <div id="brgy_table">  
               
                     <table class="table table-bordered">  
                          <tr>  
                               <th>ID</th>  
                               <th>Fullname</th>
                               <th>Barangay Location</th>  
                               <th>Date</th>  
                          </tr>  
                     <?php  
                     while($row = mysqli_fetch_array($result))  
                     {  
                     ?>  
                          <tr>  
                               <td><?php echo $row["user_id"]; ?></td>  
                               <td><?php echo $row["name"]; ?></td>  
                                <td><?php echo $row["brgy_location"]; ?></td> 
                                <td><?php echo $row["date"]; ?></td>   
                          </tr>  
                     <?php  
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
      $(document).ready(function(){  
           $.datepicker.setDefaults({  
                dateFormat: 'yy-mm-dd'   
           });  
           $(function(){  
                $("#from_date").datepicker();  
                $("#to_date").datepicker();  
           });  
           $('#filter').click(function(){  
                var from_date = $('#from_date').val();  
                var to_date = $('#to_date').val();  
                if(from_date != '' && to_date != '')  
                {  
                     $.ajax({  
                          url:"brgyfilter.php",  
                          method:"POST",  
                          data:{from_date:from_date, to_date:to_date},  
                          success:function(data)  
                          {  
                               $('#brgy_table').html(data);  
                          }  
                     });  
                }  
                else  
                {  
                     alert("Please Select Date");  
                }  
           });  
      });  
 </script>
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

</body>

</html>