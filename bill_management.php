<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'create':
                createBill($con);
                break;
            case 'update':
                updateBill($con);
                break;
            case 'delete':
                deleteBill($con);
                break;
        }
    }
}

function createBill($con) {
    $table_no = $_POST['table_no'];
    $status = 'pending';
    $discount = $_POST['discount']??0;
    $tax = $_POST['tax']??0;
    $vat = $_POST['vat']??0;
    $productQty = $_POST['product_qty'];
    $productId = $_POST['product_id'];
    $check_product_query = "SELECT * FROM products WHERE id = ? LIMIT 1";
    $stmt = $con->prepare($check_product_query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product_data = $result->fetch_assoc();
    if(empty($productId) || empty($productQty)) {
        $_SESSION['message'] = "All fields are required.";

        header("Location: create-order.php");
        exit;
    }
    $productPrice = floatval($product_data['price']);
    if ($productPrice == null) {
        $_SESSION['message'] = "Product does not exist.";
        header("Location: create-order.php");
        exit;
    }
    
    $sub_total = $productPrice * $productQty;
    $grand_total = calculateGrandTotal($sub_total, $discount, $tax, $vat);
    $bill_no = rand(1, 999999);
    $stmt = $con->prepare("INSERT INTO Bills (table_no, status, sub_total, discount, tax, vat, grand_total, bill_no, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("issdddds", $table_no, $status, $sub_total, $discount, $tax, $vat, $grand_total,$bill_no);
    $stmt->execute();
    $stmt->close();

    $product_id = $productId;
    $price = $productPrice;
    $qty = $productQty;
    $stmt = $con->prepare("INSERT INTO BillProducts (bill_no, product_id, price, qty) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iidi", $bill_no, $product_id, $price, $qty);
    $stmt->execute();
    $stmt->close();


    $_SESSION['message'] = "Bill created successfully with Bill No: " . $bill_no;
    header("Location: edit-order.php?bill_no=" . $bill_no);
    exit;
}

function updateBill($con) {
    $table_no = $_POST['table_no'];
    $status = 'pending';
    $discount = $_POST['discount']??0;
    $tax = $_POST['tax']??0;
    $vat = $_POST['vat']??0;
    $bill_no = $_GET['bill_no'];
    $productQty = $_POST['product_qty'];

    $productId = $_POST['product_id'];
    $check_product_query = "SELECT * FROM products WHERE id = ? LIMIT 1";
    $stmt = $con->prepare($check_product_query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product_data = $result->fetch_assoc();
    $productPrice = floatval($product_data['price']);
    if(empty($productId) || empty($productQty)) {
        $_SESSION['message'] = "All fields are required.";

        header("Location: edit-order.php?bill_no=" . $bill_no);
        exit;
    }
    if ($productPrice == null) {
        $_SESSION['message'] = "Product does not exist.";
        header("Location: edit-order.php?bill_no=" . $bill_no);
        exit;
    }
    

    $sub_total = $productPrice * $productQty;
    $grand_total = calculateGrandTotal($sub_total, $discount, $tax, $vat);



    $product_id = $productId;
    $price = $productPrice;
    $qty = $productQty;
    $stmt = $con->prepare("INSERT INTO BillProducts (bill_no, product_id, price, qty) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iidi", $bill_no, $product_id, $price, $qty);
    $stmt->execute();
    $stmt->close();


    updateBillTotal($con, $bill_no);


    

    $_SESSION['message'] = "Bill updated successfully ";
    header("Location: edit-order.php?bill_no=" . $bill_no);
    exit;
}

function deleteBill($con) {
    $bill_no = $_POST['bill_no'];

    $stmt = $con->prepare("DELETE FROM BillProducts WHERE bill_no = ?");
    $stmt->bind_param("i", $bill_no);
    $stmt->execute();
    $stmt->close();

    $stmt = $con->prepare("DELETE FROM Bills WHERE bill_no = ?");
    $stmt->bind_param("i", $bill_no);
    $stmt->execute();
    $stmt->close();

    echo "Bill deleted successfully with Bill No: " . $bill_no;
}

function calculateSubTotal($products) {
    $sub_total = 0;
    foreach ($products as $product) {
        $sub_total += $product['price'] * $product['qty'];
    }
    return $sub_total;
}

function calculateGrandTotal($sub_total, $discount, $tax, $vat) {
    $discount_amount = ($sub_total * $discount) / 100;
    $tax_amount = ($sub_total * $tax) / 100;
    $vat_amount = ($sub_total * $vat) / 100;
    return $sub_total - $discount_amount + $tax_amount + $vat_amount;
}

function updateBillTotal($con, $bill_no, $status = 'pending') {
    // Fetch discount, tax, vat, and table_no from Bills table
    $stmt = $con->prepare("SELECT discount, tax, vat, table_no FROM Bills WHERE bill_no = ?");
    $stmt->bind_param("i", $bill_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill_details = $result->fetch_assoc();
    $stmt->close();

    $discount = $bill_details['discount'];
    $tax = $bill_details['tax'];
    $vat = $bill_details['vat'];
    $table_no = $bill_details['table_no'];

    // Calculate the sub_total from BillProducts
    $stmt = $con->prepare("SELECT SUM(price * qty) as sub_total FROM BillProducts WHERE bill_no = ?");
    $stmt->bind_param("i", $bill_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill_data = $result->fetch_assoc();
    $stmt->close();

    $sub_total = $bill_data['sub_total'];

    // Calculate the grand_total
    $grand_total = $sub_total - ($sub_total * ($discount / 100)) + ($sub_total * ($tax / 100)) + ($sub_total * ($vat / 100));

    // Update the Bills table
    $stmt = $con->prepare("UPDATE Bills SET table_no = ?, status = ?, sub_total = ?, discount = ?, tax = ?, vat = ?, grand_total = ?, updated_date = NOW() WHERE bill_no = ?");
    $stmt->bind_param("issddddi", $table_no, $status, $sub_total, $discount, $tax, $vat, $grand_total, $bill_no);
    $stmt->execute();
    $stmt->close();

    return true;
}


?>
