<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
            <a class="nav-link" href="#">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="checkout.php">Checkout</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="cart.php"><i class="fa fa-shopping-cart"> <span id="cart-item" class="badge badge-danger"></span></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
        </li>
        </ul>
    </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="display:<?php if(isset($_SESSION['showAlert'])){echo $_SESSION['showAlert'];} 
                                        else {echo 'none';} unset($_SESSION['showAlert']); ?>;" 
                    class="alert alert-success alert-dismissible mt-3">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} unset($_SESSION['message']); ?></strong> 
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    <h4 class="text-center text-info m-0">Products in your cart!</h4>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th><a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fa fa-trash"></i>&nbsp;&nbsp;Clear Cart</a> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require 'config.php';
                                $stmt = $conn->prepare("SELECT * FROM cart");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $grand_total = 0;
                                while($row = $result->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <input type="hidden" class="pid" value="<?php echo $row['id']; ?>">  
                                <td><img src="<?php echo $row['product_image']; ?>" width="50"></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td>₹ <?php echo number_format($row['product_price'],2); ?></td>
                                <input type="hidden" class="pprice" value="<?php echo $row['product_price']; ?>">
                                <td><input type="number" class="form-control itemQty" value="<?php echo $row['qty']; ?>" style="width:75px;"></td>
                                <td>₹ <?php echo number_format($row['total_price'],2); ?></td>
                                <td><a href="action.php?remove=<?php echo $row['id']; ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fa fa-trash"></i></td>
                            </tr>
                            <?php
                                $grand_total += $row['total_price'];
                                }
                            ?>
                            <tr>
                                <td colspan="3"><a href="index.php" class="btn btn-success">Continue Shopping</a> </td>
                                <td colspan="2"><b>Grand Total</b></td>
                                <td><b>₹ <?php echo number_format($grand_total,2); ?></b></td>
                                <td><a href="checkout.php" class="btn btn-info <?php if ($grand_total>1){ echo "";} else { echo "disabled";} ?>"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Checkout</a> </td>
                            </tr>
                        </tbody>
                    </table>
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

            $(".itemQty").on('change',function(){ 
                var $el = $(this).closest('tr'); 

                var pid = $el.find(".pid").val();
                var pprice = $el.find(".pprice").val();
                var qty = $el.find(".itemQty").val();

                location.reload(true);

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    cache: false,
                    data: {qty:qty,pid:pid,pprice:pprice},
                    success: function(response){    
                        console.log(response);
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