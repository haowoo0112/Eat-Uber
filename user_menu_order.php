<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "final_project";

// connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connect failed: %s\n". $conn->connect_error);
}
$item_id  = $_GET['item_id'];
$res_id = $_GET['res_id'];
$price = $_GET['price'];

//query user id 
if(isset($_POST['OK'])) {

	session_start();
	if(isset($_SESSION['user_id'])) {
		$id = $_SESSION['user_id'];
	}

	$sql = "SELECT total_price,order_id FROM order_table WHERE user_id = '$id'"; // user_id
	$result = $conn->query($sql);

	$quantity =  $_POST['quantity'];
	print($result->num_rows);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$total_price = $row['total_price'] + $quantity * $price;
		$order_id =  $row['order_id'];
	    $sql = "UPDATE order_table SET total_price= '$total_price' WHERE user_id = '$id'";
	    $conn->query($sql);
		

		$sql = "SELECT * FROM order_item_table WHERE order_id = '$order_id' and item_id  = '$item_id' "; 
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$quantity = $row['quantity'] + $quantity;
		    $sql = "UPDATE order_item_table SET quantity= '$quantity' WHERE  order_id = '$order_id' and item_id  = '$item_id'";
		    $conn->query($sql);
		}
		else{
			print("order_id = ");
			print($order_id);
			print("item_id = ");
			print($item_id);			
			$sql = "INSERT INTO order_item_table (order_id, item_id, quantity) VALUES ('$order_id', '$item_id', '$quantity')";
			$conn->query($sql);
		}
	}
	else{
		$total_price = $quantity * $price;
		$sql = "INSERT INTO order_table (restaurant_id, user_id, total_price) VALUES ('$res_id', '$id', '$total_price')";
		$result = $conn->query($sql);
		$order_id = $conn->insert_id;

		$sql = "INSERT INTO order_item_table (order_id, item_id, quantity) VALUES ('$order_id', '$item_id', '$quantity')";
		$conn->query($sql);
	}

	header('Location: welcome.php');
    

    
}

$conn->close();
?>

<form method="post">

	<input type="number" value="1" name="quantity" min="1" max="9" step="1" required>
	<input type="submit" name="OK" value="OK"/><br>
    
</form>