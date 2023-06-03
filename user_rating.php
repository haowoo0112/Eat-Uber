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
$restaurant_id_f  = $_GET['restaurant_id_f'];

//query user id 
if(isset($_POST['OK'])) {

	session_start();
	if(isset($_SESSION['user_id'])) {
		$id = $_SESSION['user_id'];
	}

	$rating =  $_POST['rating'];

	$sql = "SELECT * FROM restaurants WHERE restaurant_id = '$restaurant_id_f'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$res_rating = $row['rating'];
	$res_rating_num = $row['rating_num'];
	$restaurant_name = $row['name'];
    $res_rating = ($res_rating * $res_rating_num + $rating) / ($res_rating_num + 1);
    $res_rating_num = $res_rating_num + 1;

    $sql = "UPDATE restaurants SET rating = '$res_rating', rating_num = '$res_rating_num' WHERE restaurant_id = '$restaurant_id_f'";
	$conn->query($sql);

	$sql = "INSERT INTO opinion (user_id_o, restaurant_id_o, rating) VALUES ('$id', '$restaurant_id_f', '$rating')";
	$conn->query($sql);

    $redirectUrl = "user_menu.php?id=" . urlencode($restaurant_id_f) . "&name=" . urlencode($restaurant_name);
    header("Location: " . $redirectUrl);
}

$conn->close();
?>

<form method="post">

	<input type="number" value="0" name="rating" min="0" max="5" step="1" required>
	<input type="submit" name="OK" value="OK"/><br>
    
</form>