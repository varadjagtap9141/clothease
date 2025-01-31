<?php
include "connection.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve POST data
        $supplier_id = $_POST['supplier_id'];
        $purchase_date = $_POST['purchase_date'];
        $total_amount = $_POST['total_amount'];
        $total_gst = $_POST['total_gst'];
        $total_bill = $_POST['total_bill'];
        $paid_amount = $_POST['paid_amount'];
        $balance_amount = $_POST['balance_amount'];
        $product_data = json_decode($_POST['product_data'], true);

        // Check if product_data is valid
        if (empty($product_data) || !is_array($product_data)) {
            throw new Exception("Invalid product data. Please check the input.");
        }

        // Insert Purchase Invoice
        $stmt = $conn->prepare("INSERT INTO purchase_invoices 
            (supplier_id, purchase_date, total_amount, total_gst, total_bill, paid_amount, balance_amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $supplier_id, $purchase_date, $total_amount, $total_gst, $total_bill, $paid_amount, $balance_amount);
        $stmt->execute();
        $invoice_id = $stmt->insert_id; // Get the last inserted invoice ID
        $stmt->close();

        // Prepare statement for inserting products
        $stmt = $conn->prepare("INSERT INTO purchase_invoice_products 
            (purchase_invoice_id, product_id, color, size, price, quantity, total) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($product_data as $product) {
            // Validate product data
            if (empty($product['product_id']) || empty($product['price']) || empty($product['quantity']) || !isset($product['total'])) {
                throw new Exception("Invalid product data entry.");
            }

            // Extract product details
            $product_id = $product['product_id'];
            $color = $product['color'] ?? null;
            $size = $product['size'] ?? null;
            $price = $product['price'];
            $quantity = $product['quantity'];
            $total = $product['total'];

            // Bind parameters and execute statement for products
            $stmt->bind_param("iissdds", $invoice_id, $product_id, $color, $size, $price, $quantity, $total);
            $stmt->execute();

            // // Update product stock
            // $updateStockSql = "UPDATE products SET stock = stock + ? WHERE products_id = ?";
            // $updateStockStmt = $conn->prepare($updateStockSql);
            // $updateStockStmt->bind_param("ii", $quantity, $product_id);
            // $updateStockStmt->execute();
            // $updateStockStmt->close();
        }
        $stmt->close();
        $conn->commit();
        header("Location: ../purchase_list.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>