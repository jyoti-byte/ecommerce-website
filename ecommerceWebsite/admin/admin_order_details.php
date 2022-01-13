<?php 
session_start();
require("inc/conn.php");
try{
    $conn->beginTransaction();
    $stmt=$conn->prepare("SELECT * FROM orders INNER JOIN order_address ON orders.order_id=order_address.order_id 
        INNER JOIN order_product ON order_address.order_id=order_product.order_id");
    $stmt->execute();
    $conn->commit();
    // echo "<script>alert('Report generated successfully');</script>";
}
catch(PDOException $e) {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

if(isset($_POST['update_order_status'])){
	$update_order_status=$_POST['update_order_status'];

    $stmt1=$conn->prepare("UPDATE orders set status='$update_order_status' where order_id=orders.order_id");
    $stmt1->execute();
	
}

?>

<?php 
include('inc/header1.php');
?>
    <div class="container mt-4">
        <div class="col-md-6">
        <a href="dashboard.php" class="btn btn-success mb-3"> Back </a>
        </div>
        <form action="" method="POST" >
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                <strong><i class="fa fa-database"></i> Orders Report</strong>
                </div>
                <table class="table table-bordered table-responsive text-center">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th class="col-2">Order Date</th>
                            <th>Product ID</th>
                            <th>Product Quantity</th>
                            <th class="col-2">Product Price</th>
                            <th>Shipping Address</th>
                            <th class="col-1">Billing Address</th>
                            <th>Payment Method</th>
                            <th class="col-2">Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($stmt->rowCount() > 0) : ?>
                        <?php foreach ($stmt as $product) : ?>
                        <tr>
                            <td><?php echo $product['order_id'] ?></td>
                            <td><?php echo $product['user_id'] ?></td>
                            <td><?php echo $product['order_date'] ?></td>
                            <td><?php echo $product['product_id'] ?></td>
                            <td><?php echo $product['quantity'] ?></td>
                            <td>&#8360; <?php echo $product['product_price'] ?></td>
                            <td><?php echo $product['shipping_address'] ?></td>
                            <td><?php echo $product['billing_address'] ?></td>
                            <td><?php echo $product['payment_method'] ?></td>
                            <td>&#8360; <?php echo $product['total_order_amount'] ?></td>
                            <td><?php echo $product['status'] ?></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                    </tbody>
                </table>
                <div>
                    <strong>Order Status</strong>
                    <?php 
                    $stmt=$conn->prepare("SELECT order_status.name, orders.order_id FROM order_status, orders where orders.order_id=order_id and orders.status=order_status.id");
                    $stmt->execute();
                    $res=$stmt->fetch(PDO::FETCH_ASSOC);
                    echo $res['name'];
                    ?>

                    <div>
                        <form method="post">
                            <select class="form-control" name="update_order_status" required>
									<option value="">Select Status</option>
									<?php
									$res=$conn->prepare("SELECT * FROM order_status");
                                    $res->execute();
									while($row=$res->fetch(PDO::FETCH_ASSOC)){
										if($row['id']==$status){
											echo "<option selected value=".$row['id'].">".$row['name']."</option>";
										}else{
											echo "<option value=".$row['id'].">".$row['name']."</option>";
										}
										}
									?>
							</select>
							<input type="submit" class="form-control"/>
                        </form>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div>
       
<?php 
include('inc/footer.php');
?>
