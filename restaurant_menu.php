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
session_start();

$sql = "SELECT * FROM menu WHERE res_id= '{$_SESSION['res_id']}'";     
$result = mysqli_query($conn, $sql);

$menu = array();
while ($row = mysqli_fetch_assoc($result)) {
    $menu[] = $row;
}

// add
if(isset($_POST['Add'])) {
    $name =  $_POST['add-name'];
    $description = $_POST['add-description'];
    $price = $_POST['add-price'];
    
    $targetDir = "uploads/menu/";
    $targetFile = $targetDir . basename($_FILES["add-image"]["name"]);  // 圖片存放的完整路徑

    if (move_uploaded_file($_FILES["add-image"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    }

    $sql = "SELECT * FROM menu WHERE name= '$name' and res_id = '{$_SESSION['res_id']}'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo "food exist";
    }
    else{
        $sql = "INSERT INTO menu (name, description, price, res_id, food) VALUES ('$name', '$description', '$price','{$_SESSION['res_id']}', '$imagePath')";
        $conn->query($sql);
    }
    header('Location: restaurant_menu.php');
}

// receive update post
if(isset($_POST['update'])) {
    $name =  $_POST['update-name'];
    $description = $_POST['update-description'];
    $price = $_POST['update-price'];

    $targetDir = "uploads/menu/";
    $targetFile = $targetDir . basename($_FILES["update-image"]["name"]);  // 圖片存放的完整路徑

    if (move_uploaded_file($_FILES["update-image"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    }

    $sql = "UPDATE menu SET description='$description', price='$price', food='$imagePath' WHERE name= '$name'";
    $conn->query($sql);
    header('Location: restaurant_menu.php');
}

if(isset($_POST['delete_food'])) {
    $delete_id = $_POST['delete_food_id'];
    $sql = "DELETE FROM menu WHERE item_id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        // 刪除成功
        echo "Restaurant deleted successfully.";
    } else {
        // 刪除失敗
        echo "Error deleting restaurant: " . $conn->error;
    }
    header('Location: restaurant_menu.php');
}

$conn->close();
?>

<!-- <form method="post">
    <label><strong><font size="5">log in</strong></font></label><br>
    email: <input type="int" name="email"><br>
    password: <input type="text" name="password"><br>
    <input type="submit" name="log_in" value="log_in"/><br>

    <br>

    <input type="button" onclick="location.href='http://localhost/user_test.php';" value="test" />

    
</form> -->

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>EAT UBER - Restaurant Manage</title>

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
                            
                        </ul>
                    </div>
                </nav>

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Restaurant Manage System</h1>
                    </div>

                    <div class="row my-4">
                        <div class="col-lg-7 col-12">
                            <div class="custom-block bg-white">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Menu</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="update-tab" data-bs-toggle="tab" data-bs-target="#update-tab-pane" type="button" role="tab" aria-controls="update-tab-pane" aria-selected="false">Update</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add-tab-pane" type="button" role="tab" aria-controls="add-tab-pane" aria-selected="false">Add</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                        <h6 class="mb-4">Menu</h6>

                                        <?php foreach ($menu as $menu): ?>
                                            <div>
                                                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <a href="user_menu_order.php?item_id=<?php echo $menu['item_id']?>&res_id=<?php echo $menu['res_id']?>& price=<?php echo $menu['price']?>">
                                                                <img src="<?php echo $menu['food'] ?>" class="exchange-image img-fluid" alt="Restaurant Image" style="width: 200px; height: 150px; object-fit: cover; cursor: pointer;">
                                                            </a>
                                                        </div>

                                                        <div>
                                                            <p><?php echo $menu['name'] ?></p>
                                                            <h6><?php echo $menu['description'] ?></h6>
                                                        </div>
                                                    </div>

                                                    <div class="ms-auto me-4">
                                                        Price
                                                        <h6><?php echo $menu['price'] ?></h6>
                                                    
                                                        <div class="custom-block-bottom-item">
                                                            <form method="post" role="form" id="delete-form">
                                                                <input type="hidden" name="delete_food_id" value="<?php echo $menu['item_id']; ?>">
                                                                <button type="submit" class="d-flex flex-column" style="border: none; background: none; cursor: pointer;" name="delete_food">
                                                                    <i class="custom-block-icon bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                             </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="tab-pane fade" id="update-tab-pane" role="tabpanel" aria-labelledby="update-tab" tabindex="0">
                                        <h6 class="mb-4">Update</h6>

                                        <form class="custom-form update-form" action="#" method="post" enctype="multipart/form-data" role="form" id="update-form">
                                            
                                            <input class="form-control" type="text" name="update-name" id="update-name" placeholder="Food Name">

                                            <input class="form-control" type="text" name="update-description" id="update-description" placeholder="Description">

                                            <input class="form-control" type="text" name="update-price" id="update-price" placeholder="Price">

                                            <input class="form-control" type="file" name="update-image" id="update-image" placeholder="image" >

                                            <div class="d-flex">
                                                <button type="button" class="form-control me-3" id="update-reset">
                                                    Reset
                                                </button>

                                                <button type="submit" class="form-control ms-2" name="update">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="add-tab-pane" role="tabpanel" aria-labelledby="add-tab" tabindex="0">
                                        <h6 class="mb-4">Add</h6>

                                        <form class="custom-form sign-form" action="#" method="post" enctype="multipart/form-data" role="form" id="add-form">

                                            <input class="form-control" type="text" name="add-name" id="add-name" placeholder="Food Name">

                                            <input class="form-control" type="text" name="add-description" id="add-name" placeholder="Description">

                                            <input class="form-control" type="text" name="add-price" id="add-price" placeholder="Price">

                                            <input class="form-control" type="file" name="add-image" id="add-image" placeholder="image" >

                                            <div class="d-flex mt-4">
                                                <button type="button" class="form-control me-3" id="add-reset">
                                                    Reset
                                                </button>

                                                <button type="submit" class="form-control ms-2" name="Add">
                                                    Add
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12">
                            <div class="custom-block custom-block-contact">
                                <h6 class="mb-4">Still can’t find what you looking for?</h6>

                                <p>
                                    <strong>Call us:</strong>
                                    <a href="tel: 305-240-9671" class="ms-2">
                                        (09) 
                                        012-345-6789
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
        <script src="mini_finance/js/jquery.min.js"></script>
        <script src="mini_finance/js/bootstrap.bundle.min.js"></script>
        <script src="mini_finance/js/custom.js"></script>
        <script src="js/restaurant_menu_reset.js"></script>
    </body>
</html>