<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require('pulilan_db_connect.php');
?>
<style>
	#panel, #panel-body {
		padding: 0;
	}
	.title-panel {
		margin: 0;
	}
	thead tr th {
	    padding: 10px 0;
    	text-transform: uppercase;
    	color: white;
    	background-color: #008e00;
	}
	tbody tr td {
		padding: 10px 0;
	}
	.p-header {
		padding: 10px 0;
		width: 100%;
	}
</style>
<?php include('../pulilan/adminnav.php'); ?>

<!--******************************Content*********************************-->

	<div class="p-header">
	    <h1 class="page-header">Log History</h1>
	</div>

	<div id="panel" class="panel panel-default col col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="panel-body" id="panel-body">
			<table class="col col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<thead>
					<tr class="table-bordered">
						<th>ID</th>
						<th>Username</th>
						<th>Date & Time</th>
					</tr>
				</thead>
				<?php
                                    $show_record="SELECT * FROM loghistory";
                                    $show_record_query = mysqli_query($connection, $show_record);
                      
                                    if($show_record_query){
                                    while($result = mysqli_fetch_assoc($show_record_query))

                             { 

                                 ?>
				<tbody>
					<tr>
						<td style="color: red;"><?php echo $result['log_id'];?></td>
						<td><?php echo $result['username'];?></td>
						<td><?php echo $result['datetime'];?></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
				<?php
                                }
                                }
                                    ?>
			</table>
		</div>
	</div>

	

<!--****************************End Content*******************************-->

<?php include('../pulilan/adminfooter.php'); ?>