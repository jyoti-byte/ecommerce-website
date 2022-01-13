<?php 
require('inc/conn.php');

if(isset($_POST['register'])){
    $username  = $_POST['name'];
    $email     = $_POST['email'];
    $mobileNumber = $_POST['mobile'];
    $password   = $_POST['password'];

    $stmt=$conn->prepare("SELECT * FROM `users` WHERE email=':email'");
    $check_user=$stmt->rowCount();

    if($check_user > 0){
        echo "Email already exists";
    }
    else {
        $stmt=$conn->prepare("INSERT INTO `users`(`name`, `email`, `mobileNumber`, `password`) VALUES (:username, :email, :mobile, :password)");
    }

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobile', $mobileNumber);
    $stmt->bindParam(':password', $password);
   

    if( $stmt->execute()){
        echo "<script>alert('Record inserted successfully');</script>";
        echo "<script>window.location.href='login.php'</script>";
     }
     else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
        echo "<script>window.location.href='login.php'</script>";
     }

}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt=$conn->prepare("SELECT * FROM `users` WHERE email=':email' and password=':password'");
    $stmt->execute();
    $check_user=$stmt->rowCount();

    if($check_user > 0){
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);
        die;
        $_SESSION['user_login']='yes';
	    $_SESSION['user_email']=$row['email'];
	    $_SESSION['user_password']=$row['password'];
        echo "valid";
    }
    else{
        echo "wrong input";
        }
    ?>
	<!-- <script>
		window.location.href='checkout.php';
	</script> -->
	<?php
}
?>
<?php 
include('inc/header.php');
?>
        <section class="bg-white">
            <div class="container mt-5">
                <div class="row">
					<div class="col-md-6">
						<div class="login-form-wrap">
							<div class="col-xs-12 mb-3">
								<div class="login-title">
									<h2 class="title-line">Login</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="login-form" action="" method="post">
                                    <div class="form-group">
                                        <label for="username"> Username </label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter email or username" required>
                                    </div>
                                    <span class="field_error" id="login_email_error"></span>
                                    <div class="form-group">
                                        <label for="password"> Password </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                    </div>
                                    <span class="field_error" id="login_password_error"></span>                                    
									<div class="login-btn">
										<button type="submit" name="login" class="btn btn-primary" onclick="user_login()">Login</button>
									</div>
								</form>
								<div class="form-output login_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>
						</div> 
                
				</div>
				

					<div class="col-md-6">
						<div class="register-form-wrap">
							<div class="col-xs-12">
								<div class="register-title mb-3">
									<h2 class="title-line">Register</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="register-form" action="" method="post">
                                    <div class="form-group">
                                        <label for="username"> Full Name </label>
                                        <input type="name" class="form-control" id="name" name="name" placeholder="Enter your full name " required>
                                        <span class="field_error" id="name_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"> Email Address </label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email " required>
                                        <span class="field_error" id="email_error"></span>
                                    </div>
									<div class="form-group">
                                        <label for="mobile"> Mobile Number </label>
                                        <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile number " required>
                                        <span class="field_error" id="mobile_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"> Password </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                        <span class="field_error" id="password_error"></span>
                                    </div>
									
									<div class="register-btn">
										<button type="submit" name="register" class="btn btn-primary" onclick="user_register()">Register</button>
									</div>
								</form>
								<div class="form-output register_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>
						</div> 
    				</div>
					
            </div>
        </section>
        <!-- <script src="functions.js"></script> -->
<?php require('inc/footer.php')?>        