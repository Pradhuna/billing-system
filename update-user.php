<?php
require_once "checkUserAuth.php";
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    if (empty($username) || empty($name) || empty($email) || empty($phone) || empty($gender) || empty($role)) {
        echo "All fields are required.";
        exit();
    }

    $stmt = $con->prepare("UPDATE users SET username = ?, name = ?, email = ?, phone = ?, gender = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $username, $name, $email, $phone, $gender, $role, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'User Updated Successfully.';
        header("Location: users.php");
        exit();
    } else {
        $_SESSION['message'] = 'User Failed to update.';
        header("Location: users.php");
        exit();
    }

    $stmt->close();
}

$con->close();
?>
