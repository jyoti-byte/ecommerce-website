<!DOCTYPE html>
<html>
<head>
	<title>ecommerce website</title>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Dancing+Script" rel="stylesheet">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="css/style1.css">
	  <link rel="stylesheet" type="text/css" href="css/style2.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-216917390-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-216917390-1');
		</script>

</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="#">NP</a>

			<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="category.php">Categories</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link" href="#">About</a>
					</li> -->
					<!-- <li class="nav-item">
						<a class="nav-link" href="#">Contact</a>
					</li> -->
					<li class="nav-item">
					<?php if(isset($_SESSION['user_login']) == "yes"){
						echo '<a class="nav-link" href="logout.php">Logout</a> <a class="nav-link" href="my_order.php">My Order</a>';
					}else{
						echo '<a class="nav-link" href="login.php">Login</a>';
					}?>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="registration.php">Register</a>
					</li>
				</ul>
				<form class="form-inline">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					<a class="nav-link text-light m1-5" href="cart.php"><i class="fa fa-shopping-cart fa-2x"></i><span class="badge badge-light"><?php echo (isset($_COOKIE['shopping_cart']) && count(json_decode($_COOKIE['shopping_cart']))>0) ?count(json_decode($_COOKIE['shopping_cart'])):'';
					?></span></a>
				</form>
			</div>
		</div>
	</nav>

	<div class="hero-image">
        <div class="hero-text">
            <h1 class="text-light">A New Online Shop Experience</h1>
            <h4>Genuine and Trustworthy</h4>
            <button class="btn btn-info btn-lg mt-4">Shop Now</button>
        </div>
    </div>
