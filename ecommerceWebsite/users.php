<?php
require('inc/conn.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=$_GET['type'];
	if($type=='delete'){
		$id=$_GET['id'];
		$delete_sql="delete from users where id='$id'";
		$stmt=$conn->$delete_sql;
	}
}

$sql="select * from users order by id desc";
$stmt=$conn->prepare($sql);
$stmt->execute();
?>
<?php require("inc/header1.php");
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Users </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th>ID</th>
							   <th>Name</th>
							   <th>Email</th>
							   <th>Mobile</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                ?>
							<tr>
							   <td class="serial"><?php echo $i?></td>
							   <td><?php echo $row['user_id']?></td>
							   <td><?php echo $row['username']?></td>
							   <td><?php echo $row['email']?></td>
							   <td><?php echo $row['mobileNumber']?></td>
							   <td>
								<?php
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['user_id']."'>Delete</a></span>";
								?>
							   </td>
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<?php
require('inc/footer.php');
?>