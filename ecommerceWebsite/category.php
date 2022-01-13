<?php 
session_start();
include('inc/header.php')
?>
<div class="container product-section">
	<div class="category">
		<h1 class="text-center text-danger mb-5 mt-5" style="font-family: 'Abril Fatface', cursive;">SHOP BY CATEGORIES</h1>
	</div>

	<div class="row">

	<?php
	require_once('inc/conn.php');

	$sql ="SELECT * FROM products";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if($stmt->rowCount() > 0){
		while($product = $stmt->fetch(PDO::FETCH_ASSOC)){
			?>	
		<div class="col-lg-3 col-md-3 col-sm-12">
			
			<form>
				<div class="card mb-5">
					<h6 class="card-title bg-info text-white p-2 text-uppercase"> <?php echo
					 $product['product_name'] ?> </h6>

					<div class="card-body">
						 <a href="product.php?product_id=<?=$product['product_id']?>"><img src="<?php echo
					 'image/'.$product['product_image'] ?>" alt="technology" class="img-fluid mb-3" style="height:150px; width:500px" ></a>

					 <span style="font-weight:bold;" class="<?php if($product['availability'] == 'in stock'){ echo 'in-stock';} else { echo 'out-stock';} ?>"><?php echo $product['availability']?></span>

					 <h6 style="padding-top:10px;"> &#8360; <?php echo $product['price'] ?> </h6>

				    </div>
				</div>
			</form>

		</div>
	<?php		
		}
	}
	?>
    </div>
</div>	
<script src="js/productBlog.js"></script>
<?php 
include('inc/footer.php');
?>
