<?php
    $conn = new mysqli("localhost","root","","mobiles_cart");
    if($conn->connect_error){               //to check if database connection is error
        die("connection failed!".$conn->connect_error);
    }
?>