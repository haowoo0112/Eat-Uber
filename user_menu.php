<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "final_project";

// connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();
// echo session_save_path();
if(isset($_SESSION['email'])) {
    $id = session_id();
    // print($_SESSION['email']);
}

if ($conn->connect_error) {
     	die("Connect failed: %s\n". $conn->connect_error);
}
else{
    $id = $_GET['id'];
    // print($id);
    $sql = "SELECT * FROM restaurants WHERE restaurant_id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    $restaurants = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $restaurants[] = $row;
        
    }


    $sql = "SELECT * FROM menu WHERE res_id= '$id'";     
    $result = mysqli_query($conn, $sql);

    $menu = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $menu[] = $row;
    }


    $sql = "SELECT first_name, last_name, opinion.rating, message FROM opinion, user WHERE restaurant_id_o = '$id'and user_id_o = user_id ORDER BY rating DESC ";
    $result = mysqli_query($conn, $sql);
    
    $user_rating = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $user_rating[] = $row;
        
    }  
}

if (isset($_POST['clear_session'])) {
    unset($_SESSION['user_id']);
    header('Location: welcome.php');
}

if(isset($_POST['rating'])) {
    $redirectUrl = "user_rating.php?restaurant_id_f=" . urlencode($id);
    header("Location: " . $redirectUrl);
}

$conn->close();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="Tooplate">

        <title>EAT UBER</title>

        <!-- CSS FILES -->      
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

        <link href="mini_finance/css/bootstrap.min.css" rel="stylesheet">

        <link href="mini_finance/css/bootstrap-icons.css" rel="stylesheet">

        <link href="mini_finance/css/apexcharts.css" rel="stylesheet">

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

        <div class="container-fluid" >
            <div class="row" >
                <nav id="sidebarMenu" class="col-md-3 col-lg-3 d-md-block sidebar collapse">
                    <div class="position-sticky py-4 px-3 sidebar-sticky">
                        <ul class="nav flex-column h-100">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="welcome.php">
                                    <i class="bi-house-fill me-2"></i>
                                    Home
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="user_order.php">
                                    <i class="bi-wallet me-2"></i>
                                    My Cart
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">
                                    <i class="bi-person me-2"></i>
                                    Profile
                                </a>
                            </li>
                            
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="user_log.php">
                                        Log In
                                    </a>
                                </li>
                            <?php endif; ?>

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
                  
                
                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start ">

                    <div class="row my-4">
                        <div class="col-lg-7 col-12">
                            <?php foreach ($restaurants as $restaurant): ?>
                                <div>
                                    <div class="custom-block custom-block-balance" style="width: 1400px; height: 200px; background-image: url('<?php echo $restaurant['logo']; ?>'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <h2 class="mt-2 mb-3"><?php echo $restaurant['name']?></h2>
                            <div class="custom-block-numbers d-flex align-items-center">                                        
                                <p><?php echo $restaurant['description']?></p>
                            </div>

                            <div class="d-flex">
                                <div>
                                    <small>rating : <?php echo $restaurant['rating']?></small></p>
                                    <small>rating number : <?php echo $restaurant['rating_num']?></small>
                                </div>
                            </div>
                        </div>
                        <form class="custom-form rating-form" action="#" method="post" role="form" id="rating-form">
                            <div class="d-flex">
                                <button type="submit" class="form-control ms-2" name="rating">
                                    Rating
                                </button>
                            </div>
                        </form>
                        <div class="row" style = "margin-top: 200px;">
                            <div class="col-lg-6">
                                <div class="custom-block custom-block-exchange" style="width: 140%;" >
                                    <h5 class="mb-4">Menu</h5>
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
                                                </div>
                                            </div>
                                         </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-lg-6 d-flex justify-content-end">
                                <div class="custom-block custom-block-transations"  style="width: 60%";>
                                    <h5 class="mb-2" style="font-size: 24px;">Recent Message</h5>
                                    <?php foreach ($user_rating as $user_rating): ?>
                                        <div>
                                            <div class="d-flex flex-wrap align-items-center mb-4" style="border-top: 1px solid #ccc;">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p>
                                                            <?php echo $user_rating['first_name']?> <?php echo $user_rating['last_name']?>
                                                        </p>

                                                        <small class="text-muted"><?php echo $user_rating['message']?></small>
                                                    </div>
                                                </div>

                                                <div class="ms-auto">
                                                    <strong class="d-block text-danger"><span class="me-1">-</span> <?php echo $user_rating['rating']?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>    
                                </div>
                            </div>    
                        </div>
                    </div> 
                    <footer class="site-footer">
                        <div class="container">
                            <div class="row">
                                
                                <div class="col-lg-12 col-12">
                                    <p class="copyright-text">Copyright © Mini Finance 2048 
                                    - Design: <a rel="sponsored" href="https://www.tooplate.com" target="_blank">Tooplate</a></p>
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
        <script src="js/apexcharts.min.js"></script>
        <script src="js/custom.js"></script>

        <script type="text/javascript">
            var options = {
              series: [13, 43, 22],
              chart: {
              width: 380,
              type: 'pie',
            },
            labels: ['Balance', 'Expense', 'Credit Loan',],
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
            };

            var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
            chart.render();
        </script>

        <script type="text/javascript">
            var options = {
              series: [{
              name: 'Income',
              data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
              name: 'Expense',
              data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }, {
              name: 'Transfer',
              data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
            }],
              chart: {
              type: 'bar',
              height: 350
            },
            plotOptions: {
              bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
              },
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              show: true,
              width: 2,
              colors: ['transparent']
            },
            xaxis: {
              categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            yaxis: {
              title: {
                text: '$ (thousands)'
              }
            },
            fill: {
              opacity: 1
            },
            tooltip: {
              y: {
                formatter: function (val) {
                  return "$ " + val + " thousands"
                }
              }
            }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        </script>

    </body>
</html>