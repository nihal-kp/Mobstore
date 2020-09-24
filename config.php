<?php
    $conn = new mysqli("sql110.epizy.com","epiz_26806643","Zw2IXmCGE7","epiz_26806643_mobstore");
    if($conn->connect_error){               //to check if database connection is error
        die("connection failed!".$conn->connect_error);
    }
?>