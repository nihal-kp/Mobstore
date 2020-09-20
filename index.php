<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Shopping Cart</title>
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
            <a class="nav-link active" href="#">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="checkout.php">Checkout</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"> <span id="cart-item" class="badge badge-danger"></span></i></a>
        </li>
        </ul>
    </div>
    </nav>

    <div class="container">
        <div  id="message"> </div>
        <div class="row mt-2 pb-3">
            <?php                       // to fetch all the products from the database
                include 'config.php';
                $stmt = $conn->prepare("select * from product");                //select all products and assignining to stmt variable
                $stmt->execute();
                $result = $stmt->get_result();             //storing result to result variable
                while($row = $result->fetch_assoc()){
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card-deck">
                    <div class="card p-2 border-secondary mb-2">
                        <img src="<?php echo $row['product_image']; ?>" class="card-img-top" height="250">
                        <div class="card-body p-1">
                            <h4 class="card-title text-center text-info"> <?php echo $row['product_name']; ?> </h4>
                            <h5 class="card-text text-center text-danger"> ₹ <?php echo number_format($row['product_price'],2); ?> </h5>
                        </div>
                        <div class="card-footer p-1">
                            <!-- Adding product to cart(ie., cart.php) -->
                            <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="<?php echo $row['id']; ?>">
                                <input type="hidden" class="pname" value="<?php echo $row['product_name']; ?>">
                                <input type="hidden" class="pprice" value="<?php echo $row['product_price']; ?>">
                                <input type="hidden" class="pimage" value="<?php echo $row['product_image']; ?>">
                                <input type="hidden" class="pcode" value="<?php echo $row['product_code']; ?>">
                                <button class="btn btn-info btn-block addItemBtn"> <i class="fa fa-shopping-cart"></i>&nbsp;Add to Cart </button>
                            </form>
                        </div>
                    </div>
                </div>    
            </div>
            <?php } ?>
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
            $(".addItemBtn").click(function(e){
                e.preventDefault();                     //this function will stop refreshing page when we click on "Add to cart" button. Sending data to the server without page refreshing.(Send data to the server is using ajax)
                
                //For getting the specific product value of input type hidden
                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();             //get the value from input field of id and assigning to var pid
                var pname = $form.find(".pname").val();         //get the value from input field of product name and assigning to var pname
                var pprice = $form.find(".pprice").val();       // "    "
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();

                //Now we will send a request using ajax to the server
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},        //assigning each variables in ajax and these datas are sending to server.
                    success: function(response){
                        $("#message").html(response);           //html response comeback from the server displays in id="message" ie.,When we click Add to cart displays a success alert
                        window.scrollTo(0,0);                   //When we click any Add to cart button then it will scroll to the top
                        load_cart_item_number();
                    }
                });
            });

            load_cart_item_number();
            //To show number of cart items(showing near cart symbol in top of the home page) when clicking Add to cart. For this we need to  use ajax to send a request to the server.
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