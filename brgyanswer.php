<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

$connection = mysqli_connect("localhost", "root", "", "pulilan");
$user_id = $_GET['user_id'];
 if(isset($_SESSION['lol'])&&!empty($_SESSION['lol'])){
                    $lol = $_SESSION['lol'];
                }
                global $lol;


$getasnwer = mysqli_query($connection, "SELECT * FROM brgy_q where brgy_location =   '$lol' AND type = 'official' OR user_id = '".$_GET['user_id']."'");


while($row = mysqli_fetch_assoc($getasnwer)):

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Core CSS - Include with every page -->
    <link rel="stylesheet" type="text/css" href="css/style.default.css">
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />
    <!-- Page-Level CSS -->
    <link href="assets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <style>
input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
form#multiphase {
  border-radius: 5px;
  padding: 5%;
  background-color: rgba(76, 174, 76, 1);
  width: 70%;
  margin-left: 15%;
}
</style>
   </head>
<body>
<form method="POST">
    <div class="container">
<!--******************************Content*********************************-->

    <!--  page header -->
    <div class="row">
        <div class="col-lg-12">
                <h1 class="page-header">Barangay Profile Questionnaire</h1>
            </div>
        </div><!-- end  page header -->
        <div class="panel panel-primary col col-lg-12 col-md-12">
            <div class="panel-head" align="center">
                <h4><b>Initial Form</b></h4>
            </div>
            <div class="panel-body" align="center">
                <table>
                    <thead>
                        <tr class="table-condensed">
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Brgy. Classification</th>
                            <th>Barangay Location</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="name" value="<?php echo $row['name'];?>" readonly></td>
                            <td><input type="text" name="position" value="<?php echo $row['position'];?>" readonly></td>
                            <td><input type="text" name="brgy_classification" value="<?php echo $row['brgy_classification'];?>" readonly></td>
                            <td><input type="text" name="brgy_location" value="<?php echo $row['brgy_location'];?>" readonly></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="table-condensed">
                            <th>Characteristic of Barangay</th>
                            <th>Total Land Area</th>
                            <th>Major Sources of Livelihood</th>
                            <th>Boundaries (north, west, east, south)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="char_brgy" value="<?php echo $row['char_brgy'];?>" readonly></td>
                            <td><input type="text" name="total_land_area" value="<?php echo $row['total_land_area'];?>" readonly></td>
                            <td><input type="text" name="major_sources" value="<?php echo $row['major_sources'];?>" readonly></td>
                            <td><input type="text" name="boundaries" value="<?php echo $row['boundaries'];?>" readonly></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel-head" align="center">
                <h4><b>Demographic Reference</b></h4>
            </div>
            <div class="panel-body" align="center">
                <table>
                    <thead>
                        <tr class="table-condensed">
                            <th>Number of Household</th>
                            <th>Number of Families</th>
                            <th>Total Number of Male Voter's</th>
                            <th>Total Number of Female Voter's</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="no_household" value="<?php echo $row['no_household'];?>" readonly></td>
                            <td><input type="text" name="no_families" value="<?php echo $row['no_families'];?>" readonly></td>
                            <td><input type="text" name="total_male_voters" value="<?php echo $row['total_male_voters'];?>" readonly></td>
                            <td><input type="text" name="total_female_voters" value="<?php echo $row['total_female_voters'];?>" readonly></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="table-condensed">
                            <th>Number of Male Tanod</th>
                            <th>Number of Female Tanod</th>
                            <th>Number of Male Health Worker</th>
                            <th>Number of Female Health Worker</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="male_tanod" value="<?php echo $row['male_tanod'];?>" readonly></td>
                            <td><input type="text" name="female_tanod" value="<?php echo $row['female_tanod'];?>" readonly></td>
                            <td><input type="text" name="male_health_worker" value="<?php echo $row['male_health_worker'];?>" readonly></td>
                            <td><input type="text" name="female_health_worker" value="<?php echo $row['female_health_worker'];?>" readonly></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="table-condensed">
                            <th>Number of Male Scholar</th>
                            <th>Number of Female Scholar</th>
                            <th>Number of Male Health Purok Leaders</th>
                            <th>Number of Female Health Purok Leaders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="male_nutrition_scholar" value="<?php echo $row['male_nutrition_scholar'];?>" readonly></td>
                            <td><input type="text" name="female_nutrition_scholar" value="<?php echo $row['female_nutrition_scholar'];?>" readonly></td>
                            <td><input type="text" name="male_purok_leaders" value="<?php echo $row['male_purok_leaders'];?>" readonly></td>
                            <td><input type="text" name="female_purok_leaders" value="<?php echo $row['female_purok_leaders'];?>" readonly></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="table-condensed">
                            <th>Number of Male Librarian</th>
                            <th>Number of Female Librarian</th>
                            <th>Number of Male Day Care Worker</th>
                            <th>Number of Female Day Care Worker</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="male_librarian" value="<?php echo $row['male_librarian'];?>" readonly></td>
                            <td><input type="text" name="female_librarian" value="<?php echo $row['female_librarian'];?>" readonly></td>
                            <td><input type="text" name="male_day_care_worker" value="<?php echo $row['male_day_care_worker'];?>" readonly></td>
                            <td><input type="text" name="female_day_care_worker" value="<?php echo $row['female_day_care_worker'];?>" readonly></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="table-condensed">
                            <th>Number of Male Utility Worker</th>
                            <th>Number of Female Utility Worker</th>
                            <th>Number of Purok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="male_utility_worker" value="<?php echo $row['male_utility_worker'];?>" readonly></td>
                            <td><input type="text" name="female_utility_worker" value="<?php echo $row['female_utility_worker'];?>" readonly></td>
                            <td><input type="text" name="no_purok" value="<?php echo $row['no_purok'];?>" readonly></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <div align="center">
                  <legend><h4>List of Available Facility</h4></legend>
                  
                  <div class="col col-lg-6 col-md-6" align="center">
                    <p><b>Health Facility</b></p>
                    <table class="table-bordered">
                      <thead>
                        <tr>
                          <th>Barangay Health Center</th>
                          <th>Hospitals</th>
                          <th>Maternity Clinic</th>
                          <th>Child Clinic</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <tr>
                          <td><input type="checkbox" name="brgy_health_center" value="<?php echo $row['brgy_health_center'];?>" readonly ></td>
                          <td><input type="checkbox" name="hospital" value="<?php echo $row['hospital'];?>" readonly ></td>
                          <td><input type="checkbox" name="maternity_clinic" value="<?php echo $row['maternity_clinic'];?>" readonly ></td>
                          <td><input type="checkbox" name="child_clinic" value="<?php echo $row['child_clinic'];?>" readonly ></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="col col-lg-6 col-md-6" align="center">
                    <p><b>Educational & Health Facility</b></p>
                    <table class="table-bordered">
                      <thead>
                        <tr>
                          <th>Botika ng Barangay</th>
                          <th>Day Care Centers</th>
                          <th>Preschool</th>
                          <th>Elementary</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <tr>
                          <td><input type="checkbox" name="botika_brgy" value="<?php echo $row['botika_brgy'];?>" ></td>
                          <td><input type="checkbox" name="brgy_day_care_center" value="<?php echo $row['brgy_day_care_center'];?>" ></td>
                          <td><input type="checkbox" name="preschool" value="<?php echo $row['preschool'];?>" ></td>
                          <td><input type="checkbox" name="elementary" value="<?php echo $row['elementary'];?>" ></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="col col-lg-6 col-md-6" align="center">
                    <p><b>Educational & Service Facility</b></p>
                    <table class="table-bordered">
                      <thead>
                        <tr>
                          <th>Secondary</th>
                          <th>Vocational</th>
                          <th>College/University</th>
                          <th>Post Office</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <tr>
                          <td><input type="checkbox" name="secondary" value="<?php echo $row['secondary'];?>" ></td>
                          <td><input type="checkbox" name="vocational" value="<?php echo $row[' vocational'];?>" ></td>
                          <td><input type="checkbox" name="college_university" value="<?php echo $row['college_university'];?>" ></td>
                          <td><input type="checkbox" name="post_office" value="<?php echo $row['post_office'];?>" ></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="col col-lg-6 col-md-6" align="center">
                    <p><b>Service & Agricultural Facility</b></p>
                    <table class="table-bordered">
                      <thead>
                        <tr>
                          <th>Market</th>
                          <th>Rice Mill</th>
                          <th>Corn Mill</th>
                          <th>Feed Mill</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <tr>
                          <td><input type="checkbox" name="market" value="<?php echo $row['market'];?>" ></td>
                          <td><input type="checkbox" name="ricemill" value="<?php echo $row['ricemill'];?>" ></td>
                          <td><input type="checkbox" name="cornmill" value="<?php echo $row['cornmill'];?>" ></td>
                          <td><input type="checkbox" name="feedmill" value="<?php echo $row['feedmill'];?>" ></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="col col-lg-12 col-md-12" align="center">
                    <p><b>Service & Agricultural Facility</b></p>
                    <table class="table-bordered">
                      <thead>
                        <tr>
                          <th>Agricultural Produce Market</th>
                          <th>Fertilizer Dealer</th>
                          <th>Pesticide Dealer</th>
                          <th>Seeds Dealer</th>
                          <th>Feeds Dealer</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <tr>
                          <td><input type="checkbox" name="agricultural_market" value="<?php echo $row['agricultural_market'];?>" ></td>
                          <td><input type="checkbox" name="fertilizer" value="<?php echo $row['fertilizer'];?>" ></td>
                          <td><input type="checkbox" name="pesticide" value="<?php echo $row['pesticide'];?>" ></td>
                          <td><input type="checkbox" name="seeds" value="<?php echo $row['seeds'];?>" ></td>
                          <td><input type="checkbox" name="feeds" value="<?php echo $row['feeds'];?>" ></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

           
        </div>

</form>
<?php endwhile; ?>










    <footer>
        <div class="text-center" style="position: fixed; right: 10px; bottom: 10px; width:50px; background-color: green; border-radius: 100%; padding: 15px; margin-top: 5px;">
            <a href="#" style="color: white;" class="go-top">
                <i class="fa fa-eject"></i>
            </a>
        </div>
    </footer>

</div>

    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <!-- Page-Plot Scripts-->
    <script src="assets/plugins/flot/jquery.flot.js"></script>
    <script src="assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="assets/plugins/flot/jquery.flot.pie.js"></script>
    <script src="assets/scripts/flot-demo.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/plugins/morris/morris.js"></script>
    <script src="assets/scripts/dashboard-demo.js"></script>
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