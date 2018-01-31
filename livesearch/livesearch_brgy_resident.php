g<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "pulilan");


if(isset($_GET['r'])){
	$r = $_GET['r'];
	global $r;
  if(isset($_SESSION['lol'])&&!empty($_SESSION['lol'])){
                    $lol = $_SESSION['lol'];
                }
global $lol;
	if($r == ""){

$sql = mysqli_query($con, "SELECT * from mainuser_acc where brgy_location = '$lol' && type = 'resident' && visibility = '0' && name like '%$r%' limit 0, 10");

                while($result = mysqli_fetch_array($sql))

         { 

             ?>
             <tr>
              <td style="color: red;"><?php echo $result['user_id'];?></td>
              <td><?php echo $result['brgy_location'];?></td>
              <td><?php echo $result['name'];?></td>
              <td><?php echo $result['gender'];?></td>
              <td><?php echo $result['username'];?></td>
              <td><?php echo $result['type'];?></td>
              <td>
                <a class="btn btn-outline btn-info fa fa-pencil-square-o" href="updateresidentregistration.php?user_id=<?php echo $result['user_id'];?>" <?php
                if($result['edit_status'] == "disabled" || $result['edit_status'] == "request"){
                    ?>
                    disabled
                    <?php
                }
                ?>></a>
              </td>

              <td>
               <a type="button" href="delete_resacc.php?user_id=<?php echo $result['user_id']; ?>" class="btn btn-outline btn-danger fa fa-times"   <?php if($result['edit_status'] == "disabled" || $result['edit_status'] == "request"){
                    ?>
                    disabled
                    <?php
                }
                ?>></a>
             </td>
             <td><a class="btn btn-outline btn-info fa fa-pencil-square-o" href="brgy_resident_account_table.php?rui=<?php echo $result['user_id']; ?>">Request Update</a></td>
            </tr>
        <?php
}


	}
	else{
	
					$sql = mysqli_query($con, "SELECT * from mainuser_acc where brgy_location = '$lol' && type = 'resident' && visibility = '0' && name like '%$r%'");

                while($result = mysqli_fetch_array($sql))

         { 

             ?>
             <tr>
              <td style="color: red;"><?php echo $result['user_id'];?></td>
              <td><?php echo $result['brgy_location'];?></td>
              <td><?php echo $result['name'];?></td>
              <td><?php echo $result['gender'];?></td>
              <td><?php echo $result['username'];?></td>
              <td><?php echo $result['type'];?></td>
              <td>
                <a class="btn btn-outline btn-info fa fa-pencil-square-o" href="updateresidentregistration.php?user_id=<?php echo $result['user_id'];?>" <?php
                if($result['edit_status'] == "disabled" || $result['edit_status'] == "request"){
                    ?>
                    disabled
                    <?php
                }
                ?>></a>
              </td>

              <td>
               <a type="button" href="delete_resacc.php?user_id=<?php echo $result['user_id']; ?>" class="btn btn-outline btn-danger fa fa-times"   <?php if($result['edit_status'] == "disabled" || $result['edit_status'] == "request"){
                    ?>
                    disabled
                    <?php
                }
                ?>></a>
             </td>
             <td><a class="btn btn-outline btn-info fa fa-pencil-square-o" href="brgy_resident_account_table.php?rui=<?php echo $result['user_id']; ?>">Request Update</a></td>
            </tr>
        <?php
}
	}
}


?>