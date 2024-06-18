<?php
session_start();
include '../connection.php';
include '../bill_management.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_qty = $_POST['product_qty'];
    $bill_no = $_POST['bill_no'];

    $sql = "UPDATE BillProducts SET qty = ? WHERE product_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $product_qty, $product_id);

    if ($stmt->execute()) {
        // Redirect back to the page with a success message
        $_SESSION['message'] = "Product updated successfully";
        updateBillTotal($con, $bill_no);
        header("Location: ../edit-order.php?bill_no=" . $bill_no);
        exit();
    } else {
        // Redirect back to the page with an error message
        $_SESSION['message'] = "Error updating product";
        header("Location: ../edit-order.php?bill_no=" . $bill_no);
        exit();
    }
}
?>
