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
if(isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
}

//address
$sql = "SELECT * FROM user WHERE user_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$user_delivery_address = $row['delivery_address'];
 // echo "user_delivery_address: " . $user_delivery_address."<br>";

//restaurant name, total price
$sql = "SELECT * FROM order_table, restaurants WHERE user_id = '$id' and order_table.restaurant_id = restaurants.restaurant_id"; 
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_price = 0;
if(isset($row)) {
    $total_price = $row["total_price"];
    //echo "restaurant_id: " . $row["restaurant_id"]. " - name: " . $row["name"]. " - total_price: " . $row["total_price"]. "<br>";
    $order_id = $row['order_id'];
    //item name, quantity

    $sql = "SELECT * FROM order_item_table, menu WHERE order_id = '$order_id' and menu.item_id = order_item_table.item_id"; 
    $result = mysqli_query($conn, $sql);
        
    $item = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $item[] = $row;
        //$item['quantity_price'] = $row["price"] * $row["quantity"];
        //echo "item_id: " . $row["item_id"]. " - quantity: " . $row["quantity"]. " - item_name: " . $row["name"]. " - price: " . $row["price"]. "<br>";
    }
}






if(isset($_POST['pay'])) {
    $payment_method =  $_POST['payment'];
    // echo "payment_method: " . $payment_method. "<br>";

    $sql = "SELECT * FROM order_table WHERE order_id = '$order_id' and user_id = '$id'"; 
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $order_time = date('Y-m-d H:i:s');
    $restaurant_id = $row["restaurant_id"];   

    $sql = "INSERT INTO order_table_finish (restaurant_id_f, user_id_f, order_id_f, order_time_f, delivery_address_f, total_price_f, billing) VALUES ('$restaurant_id', '$id', '$order_id', '$order_time', '$user_delivery_address', '$total_price', '$payment_method')";
    $conn->query($sql);



    $sql = "SELECT * FROM order_item_table, menu WHERE order_id = '$order_id' and menu.item_id = order_item_table.item_id";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $item_id = $row["item_id"];
        $quantity = $row["quantity"];
        $sql = "INSERT INTO order_item_table_finish (order_id_f, item_id_f, quantity_f) VALUES ('$order_id', '$item_id', '$quantity')";
        $conn->query($sql); 
    }

    $sql = "DELETE FROM order_table WHERE order_id = '$order_id' and user_id = '$id'";
    $conn->query($sql);

    $sql = "DELETE FROM order_item_table WHERE order_id = '$order_id'";
    $conn->query($sql);

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

            <form class="custom-form header-form ms-lg-3 ms-md-3 me-lg-auto me-md-auto order-2 order-lg-0 order-md-0" action="#" method="get" role="form">
                <input class="form-control" name="search" type="text" placeholder="Search" aria-label="Search">
            </form>


        </header>

                
        <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start ">
                <div class="row my-4">    
                
                    <div class="row" >
                        <div class="col-lg-6">
                            <div class="custom-block custom-block-exchange" style="width: 140%;" >
                                <h5 class="mb-4">My cart</h5>
                                

                                <?php if (isset($item)): ?>

                                    <?php foreach ($item as $items): ?>
                                        <div>
                                            <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        
                                                        <img src="<?php echo $items['food'] ?>" class="exchange-image img-fluid" alt="Restaurant Image" style="width: 200px; height: 150px; object-fit: cover; cursor: pointer;">
                                                        
                                                    </div>

                                                    <div>
                                                        <p><?php echo $items['name'] ?></p>
                                                    </div>
                                                </div>

                                                <div class="ms-auto me-4">
                                                    number 
                                                    <h6><?php echo $items['quantity'] ?></h6>
                                                    Price
                                                    <h6><?php $price = $items['price']; $quantity = $items['quantity']; $result = $price * $quantity; echo $result; ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-end">
                            <div class="custom-block custom-block-transations"  style="width: 60%";>
                                <h5 class="mb-2" style="font-size: 24px;">Address :</h5>
                                <h5><?php echo $user_delivery_address?></h5>
                                <h6>total price : <?php echo $total_price?></h6>


                                <form method="post">
                                    <label><strong><font size="6">PAY choice</strong></font></label><br><br>

                                    <select name="payment" id="color">
                                        <option value="">--- Choose a payment method ---</option>
                                        <option value="cash">cash</option>
                                        <option value="card">credit card</option>
                                    </select>
                                    <input type="submit" name="pay" value="pay"/><br>


                                </form>

                            </div>
                        </div>    
                    </div>

                        
                    </div>
                </div>
            </div>

                   
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