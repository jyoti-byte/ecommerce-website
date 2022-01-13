<?php
require_once "conn.php";

$id = $_GET["product_id"];
$query = mysqli_query($conn, "SELECT * FROM products WHERE product_id = '$id'");

if ($r_data = mysqli_fetch_assoc($query)) {
	$pName   = $r_data["product_name"];
	$pPrice    = $r_data["price"];
	$pImage       = $r_data["product_image"];
	$pAvailability = $r_data["availability"];
} else {
	header("location: category.php");
	exit();
}
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Product Page</title>
</head>
<body>
	<div class="single-product-block">
		<div class="container">
			<div class="row">
				<div class="col-7">
					<div class="single-product-image">
						<img src="image/<?php echo $pImage ?>">
					</div>
				</div>
				<div class="col-5">
					<div class="single-product-info">
						<h2><?php echo $pName ?></h2>
						<div class="stock-number">
							<p class="availability">Availability: <span class='<?php if($pAvailability == 'in stock'){ echo 'in-availability'; } else { echo 'out-availability';} ?>'><?php echo $pAvailability ?></span></p>
							<h3>Rs. <?php echo $pPrice ?></h3>
						</div>
						<?php if($pAvailability == 'in stock'){ ?>
							<div class="product-action">
								<div class="form-group">
									<input class="form-control product-quantity" type="number" placeholder="1">
								</div>
								<button class="btn btn-sm btn-primary add-to-cart">Add to Cart</button>
								</div> <?php } ?>
							</div>

						</div>
					</div>
				</div>
			</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script type="text/javascript">
			$('.add-to-cart').click(function(){
			let productId = <?php echo $id ?>;
			let productQty;
			
			productQty = $('.product-quantity').val();
			console.log(productQty);
			
			var cartItems = [{
				'id' : productId,
				'quantity' : productQty
			}]

			var data = JSON.stringify(cartItems);

			document.cookie = "cartItems="+data+"; expires=Thu, 20 Dec 2021 02:00:00 UTC; path=/";
		});
		</script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	</body>
	</html>