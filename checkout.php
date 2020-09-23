<?php
    session_start();
    require 'config.php';

    $grand_total = 0;
    $allItems = '';
    $items = array();

    $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $grand_total += $row['total_price'];
        $items[] = $row['ItemQty'];
    }

    $allItems = implode(", ", $items);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php"> <i class="fa fa-mobile-phone"></i>&nbsp;&nbsp;Mobstore</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="checkout.php">Checkout</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"> <span id="cart-item" class="badge badge-danger"></span></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
        </li>
        </ul>
    </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 pb-4" id="order">
                <h4 class="text-center text_info p-2">Payment</h4>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Product(s) : </b><?php echo $allItems; ?></h6>
                    <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                    <h5><b>Total Amount Payable : </b><?php echo number_format($grand_total,2); ?></h5>
                    <form action="" method ="post" id="placeOrder">
                        <input type="hidden" name="products" value="<?php echo $allItems; ?>">
                        <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                        
                        <?php
                        $ss=$_SESSION['ss'];
                        $sel="select * from customer where ID='$ss'";
                        $res = mysqli_query($conn,$sel);  
                            
                        while($arr = mysqli_fetch_array($res))
                        {
                        ?>
                        <input type="hidden" name="name" value="<?php echo $arr[1]; ?>">
                        <input type="hidden" name="email" value="<?php echo $arr[2]; ?>">
                        <input type="hidden" name="phone" value="<?php echo $arr[3]; ?>">
                        <input type="hidden" name="address" value="<?php echo $arr[4]; ?>">
                        <?php } ?>
                        <h6 class="text-center lead">Select Payment Mode</h6>
                        <div class="form-group">
                            <select name="pmode" class="form-control">
                                <option value="" selected disabled>-Select Payment Mode-</option>
                                <option value="COD">Cash On Delivery</option>
                                <option value="Net Banking">Net Banking</option>
                                <option value="Debit Card">Debit Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#placeOrder").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: $('form').serialize()+"&action=order",
                    success: function(response){
                        $("#order").html(response);                        
                    }
                });
            });

            load_cart_item_number();

            function load_cart_item_number(){
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {cartItem:"cart_item"},
                    success: function(response){
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>
</body>
</html>