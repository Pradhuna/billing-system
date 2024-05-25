<?php

    $con = mysqli_connect("localhost","root","","restaurant_billing_system");
    if(!$con){
        die(mysqli_error($con));
    }

?>