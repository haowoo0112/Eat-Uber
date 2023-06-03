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

    $sql = "SELECT * FROM restaurants ORDER BY rating DESC"; //查詢餐廳資料        
    $result = mysqli_query($conn, $sql);

    $restaurants = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $restaurants[] = $row;
    }
      
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
            <!-- search box -->
            <form class="custom-form header-form ms-lg-3 ms-md-3 me-lg-auto me-md-auto order-2 order-lg-0 order-md-0" action="#" method="get" role="form">
                <input class="form-control" name="search" type="text" placeholder="Search" aria-label="Search">
            </form>
            <!-- log in -->

            
        </header>

        <div class="container-fluid">
            <div class="row">
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
                            <li class="nav-item">
                                <a class="nav-link" href="Admin.php">
                                    <i class="bi-gear me-2"></i>
                                    Admin
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="restaurant_log.php">
                                    <i class="bi-gear me-2"></i>
                                    Restaurant Manage
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

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Restaurant</h1>

                        <small class="text-muted">Hello , welcome back!</small>
                    </div>

                    <div class="row my-4">
                        <div class="col-lg-7 col-12">
                            <div class="custom-block custom-block-exchange">
                                <h5 class="mb-4">Suggest</h5>
                                <?php foreach ($restaurants as $restaurant): ?>
                                    <div>
                                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                            <div>
                                                <a href="user_menu.php?id=<?php echo $restaurant['restaurant_id']?>&name=<?php echo $restaurant['name']?>">
                                                    <img src="<?php echo $restaurant['logo'] ?>" class="exchange-image img-fluid" alt="Restaurant Image" style="width: 400px; height: 150px; object-fit: cover; cursor: pointer;">
                                                </a>
                                            </div>

                                            <div class="ms-4">
                                                <div>
                                                    <p><?php echo $restaurant['name']; ?></p>
                                                    <h6><?php echo $restaurant['address']; ?></h6>
                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <small class="text-muted">Rating</small>
                                                        <h6 class="mb-0" style="font-size: 12px;"><?php echo $restaurant['rating']; ?></h6>
                                                    </div>

                                                    <div>
                                                        <small class="text-muted">Rating Num</small>
                                                        <h6 class="mb-0" style="font-size: 12px;"><?php echo $restaurant['rating_num']; ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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