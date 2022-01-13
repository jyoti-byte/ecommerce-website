<?php 
session_start();
require('inc/conn.php');
require('inc/header1.php');

if(isset($_GET['order_id']) && $_GET['order_id'] != ''){
    $order_id=$_GET['order_id'];
}
?>
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Product Name</th>
												<th class="product-thumbnail">Product Image</th>
                                                <th class="product-name">Quantity</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-price">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$stmt=$conn->prepare("select orders.total_order_amount,products.product_name,products.product_image,order_product.quantity, order_product.product_price from orders, products, order_product where orders.order_id=:order_id and products.product_id=order_product.product_id");
                                            $stmt->execute();
											$total_price=0;
											while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
											$total_price=$total_price+($row['quantity']*$row['product_price']);
											?>
                                            <tr>
												<td class="product-name"><?php echo $row['product_name']?></td>
                                                <td class="product-name"> <img src="<?php echo '/image'.$row['product_image']?>"></td>
												<td class="product-name"><?php echo $row['quantity']?></td>
												<td class="product-name"><?php echo $row['product_price']?></td>
												<td class="product-name"><?php echo $row['quantity']*$row['product_price']?></td>
                                                
                                            </tr>
                                            <?php } ?>
											<tr>
												<td colspan="3"></td>
												<td class="product-name">Total Price</td>
												<td class="product-name"><?php echo $total_price?></td>
                                                
                                            </tr>
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