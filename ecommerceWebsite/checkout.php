<?php 
session_start();
require('inc/conn.php');
if(!isset($_SESSION['user_login'])){
	?>
	<script>
	window.location.href='login.php';
	</script>
	<?php
}

if(!isset($_COOKIE['shopping_cart']) || count(json_decode($_COOKIE['shopping_cart'])) == 0){
?>
 <script>window.location.href='category.php';</script>
 <?php
}

$total = 0;
$cookie_data = stripslashes($_COOKIE['shopping_cart']);
$cart_data = json_decode($cookie_data, true);
foreach($cart_data as $keys => $values)
{
    $total = $total + ($values["item_quantity"] * $values["item_price"]);
}
if(isset($_POST['proceed'])){
    $orderDate = date('Y-m-d h:i:s');
    $status = 1;
    $payment_type = $_POST['payment_type'];
    $user_id = $_SESSION['user_id'];
    if($payment_type == 'cod'){
        $status = "success";
    }
    $totalOrderAmount = $total;
    $shipAddress = $_POST['ship_address'];
    $billAddress = $_POST['bill_address'];

$conn->beginTransaction();
$stmt = $conn->prepare("INSERT INTO `orders`(`user_id`, `order_date`, `payment_method`, `status`, `total_order_amount`) VALUES (:user_id, :order_date, :payment_method, :order_status, :total_order_amount)");

$stmt->bindParam(":order_date", $orderDate);
$stmt->bindParam(":payment_method", $payment_type);
$stmt->bindParam(":order_status", $status);
$stmt->bindParam(":total_order_amount", $totalOrderAmount);
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();

    $order_id=$conn->lastInsertId(); 
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
    // $cart_data = [];
    $bulk_product = array();
    foreach($cart_data as $keys => $values)
    {
        // $item_array = [
        //     '$product_id'   => $values['item_id'],
        //     '$quantity'     => $values['item_quantity'],
        //     '$product_price'=> $values['item_price']
        // ];
        // $cart_data[] = $item_array;
        $product_id    = $values['item_id'];
        $quantity      = $values['item_quantity'];
        $product_price = $values['item_price'];

        $bulk_product[] = "(:order_id, :product_id, :quantity, :product_price)";

    }
    $stmt2 = $conn->prepare("INSERT INTO `order_product`(`order_id`, `product_id`, `quantity`, `product_price`) VALUES " .implode(',', $bulk_product));
    $stmt2->bindParam(':order_id', $order_id);
    $stmt2->bindParam(':product_id', $product_id);
    $stmt2->bindParam(':quantity', $quantity);
    $stmt2->bindParam(':product_price', $product_price);
    $stmt2->execute();
        

    $stmt3 = $conn->prepare("INSERT INTO `order_address`(`order_id`, `shipping_address`, `billing_address`) VALUES (:order_id, :shipAddress, :billAddress)");
    $stmt3->bindParam(':order_id', $order_id);
    $stmt3->bindParam(':shipAddress', $shipAddress);
    $stmt3->bindParam(':billAddress', $billAddress);
    
    
    if($stmt3->execute()){
    $conn->commit();
    echo "<script>alert('Record inserted successfully');</script>";
    echo "<script>window.location.href='thankyou.php'</script>";
    }
    else {
    $conn->rollback();
    echo "<script>alert('Something went wrong. Please try again');</script>";
    echo "<script>window.location.href='checkout.php'</script>";
    }

    setcookie("shopping_cart", "", time() - 3600);
}

?>

