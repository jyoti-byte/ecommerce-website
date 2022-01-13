<?php
require('inc/conn.php');
$message = '';

if(isset($_POST["add_to_cart"]))
{
 if(isset($_COOKIE["shopping_cart"]))
 {
  $cookie_data = stripslashes($_COOKIE['shopping_cart']);

  $cart_data = json_decode($cookie_data, true);
 }
 else
 {
  $cart_data = array();
 }
  $item_id_list = array_column($cart_data, 'item_id');

  if(in_array($_POST["hidden_id"], $item_id_list))
 {
  foreach($cart_data as $keys => $values)
  {
   if($cart_data[$keys]["item_id"] == $_POST["hidden_id"])
   {
    $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["qty"];
   }
  }
 }
 else{
	$item_array = array(
		'item_id'      => $_POST["hidden_id"],
		'item_name'    => $_POST["hidden_name"],
		'item_price'   => $_POST["hidden_price"],
		'item_quantity'=> $_POST["qty"]
	   );
	  $cart_data[] = $item_array;
 }
  
 $item_data = json_encode($cart_data);
 setcookie('shopping_cart', $item_data, time() + (86400 * 30));
 header("location:cart.php?success=1");

}
?>

<?php 
include('inc/header.php');
?>
<div class="container">
	<h1 class="text-center text-danger mb-5" style="margin-top:20px;">PRODUCT</h1>
	<div class="col-md-6">
		<a href="category.php" class="btn btn-dark mb-3 mr-1 ml-4"><< Go to Category</a><a href="cart.php" class="btn btn-dark mb-3"><i class="fa fa-shopping-cart pr-2" aria-hidden="true"></i>Go to Cart >></a>
    </div>

	<?php

	require('inc/conn.php');

	$id = ''; 
	if( isset( $_GET['product_id'])) {
		$id = $_GET['product_id']; 
	}
	$sql = "SELECT * FROM products where product_id=:pid";
	
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':pid', $id, PDO::PARAM_INT);
	$stmt->execute();

	if($product = $stmt->fetch(PDO::FETCH_ASSOC)){
		$pName   		= $product["product_name"];
		$pPrice   		= $product["price"];
		$pImage       	= $product["product_image"];
		$pAvailability 	= $product["availability"];
	}else {
		header('location:category.php');
		die;
	}
	
	// if($stmt->rowCount() > 0){
	// 	while($product = $stmt->fetch(PDO::FETCH_ASSOC)){
	?>	
			<form action="" method="post" enctype="multipart/form-data">
						<div class="row product-block">
							<div class="single-image col-6">
								<img src="image/<?php echo $pImage ?>" alt="technology" class="img-fluid mt-5 pr-5">
							</div>
							<div class="col-4">
								<div class="product-info mt-5">
									<h5 class="card-title bg-info text-white p-2 text-uppercase"> <?php echo
											$pName ?> </h5>
									<span style="font-weight:bold;" class="<?php if($pAvailability == 'in stock'){ echo 'in-stock'; } else { echo 'out-of-stock';} ?>"><?php echo $pAvailability?></span>

									<h6 style="padding-top:10px;"> &#8360; <?php echo $pPrice ?></h6>
									 <!-- if($pAvailability == 'in stock'){  -->
									<div class="form-group">
										<label>Quantity</label>
										<input type="text" name="qty" value="1" class="form-control mb-4" placeholder="Quantity">
									</div>
									<div class="btn-group d-flex">
									<button class="btn btn-success flex-fill text-white" name="add_to_cart"> Add to cart </button>
									<!-- <button class="btn btn-warning flex-fill text-white ml-1"><a href="checkout.php"> Buy now </button></a> -->
									<a href="checkout.php" class="btn btn-warning text-white">Buy Now</a>
						    		</div>
									<input type="hidden" name="hidden_name" value="<?php echo $pName; ?>">
									<input type="hidden" name="hidden_price" value="<?php echo $pPrice; ?>">
									<input type="hidden" name="hidden_id" value="<?php echo $id; ?>">
									
					    		
								</div>
								
							</div>		
						</div>
			</form>
</div>
<script src="js/productBlog.js"></script>
<script type="text/javascript">
				gtag('event', 'view_item', {
				  "items": [
				    {
				      "id": "<?php echo $_GET['product_id']; ?>",
				      "name": "<?php echo $pName ?>",
				      "quantity": 2,
				      "price": "<?php echo $pPrice ?>"
				    }
				  ]
				});
			</script>
<?php 
include('inc/footer.php');
?>