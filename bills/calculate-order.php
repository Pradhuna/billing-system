<?php
session_start();
include('../connection.php');

$bill_no = $_GET['bill_no'];

$sql = "SELECT sub_total FROM bills WHERE bill_no = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $bill_no);
$stmt->execute();
$result = $stmt->get_result();
$sub_total_data = $result->fetch_assoc();
$sub_total = $sub_total_data['sub_total'];

$discount = $_POST['discount'];
$tax = $_POST['tax'];
$vat = $_POST['vat'];

if ($discount > 50 || $tax > 50 || $vat > 50) {
    $_SESSION['message'] = "Discount, Tax, or Vat cannot be greater than 50%";
    header("Location: ../edit-order.php?bill_no=" . $bill_no);
    exit();
}

$discount_amount = ($sub_total * $discount) / 100;
$tax_amount = ($sub_total * $tax) / 100;
$vat_amount = ($sub_total * $vat) / 100;
$grand_total = $sub_total - $discount_amount + $tax_amount + $vat_amount;
var_dump($grand_total);

$sql = "UPDATE bills SET discount = ?, tax = ?, vat = ?, grand_total = ? WHERE bill_no = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ddddd", $discount, $tax, $vat, $grand_total, $bill_no);
$stmt->execute();

if ($stmt->execute()) {
    $_SESSION['message'] = "Order updated successfully";
    header("Location: ../edit-order.php?bill_no=" . $bill_no);
    exit();
} else {
    $_SESSION['message'] = "Error updating order";
    header("Location: ../edit-order.php?bill_no=" . $bill_no);
    exit();
}

$stmt->close();
$conn->close();
?>
