<?php
include 'connection.php';
require_once "checkUserAuth.php";

if(isset($_POST['check_viewbtn'])){
    $username = mysqli_real_escape_string($con, $_POST['user_name']);
    $userQuery = "SELECT * FROM users WHERE username='$username'";
    $userResult = mysqli_query($con, $userQuery);

    if ($userResult) {
        if ($userRow = mysqli_fetch_assoc($userResult)) {
            echo '
            <h5> UserName:'.$userRow['username'].'</h5>
            <h5> Name: '.$userRow['name'].'</h5>
            <h5> Email:'.$userRow['email'].'</h5>
            <h5> Password:'.$userRow['password'].'</h5>
            <h5> Gender:'.$userRow['gender'].'</h5>
            ';
        } else {
            echo 'User not found';
        }
    } else {
        echo 'Query failed: ' . mysqli_error($con);
    }
}


if(isset($_POST['check_updatebtn'])){
    $username = mysqli_real_escape_string($con, $_POST['user_name']);
    $userQuery = "SELECT * FROM users WHERE username='$username'";
    $userResult = mysqli_query($con, $userQuery);

    if ($userResult) {
        if ($userRow = mysqli_fetch_assoc($userResult)) {
            // Return JSON response containing user data
            echo json_encode($userRow);
        } else {
            echo 'User not found';
        }
    } else {
        echo 'Query failed: ' . mysqli_error($con);
    }
}

if(isset($_POST['update_user'])){
    $userId = mysqli_real_escape_string($con, $_POST['user_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $password = mysqli_real_escape_string($con, $_POST['password']); // You might want to hash this password again
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    $query = "UPDATE users SET name='$name', email='$email', phone='$phone', username='$username', gender='$gender', password='$password', role='$role' WHERE id='$id'";
    
    $result = mysqli_query($con, $query);
    
    if ($result) {
        // Update successful
        // You may redirect the user to another page or display a success message
    } else {
        // Update failed
        echo "Error: " . mysqli_error($con);
    }
}
?>
