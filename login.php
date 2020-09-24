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
            <a class="nav-link active" href="login.php">Log In</a>
        </li>
        </ul>
    </div>
    </nav>
    <div class= "container">
        <div class="col-lg-6 col-md-8 col-10 mx-auto mt-5">
            <div class="">
                <h3 class="text-center">Login Now</h3>
                <form action="" method ="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>  
                </div>
                <div class="form-group">
                    <input type="password" name="psw" class="form-control" placeholder="Enter Password" required>  
                </div>
                <div class="form-group mx-5">
                    <input type="submit" name="login" value="Log In" class="btn btn-success btn-block">
                </div>
                </form>
            </div>
                <p><a href="#" class="text-danger text-decoration-none">Forgot Password?</a></p>
            <p>Don’t have an account? <a href="signup.php"><b>Sign up</b></a></p>
        </div>
        <div class="col-lg-5 col-md-9 col-12 pt-lg-4 pt-md-3 pt-3 mx-auto">
            <p class="text-center"> 
                © 2020 Mobstore. All Rights Reserved | Designed by <a href="#" target="_blank">Dot KP</a>
            </p>
        </div>
    </div>

    <?php
    session_start();
    require 'config.php';
   
    if(isset($_POST['login']))
    {
        $email= $_POST['email'];
        $password= $_POST['psw'];
        $sel="select * from customer where email='$email' and password='$password'";
        $q = mysqli_query($conn,$sel);
        if($row = mysqli_fetch_array($q))
        { 
            $_SESSION['ss']=$row[0];
            header("location:index.php");
        }
        else
        {
            echo "Username and Password is incorrect!!";
        }
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