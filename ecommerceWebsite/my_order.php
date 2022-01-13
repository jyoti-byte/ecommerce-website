<?php 
session_start();
require('inc/conn.php');
require('inc/header.php');
if(!isset($_SESSION['user_login'])){
	?>
	<script>
	window.location.href='login.php';
	</script>
	<?php
}
?>
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="table table-responsive table-striped">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Order ID</th>
                                                <th class="product-name"><span class="nobr">Order Date</span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> Address </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> Payment Method </span></th>
												<th class="product-stock-stauts"><span class="nobr"> Order Status </span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$uid=$_SESSION['user_id'];
											$stmt=$conn->prepare("SELECT orders.*,order_status.name, order_address.shipping_address from orders,order_status,order_address where orders.user_id=':uid' and order_status.id=orders.status and orders.order_id=order_address.order_id");
                                            $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
                                            $stmt->execute();
											while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
											?>
                                            <tr>
												<td class="product-add-to-cart"><a href="order_details_admin.php?id=<?php echo $row['order_id']?>"> <?php echo $row['order_id']?></a></td>
                                                <td class="product-name"><?php echo $row['order_date']?></td>
												<td class="product-name"><?php echo $row['shipping_address']?></td>
                                                <td class="product-name"><?php echo $row['payment_method']?></td>
                                                <td class="product-name"><?php echo $row['status']?></td>
                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        						
<?php require('inc/footer.php')?>        