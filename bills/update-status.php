<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $bill_no = $_GET['bill_no'];
    if (!empty($bill_no)) {
    $status = 'paid';
    $update_query = "UPDATE Bills SET status = ? WHERE bill_no = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("si", $status, $bill_no);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "Order Status Changed to Paid.";
    header("Location: ../orders.php");
    exit();
    } else {
        $_SESSION['message'] = "Bill No or Status is missing.";
        header("Location: ../edit-order.php?bill_no=" . $bill_no);
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: ../edit-order.php");
    exit();
}
?>
