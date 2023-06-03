<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "final_project";

// connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();
// echo session_save_path();

if ($conn->connect_error) {
        die("Connect failed: %s\n". $conn->connect_error);
}
else{
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM user WHERE user_id = $user_id"; //查詢餐廳資料        
    $result = mysqli_query($conn, $sql);
    $user_data = mysqli_fetch_assoc($result);
}

//history
$sql = "SELECT *, restaurants.name AS restaurant_name FROM order_table_finish, restaurants WHERE user_id_f = '$user_id' and restaurant_id_f = restaurant_id";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    // echo "order_id_f: " . $row["order_id_f"]. "restaurant_id_f: " . $row["restaurant_id_f"]."order_time_f: " . $row["order_time_f"]. "delivery_address_f: " . $row["delivery_address_f"]. "total_price_f: " . $row["total_price_f"]. "billing: " . $row["billing"]."<br>";
    // echo '<a href="user_rating.php?restaurant_id_f='.$row['restaurant_id_f'].'">'.$row["order_id_f"].'</a><br>';
    $order_id = $row["order_id_f"];
    $sql = "SELECT * FROM order_item_table_finish, menu WHERE order_id_f = '$order_id' and item_id_f=item_id";
    $result1 = $conn->query($sql);

    $order_items = array(); // 儲存每個訂單的項目的陣列

    while($row1 = $result1->fetch_assoc()){
        $order_items[] = array(
            "order_id_f" => $row1["order_id_f"],
            "item_name" => $row1["name"],
            "quantity_f" => $row1["quantity_f"],
            "food" => $row1["food"],
            "price" => $row1["price"] * $row1["quantity_f"]
        );
        // echo "order_id_f: " . $row1["order_id_f"]. "item_id_f: " . $row1["item_id_f"]."quantity_f: " . $row1["quantity_f"]. "<br>";
    }
    $data[] = array(
        "order_id_f" => $row["order_id_f"],
        "restaurant_name_f" => $row["restaurant_name"],
        "order_time_f" => $row["order_time_f"],
        "delivery_address_f" => $row["delivery_address_f"],
        "total_price_f" => $row["total_price_f"],
        "billing" => $row["billing"],
        "logo" => $row["logo"],
        "order_items" => $order_items
    );

}

if (isset($_POST['clear_session'])) {
    unset($_SESSION['user_id']);
    header('Location: welcome.php');
}

$conn->close();
?>



<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>EAT UBER</title>

        <!-- CSS FILES -->      
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

        <link href="mini_finance/css/bootstrap.min.css" rel="stylesheet">

        <link href="mini_finance/css/bootstrap-icons.css" rel="stylesheet">

        <link href="mini_finance/css/tooplate-mini-finance.css" rel="stylesheet">
<!--

Tooplate 2135 Mini Finance

https://www.tooplate.com/view/2135-mini-finance

Bootstrap 5 Dashboard Admin Template

