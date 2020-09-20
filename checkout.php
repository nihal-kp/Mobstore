<?php           //Checkout process //Firstly I will grab the grand total amount from the cart table and I will also grab the products and quantity of the product.
    require 'config.php';

    $grand_total = 0;
    $allItems = '';
    $items = array();

    $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";            //CONCAT is using to combine product_name and qty.  //For eg Redmi(2),Iphone(4)
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $grand_total += $row['total_price'];
        $items[] = $row['ItemQty'];
    }
    //echo $grand_total;    
    //print_r($items);

    $allItems = implode(", ", $items);             //implode is using to make the array in to a single string
    //echo $allItems;

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
    <a class="navbar-brand" href="index.php"> <i class="fa fa-mobile-phone"></i>&nbsp;&nbsp;Mobile Store</a>

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
        </ul>
    </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 pb-4" id="order">
                <h4 class="text-center text_info p-2">Complete your order!</h4>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Product(s) : </b><?php echo $allItems; ?></h6>      <!-- Now display using php echo -->
                    <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                    <h5><b>Total Amount Payable : </b><?php echo number_format($grand_total,2); ?></h5>
                    <form action="" method ="post" id="placeOrder">
                        <input type="hidden" name="products" value="<?php echo $allItems; ?>">
                        <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>  
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>  
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>  
                        </div>
                        <div class="form-group">
                            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
                        </div>
                        <h6 class="text-center lead">Select Payment Mode</h6>
                        <div class="form-group">
                            <select name="pmode" class="form-control">
                                <option value="" selected disabled>-Select Payment Mode-</option>
                                <option value="cod">Cash On Delivery</option>
                                <option value="netbanking">Net Banking</option>
                                <option value="cards">Debit/Credit Cards</option>
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

            //To send user info and order details into orders table and display back those details to the checkout page. For this we use ajax to send a request to the server.
            $("#placeOrder").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: $('form').serialize()+"&action=order",            //The serialize( ) method serializes a set of input elements into a string of data. Also Iam concatenating(joining) extra string there ie., "&action=order"
                    success: function(response){
                        $("#order").html(response);                        
                    }
                });
            });

            load_cart_item_number();
            //To show number of cart items(showing near cart symbol in top of the home page) when clicking Add to cart. For this we need to use ajax to send a request to the server.
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