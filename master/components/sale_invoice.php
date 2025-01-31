<?php
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract and sanitize POST data
    $customer_id = $_POST['customer_id'] ?? null;
    $sale_date = $_POST['sale_date'] ?? date('Y-m-d');
    $total_amount = $_POST['total_amount'] ?? 0;
    $total_gst = $_POST['total_gst'] ?? 0;
    $total_bill = $_POST['total_bill'] ?? 0;
    $paid_amount = $_POST['paid_amount'] ?? 0;
    $balance_amount = $_POST['balance_amount'] ?? 0;
    $product_data = json_decode($_POST['product_data'], true);

    if (!$customer_id || empty($product_data)) {
        die("Invalid data submitted.");
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert sale record into `sales` table
        $stmt = $conn->prepare("INSERT INTO sales (customer_id, sale_date, total_amount, total_gst, total_bill, paid_amount, balance_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isddddd', $customer_id, $sale_date, $total_amount, $total_gst, $total_bill, $paid_amount, $balance_amount);
        $stmt->execute();
        $sale_id = $stmt->insert_id;

        // Insert product details into `sale_products` table
        $stmt = $conn->prepare("INSERT INTO sale_products (sale_id, product_id, color, size, price, quantity, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($product_data as $product) {
            $stmt->bind_param(
                'iissdii',
                $sale_id,
                $product['product_id'],
                $product['color'],
                $product['size'],
                $product['price'],
                $product['quantity'],
                $product['total']
            );
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();
        echo "Sale recorded successfully!";
        header("Location: ../sale_list.php");
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request method.";
}
?>