-->
    </head>
    
    <body>
        <header class="navbar sticky-top flex-md-nowrap">
            <div class="col-md-3 col-lg-3 me-0 px-3 fs-6">
                <a class="navbar-brand" href="welcome.php">
                    <i class="bi-box"></i>
                    Eat Uber
                </a>
            </div>

            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <form class="custom-form header-form ms-lg-3 ms-md-3 me-lg-auto me-md-auto order-2 order-lg-0 order-md-0" action="#" method="get" role="form">
                <input class="form-control" name="search" type="text" placeholder="Search" aria-label="Search">
            </form>

        </header>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-3 d-md-block sidebar collapse">
                    <div class="position-sticky py-4 px-3 sidebar-sticky">
                        <ul class="nav flex-column h-100">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="welcome.php">
                                    <i class="bi-house-fill me-2"></i>
                                    Home
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="wallet.html">
                                    <i class="bi-wallet me-2"></i>
                                    My Cart
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="profile.php">
                                    <i class="bi-person me-2"></i>
                                    Profile
                                </a>
                            </li>

                            <li class="nav-item border-top mt-auto pt-2">
                                <form method="post">
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <button type="submit" class="nav-link" style="border: none; background: none; cursor: pointer;" name="clear_session">
                                            <i class="bi-box-arrow-left me-2"></i>
                                            Logout
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Profile</h1>
                    </div>

                    <div class="row my-4">
                        <div class="col-lg-7 col-12">
                            <div class="custom-block custom-block-profile">
                                <div class="row">
                                    <div class="col-lg-12 col-12 mb-3">
                                        <h6>General</h6>
                                    </div>

                                    <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                                        <div class="custom-block-profile-image-wrap">
                                            <img src="uploads/senior-man-white-sweater-eyeglasses.jpg" class="custom-block-profile-image img-fluid" alt="">

                                            <a href="setting.html" class="bi-pencil-square custom-block-edit-icon"></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-12">
                                        <p class="d-flex flex-wrap mb-2">
                                            <strong>First Name:</strong>

                                            <span><?php echo $user_data['first_name']; ?></span>
                                        </p>

                                        <p class="d-flex flex-wrap mb-2">
                                            <strong>Last Name:</strong>

                                            <span><?php echo $user_data['last_name']; ?></span>
                                        </p>

                                        <p class="d-flex flex-wrap mb-2">
                                            <strong>Email:</strong>

                                            <span><?php echo $user_data['email']; ?></span>
                                        </p>

                                        <p class="d-flex flex-wrap mb-2">
                                            <strong>Phone:</strong>
                                            <span><?php echo $user_data['phone_number']; ?></span>
                                        </p>

                                        <p class="d-flex flex-wrap">
                                            <strong>Address:</strong>
                                            <span><?php echo $user_data['delivery_address']; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-block custom-block-transations">
                                <h5 class="mb-4">Recent Transations</h5>
                                <?php if(isset($data)): ?>
                                <?php foreach ($data as $row): ?>
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $row['logo'] ?>" class="profile-image img-fluid" alt="">

                                            <div>
                                                <p>
                                                    <?php echo $row["restaurant_name_f"]; ?>
                                                </p>

                                                <small class="text-muted"><?php echo $row["billing"]; ?></small>
                                            </div>
                                        </div>

                                        <div class="ms-auto">
                                            <small><?php echo $row["order_time_f"]; ?></small>
                                            <strong class="d-block text-danger"><span class="me-1">-</span><?php echo $row["total_price_f"]; ?> </strong>
                                        </div>
                                    </div>
                                    <?php foreach ($row["order_items"] as $item): ?>
                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-5">
                                                    <img src="<?php echo $item['food'] ?>" class="profile-image img-fluid" alt="">
                                                </div>
                                                <div>
                                                    <p>
                                                        <?php echo $item["item_name"]; ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="ms-auto">
                                                <small><?php echo $item["quantity_f"]; ?></small>
                                                <strong class="d-block text-danger"><span class="me-1"></span><?php echo $item["price"]; ?> </strong>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="custom-block custom-block-profile bg-white">
                                <h6 class="mb-4">Card Information</h6>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>User ID:</strong>

                                    <span>012 395 8647</span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Type:</strong>

                                    <span>Personal</span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Created:</strong>

                                    <span>July 19, 2020</span>
                                </p>

                                <p class="d-flex flex-wrap mb-2">
                                    <strong>Valid Date:</strong>

                                    <span>July 18, 2032</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12">
                            <div class="custom-block custom-block-contact">
                                <h6 class="mb-4">Still can’t find what you looking for?</h6>

                                <p>
                                    <strong>Call us:</strong>
                                    <a href="tel: 305-240-9671" class="ms-2">
                                        (60) 
                                        305-240-9671
                                    </a>
                                </p>

                                <a href="#" class="btn custom-btn custom-btn-bg-white mt-3">
                                    Chat with us
                                </a>
                            </div>
                        </div>
                    </div>

                    <footer class="site-footer">
                        <div class="container">
                            <div class="row">
                                
                                <div class="col-lg-12 col-12">
                                    <p class="copyright-text">Copyright © Eat Uber 
                                    - Design: <a rel="sponsored" target="_blank">Hao</a></p>
                                </div>

                            </div>
                        </div>
                    </footer>
                </main>

            </div>
        </div>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>