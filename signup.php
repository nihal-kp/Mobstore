<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            <a class="nav-link" href="checkout.php">Checkout</a>
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
    <div class= "container">
        <div class="col-6 mx-auto mt-5">
            <div class="">
                <h3 class="text-center">Create New Account</h3>
                <form action="" method ="post">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required>  
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>  
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" required>  
                </div>
                <div class="form-group">
                    <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
                </div>
                <div class="form-group">
                    <input type="password" name="psw" class="form-control" placeholder="Enter Password" required>  
                </div>
                <div class="form-group mx-5">
                    <input type="submit" name="signup" value="Sign Up" class="btn btn-success btn-block">
                </div>
                </form>
            </div>
                <p>Already a member? <a href="signup.php"><b>Log In</b></a></p>
        </div>
    </div>

    <?php
        require 'config.php';

        if(isset($_POST['signup']))
        {
            $name=$_POST['name'];
            $email=$_POST['email'];
            $phone=$_POST['phone'];
            $address=$_POST['address'];
            $password=$_POST['psw'];

            $insert="INSERT INTO customer (name,email,phone,address,password) VALUES ('$name','$email','$phone','$address','$password')";

            mysqli_query($conn,$insert);
            echo '<script type="text/javascript">'; 
            echo 'alert("Registered Successfully");'; 
            echo 'window.location.href = "login.php";';
            echo '</script>';
        }     
    ?>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>   
</body>
</html>