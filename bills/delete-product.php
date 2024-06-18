<?php
include '../connection.php';
require  '../bill_management.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bill_no = $_POST['bill_no'];
    $product_id = $_POST['product_id'];

    if (!empty($bill_no) && !empty($product_id)) {
        // Delete the product from BillProducts table
        $stmt = $con->prepare("DELETE FROM BillProducts WHERE bill_no = ? AND product_id = ?");
        $stmt->bind_param("ii", $bill_no, $product_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Product deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete product.";
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Bill No or Product ID is missing.";
    }

    header("Location: ../edit-order.php?bill_no=" . $bill_no);
    exit();
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: ../edit-order.php");
    exit();
}
?>
