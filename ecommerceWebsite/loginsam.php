<?php 
session_start(); 
include ('inc/conn.php');

if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['username']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		echo "Username is required";
	   
	}else if(empty($pass)){
        echo "Password is required";
	   
	}else{
		$sql = "SELECT * FROM users WHERE username='$uname' AND password='$pass'";

		$stmt=$conn->prepare($sql);
		$stmt->exec();

		if ($stmt->rowCount() === 1) {
			$row = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($row['username'] === $uname && $row['password'] === $pass) {
            	$_SESSION['username'] = $row['username'];
            	$_SESSION['user_id'] = $row['user_id'];
            	header("Location: checkout.php");
            }
		}
	}
	
}else{
	header("Location: loginsam.php");
	exit();
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
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"> Password </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                    </div>                                   
									<div class="login-btn">
										<button type="submit" name="login" class="btn btn-primary">Login</button>
									</div>
									<div class="mt-3 pb-3">New member? Would you like to <a href="registration.php">Register?</a></div>
								</form>
								<div class="form-output login_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>
						</div> 
                	</div>
				</div>
			</div>
        </section>
<?php 
include('inc/footer.php');
?>