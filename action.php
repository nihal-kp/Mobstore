<?php           //For storing the data coming from the client side to the database
    session_start();
    require 'config.php';

    if(isset($_POST['pid'])){                   //if any pid is posted from the ajax request then we will get by using this method
        $pid = $_POST['pid'];
        $pname = $_POST['pname'];
        $pprice = $_POST['pprice'];
        $pimage = $_POST['pimage'];
        $pcode = $_POST['pcode'];
        $pqty = 1;                      //by default I'am assigning one quantity of product

        $stmt = $conn->prepare("SELECT product_code FROM cart WHERE product_code=?");
        $stmt->bind_param("s",$pcode);          //This function binds the parameters to the SQL query and tells the database what the parameters are. //The s character tells mysql that the parameter is a string.
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        //if there is no product_code is present in this cart table then this if statement will execute. If product_code is already present in the cart table then else statement will execute
        if(!isset($row['product_code'])){
            $query = $conn->prepare("INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)");
            $query->bind_param("sssiss",$pname,$pprice,$pimage,$pqty,$pprice,$pcode);           //The s character tells mysql that the parameter is a string and i is integer.
            $query->execute();

            echo '<div class="alert alert-success alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Item added to your cart!</strong>
                  </div>';
        }
        else {
            echo '<div class="alert alert-danger alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Item already added to your cart!</strong>
                  </div>';
        }
    }


    //To show number of cart items(showing near cart symbol in top of the home page) when clicking Add to cart
    if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item'){
        $stmt = $conn->prepare("SELECT * FROM cart");
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        echo $rows;
    }


    //To remove item when user clicks remove button
    if(isset($_GET['remove'])){
        $id = $_GET['remove'];

        $stmt = $conn->prepare("DELETE FROM cart WHERE id=?");
        $stmt->bind_param("i",$id);                 //The i character tells mysql that the parameter is a integer
        $stmt->execute();

        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Item removed from the cart!';
        header('location:cart.php');
    }

    //To remove all item when user clicks 'clear cart' button
    if(isset($_GET['clear'])){
        $stmt = $conn->prepare("DELETE FROM cart");
        $stmt->execute();

        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'All Item removed from the cart!';
        header('location:cart.php');
    }

    
    //When user change the quantity by increasing or decreasing the number of input field, then there will update the total price of an item and update in cart table also.
    //If 'qty' is set then the cart table will update. //From the cart table fetch datas and display the total price (because already select method is used in while condition in cart.php).
    if(isset($_POST['qty'])){
        $qty = $_POST['qty'];
        $pid = $_POST['pid'];
        $pprice = $_POST['pprice'];

        $tprice = $qty*$pprice;

        $stmt = $conn->prepare("UPDATE cart SET qty=?, total_price=? WHERE id=?");
        $stmt->bind_param("isi",$qty,$tprice,$pid);
        $stmt->execute();
    }

    //For Checkout process. Insert the user info and order details into orders table and display back those details to the checkout page.
    if(isset($_POST['action']) && isset($_POST['action']) == 'order'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $pmode = $_POST['pmode'];
        $products = $_POST['products'];
        $grand_total = $_POST['grand_total'];

        $stmt = $conn->prepare("INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss",$name,$email,$phone,$address,$pmode,$products,$grand_total);
        $stmt->execute();
        $data = '<div>
                    <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                    <h2 class="text-success">Your Order Placed Successfully!</h2>
                    <h4 class="bg-danger text-light rounded p-2">Items Purchased : '.$products.'</h4>
                    <h4>Your Name : '.$name.'</h4>
                    <h4>Your Email : '.$email.'</h4>
                    <h4>Your Phone : '.$phone.'</h4>
                    <h4>Your Address : '.$address.'</h4>
                    <h4>Total Amount Paid : '.number_format($grand_total,2).'</h4>
                    <h4>Payment Mode : '.$pmode.'</h4>
                  </div>';
        echo $data;
    }
?>