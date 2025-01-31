<?php
include 'components/connection.php'; // Include your database connection

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Query to get the category_id of the selected product
    $product_query = $conn->prepare("SELECT category_id FROM products WHERE products_id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product_query_result = $product_query->get_result();

    if ($product_query_result->num_rows > 0) {
        $product_row = $product_query_result->fetch_assoc();
        $category_id = $product_row['category_id'];

        // Query to get the sizes from product_size table based on category_id
        $size_query = $conn->prepare("SELECT product_size_id, product_size FROM product_size WHERE category_id = ?");
        $size_query->bind_param("i", $category_id);
        $size_query->execute();
        $size_query_result = $size_query->get_result();

        $sizes = [];
        while ($row = $size_query_result->fetch_assoc()) {
            $sizes[] = $row;
        }

        echo json_encode($sizes);
    } else {
        echo json_encode([]);
    }
}
?>
