<?php 
if(isset($_SESSION['admin_login']) && $_SESSION['admin_login']!=''){

}else{
	header('location:adminlogin.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>ecommerce website</title>

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
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
          <div class="top-right">
              <div class="header-menu">
                  <div class="user-area dropdown float-right pr-4">
                     <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome Admin</a>
                     <div class="">
                        <a class="nav-link" href="adminlogout.php"><i class="fa fa-power-off"></i>Logout</a>
                     </div>
                  </div>
              </div>
          </div>
        </header>