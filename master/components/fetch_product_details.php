<?php
include "connection.php"; // Include your database connection file

if (isset($_GET['products_id'])) {
    $products_id = intval($_GET['products_id']);

    $query = $conn->prepare("SELECT product_color, product_size FROM purchase_invoice_products WHERE products_id = ?");
    $query->bind_param("i", $products_id);
    $query->execute();
    $result = $query->get_result();

    $query = $conn->prepare("SELECT * FROM product_size WHERE products_id = ?");
    $query->bind_param("i", $products_id);
    $query->execute();
    $sizes = $query->get_result();

    $product_details = [];
    while ($row = $result->fetch_assoc()) {
        $product_details[] = $row;
    }

    

    echo json_encode(['success' => true, 'data' => $product_details, 'sizes'=>$sizes]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
