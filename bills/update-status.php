<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bill_no = $_GET['bill_no'];
    $status = $_POST['status'];
    if (!empty($bill_no) && !empty($status)) {
        if ($status == 'pending' || $status == 'paid') {
            $stmt = $con->prepare("UPDATE bills SET status = ? WHERE bill_no = ?");
            $stmt->bind_param("si", $status, $bill_no);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Status updated successfully";
                header("Location: ../orders.php?bill_no=" . $bill_no);
                exit();
            } else {
                $_SESSION['message'] = "Failed to update status";
                header("Location: ../edit-order.php?bill_no=" . $bill_no);
                exit();
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "Invalid status. Only 'pending' or 'paid' are allowed.";
            header("Location: ../edit-order.php?bill_no=" . $bill_no);
            exit();
        }
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
