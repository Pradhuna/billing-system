<?php
    include 'connection.php';

    $query = "DELETE FROM products Where id = '$_GET[id]'";
    $result = mysqli_query($con, $query);
    if($result){
        header('location:insert.php');
    }
    else{
        die(mysqli_error($con));
    }

?>