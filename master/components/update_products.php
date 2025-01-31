<?php include "connection.php"; 
extract($_POST);
$update_product="UPDATE products SET category_id='$category_id',brands_id='$brands_id',products_name='$products_name',products_code='$products_code',product_udm='$product_udm',products_mrp_price='$products_mrp_price',products_description='$products_description' WHERE products_id='$products_id'";
$res=mysqli_query($conn,$update_product);
header("location:../products.php");
?>