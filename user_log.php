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

// log in
if(isset($_POST['log_in'])) {
    $email =  $_POST['profile-email'];
    $password = $_POST['profile-password'];
    $sql = "SELECT email, password, user_id FROM user WHERE email= '$email' and password= '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0){
        // echo "user not exist";
    }
    else{
        // echo "user exist";
        session_start();        
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row["user_id"]; 
        //$_SESSION['email'] = $email; 
        print($_SESSION['user_id']) ;      
        //print($_SESSION['email']);
        header('Location: welcome.php');
    }
}

// receive Insert post
if(isset($_POST['Registration'])) {
    $First_Name =  $_POST['sign-fname'];
    $Last_Name = $_POST['sign-lname'];
    $email = $_POST['sign-email'];
    $password = $_POST['sign-password'];
    $phone_number = $_POST['sign-phone'];
    $delivery_address = $_POST['sign-address'];


    // $uppercase = preg_match('@[A-Z]@', $password);
    // $lowercase = preg_match('@[a-z]@', $password);
    // $number    = preg_match('@[0-9]@', $password);
    // $specialChars = preg_match('@[^\w]@', $password);

    // if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    //     echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
    // }else{
    $sql = "INSERT INTO user (First_Name, Last_Name, email, password, phone_number,delivery_address) VALUES ('$First_Name', '$Last_Name', '$email', '$password', '$phone_number', '$delivery_address')"; //TODO
    $conn->query($sql);
    // if($conn->query($sql) === True)
    //     echo 'Success';
    // else
    //     echo 'email has exist';
    // }        
    // TODO: header
    header('Location: user_log.php');
}

// receive update post
if(isset($_POST['update'])) {
    $email =  $_POST['change-email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    $sql = "UPDATE user SET password='$new_password' WHERE email= '$email'";
    $conn->query($sql);
    header('Location: user_log.php');
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

        <title>EAT UBER - Log In</title>

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
                                <a class="nav-link" href="user_log.php">
                                    <i class="bi-wallet me-2"></i>
                                    My Cart
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="user_log.php">
                                    <i class="bi-person me-2"></i>
                                    Profile
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="user_log.php">
                                    Log In
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
                        <h1 class="h2 mb-0">Log In</h1>
                    </div>

                    <div class="row my-4">
                        <div class="col-lg-7 col-12">
                            <div class="custom-block bg-white">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Profile</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-tab-pane" type="button" role="tab" aria-controls="password-tab-pane" aria-selected="false">Password</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sign-tab" data-bs-toggle="tab" data-bs-target="#sign-tab-pane" type="button" role="tab" aria-controls="sign-tab-pane" aria-selected="false">Sign up</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                        <h6 class="mb-4">User Profile</h6>

                                        <form class="custom-form profile-form" action="#" method="post" role="form" id="profile-form">
                                            <input class="form-control" type="email" name="profile-email" id="profile-email" placeholder="Email">

                                            <input class="form-control" type="password" name="profile-password" id="profile-password" placeholder="Password">


                                            <div class="d-flex">
                                                <button type="button" class="form-control me-3" id="profile-reset">
                                                    Reset
                                                </button>

                                                <button type="submit" class="form-control ms-2" name="log_in">
                                                    Enter
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="password-tab-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                                        <h6 class="mb-4">Password</h6>
                                        <!-- TODO -->
                                        <form class="custom-form password-form" action="#" method="post" role="form" id="password-form">
                                            
                                            <input class="form-control" type="email" name="change-email" id="change-email" placeholder="Email">

                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" required="">

                                            <input type="password" name="new_password" id="new_password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}" class="form-control" placeholder="New Password" required title="密碼需包含至少一個大小寫英文字母、數字和特殊符號">

                                            <input type="password" name="confirm_password" id="confirm_password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}" class="form-control" placeholder="Confirm Password" required title="Passwords do not match">

                                            <div class="d-flex">
                                                <button type="button" class="form-control me-3" id="change-reset">
                                                    Reset
                                                </button>

                                                <button type="submit" class="form-control ms-2" name="update">
                                                    Update Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="sign-tab-pane" role="tabpanel" aria-labelledby="sign-tab" tabindex="0">
                                        <h6 class="mb-4">Sign up</h6>

                                        <form class="custom-form sign-form" action="#" method="post" role="form" id="sign-form">

                                            <input class="form-control" type="email" name="sign-email" id="sign-email" placeholder="Email">

                                            <input class="form-control" type="password" name="sign-password" id="sign-password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}" placeholder="Password" required title="密碼需包含至少一個大小寫英文字母、數字和特殊符號">

                                            <input class="form-control" type="text" name="sign-fname" id="sign-fname" placeholder="First Name">

                                            <input class="form-control" type="text" name="sign-lname" id="sign-lname" placeholder="Last Name">

                                            <input class="form-control" type="text" name="sign-phone" id="sign-phone"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="Phone" required title="請輸入有效的電話號碼（格式：123-456-7890）">

                                            <input class="form-control" type="text" name="sign-address" id="sign-address" placeholder="Address">

                                            <div class="d-flex mt-4">
                                                <button type="button" class="form-control me-3" id="sign-reset">
                                                    Reset
                                                </button>

                                                <button type="submit" class="form-control ms-2" name="Registration">
                                                    Registration
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
        <script src="js/log_in_reset.js"></script>
    </body>
</html>