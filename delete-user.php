<?php
    include "connection.php";
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $deleteQuery = "DELETE FROM users WHERE id = $id";
        $deleteResult = mysqli_query($con, $deleteQuery);
        if($deleteResult) {
            header("Location: users.php");
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
?>
