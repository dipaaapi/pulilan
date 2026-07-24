<?php
include __DIR__ . '/navbar.php';
error_reporting(0); // Suppress notices for this legacy page
?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center mt-3 mb-3 border-bottom pb-2">
            <h2 class="text-secondary mb-0">
                <i class="fa fa-map-marker me-2"></i> Barangay Monitoring Report
            </h2>
            <button class="btn btn-sm btn-outline-secondary" id="printpagebutton" onclick="printpage()">
                <i class="fa fa-print me-1"></i> Print this page
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" id="filterForm">
                <div class="col-md-3"><label for="from_date" class="form-label">From Date</label><input type="date" name="from_date" id="from_date" class="form-control"></div>
                <div class="col-md-3"><label for="to_date" class="form-label">To Date</label><input type="date" name="to_date" id="to_date" class="form-control"></div>
                <div class="col-md-3"><button type="button" name="filter" id="filter" class="btn btn-primary w-100"><i class="fa fa-filter me-2"></i>Filter</button></div>
            </form>
        </div>
    </div>

<script> // Print
function printpage() {

    //Get the print button and put it into a variable
    var printButton = document.getElementById("printpagebutton");
    var filter = document.getElementById("filter");
  
    document.getElementById('filterForm').style.visibility = 'hidden';

    //Set the button visibility to 'hidden' 
    printButton.style.visibility = 'hidden';
     filter.style.visibility = 'hidden';
   
    //Print the page content
    window.print()

    //Restore button visibility
    printButton.style.visibility = 'visible';
    document.getElementById('filterForm').style.visibility = 'visible';
}

</script>

    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="card-title mb-0">Report Results</h5>
        </div>
        <div class="card-body" id="brgy_table">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                          <tr>  
                               <th>ID</th>  
                               <th>Fullname</th>
                               <th>Barangay Location</th>  
                               <th>Date</th>  
                          </tr>
                    </thead>
                    <tbody>
                     <?php  
                     $query = "SELECT * FROM mainuser_acc WHERE type IN ('brgy_official','executive','dilg') ORDER BY user_id ASC";
                     $result = mysqli_query($connection, $query);
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
</div>
<?php include __DIR__ . '/footer.php'; ?>