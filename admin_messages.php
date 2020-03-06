<?php include('../pulilan/adminnav.php'); ?>

	<?php
	    $get_notif2 = mysqli_query($con, "SELECT * from message_tbl where brgy_location = 'Admin' && notification_status = 'UNSEEN'");{
	    	while($d = mysqli_fetch_array($get_notif2)){
                	$snd = $d['brgy_location'];
                	$sbj = $d['subject'];
                	$date = $d['date_created'];
                	$msg = $d['message'];
		            
                }
	    }
?>

	<script>
		const elem = $("p");
		const dlt = document.getElementByName("delete");
		if (dlt == clicked) {
			erase.elem;
		} else {
			print.
		}

	</script>

	<h1>Admin Messages</h1>
	<div class="panel panel-heading">
		<table class="table">
			<thead class="label-info">
				<tr>
					<td><p>Sender</p></td>
					<td><p>Subject</p></td>
					<td><p>Date Created</p></td>
					<td><p>Messages</p></td>
					<td><p>Action</p></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><p><?php echo $snd ?></p></td>
					<td><p><?php echo $sbj ?></p></td>
					<td><p><?php echo $date ?></p></td>
					<td><p><?php echo $msg ?></p></td>
					<td><p><button name="delete" class="btn btn-danger" onclick="">DELETE</button></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php include('../pulilan/adminfooter.php'); ?>