<?php 
include('inc/header.php');
?>
<div class="ml-5 pt-5 font-weight-bold">Hello, <?php echo $_SESSION ['username']; ?></div>
<div class="container">
    <h3 class="text-center text-danger mb-4 font-weight-bold mr-5"> Checkout</h3>
    <div class="row">
        <!-- <button type="submit" class="btn btn-primary col-sm-12 mb-5"> Proceed to Pay</button> -->
        <div class="col-sm-8 bg-light">
            <form action="" method="post">
                <div class="form-group row pt-3">
                    <label for="fullName" class="col-sm-2 col-form-label"> Full Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo $_SESSION['username'];?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phoneNumber" class="col-sm-2 col-form-label"> Phone Number</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $_SESSION['mobileNumber'];?> ">
                    </div>
            
                    <label for="email" class="col-sm-2 col-form-label pl-5"> Email</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['email']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                <label for="region" class="col-sm-2 col-form-label"> Region</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="region" name="region"required>
                                    <option value="" selected disabled> Please choose your region </option>
                                    <option value="1">Bagmati Province</option>
                                    <option value="2">Gandaki Province</option>
                                    <option value="3">Karnali Province</option>
                                    <option value="4">Lumbini Province</option>
                                    <option value="5">Province 1</option>
                                    <option value="6">Province 2</option>
                                    <option value="7">Sudurpashchim Province</option>
                            </select>
                        </div>       
                </div>

                <div class="form-group row">
                <label for="city" class="col-sm-2 col-form-label"> City</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="city" name="city" required>
                                    <option value="" selected disabled> Please choose your city </option>
                                    <option value="1">Banepa</option>
                                    <option value="2">Bhaktapur</option>
                                    <option value="3">Bharatpur</option>
                                    <option value="4">Hetauda</option>
                                    <option value="5">Kathmandu Inside Ring Road</option>
                                    <option value="6">Kathmandu Outside Ring Road</option>
                                    <option value="7">Lalitpur</option>
                                    <option value="8">Butwal</option>
                                    <option value="10">Janakpur</option>
                            </select>
                        </div>       
                </div>

                <div class="form-group row">
                <label for="area" class="col-sm-2 col-form-label"> Area</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="area" name="area" required>
                                    <option value="" selected disabled> Please choose your area </option>
                                    <option value="1">Babarmahal</option>
                                    <option value="2">Godawari</option>
                                    <option value="3">Imadol</option>
                                    <option value="4">Maitighar</option>
                                    <option value="5">Nakhu</option>
                                    <option value="6">Teku</option>
                                    <option value="7">Thapathali</option>
                                    <option value="8">Thimi</option>
                                    <option value="9">Tripureshwor</option>
                            </select>
                        </div>       
                </div>

                <div class="form-group row">
                    <label for="shippingAddress" class="col-sm-2 col-form-label"> Shipping Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ship_address" name="ship_address" placeholder=" For example House#123, Street# 123, ABc " required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="billingAddress" class="col-sm-2 col-form-label"> Billing Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bill_address" name="bill_address" placeholder=" Same as billing address " required>
                    </div>
                </div>
                <div class="paymentinfo">
                    <div class="single-method">
                        <label for="payment"> Payment Method </label><br>
                        <span class="ml-5"><input type="radio" name="payment_type" value="COD" required> Cash On Delivery </span>
                        <span class="ml-5"><input type="radio" name="payment_type" value="Credit Card" required> Credit Card </span>
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-primary col-sm-6 mr-2 ml-3 mb-5" name="proceed"><i class="fa fa-check-circle"></i> Proceed to Pay </button>
                    <a href="cart.php" class="btn btn-danger col-sm-5 mb-5"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </form>
        </div>
            <div class="col-sm-4 pl-5">
                <div class="order-details bg-light">
                    <h5 class="order-details-title text-center text-primary mb-4">Your Order</h5>
                        <div class="order-details-item">
                            <?php
							if(isset($_COOKIE["shopping_cart"]))
                            {
                             $total = 0;
                             $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                             $cart_data = json_decode($cookie_data, true);
                             foreach($cart_data as $keys => $values)
                             {
                             $total = $total + ($values["item_quantity"] * $values["item_price"]);
							?>
							<div class="single-item">
                                 <div class="single-item-content">
                                    <span class="pl-2"><?php echo $values['item_id']?></span>
                                    <span class="col-sm-1 pl-3"><?php echo $values["item_name"]?></span>
                                    <span class="col-sm-1 pl-4"> &#8360; <?php echo $values["item_quantity"] * $values["item_price"]?></span>
                                </div>
                            </div>
								<?php } }?>
                        </div>
                            <div class="ordre-details-total bg-dark">
                                <span class="pl-2 text-info font-weight-bold">Grand total</span>
                                <span class="col-sm-2 pl-5 text-white"> &#8360; <?php echo $total?></span>
                            </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>

<?php 
include('inc/footer.php');
?>