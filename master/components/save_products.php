<?php
include "connection.php";

echo "<pre>";
print_r($_POST);
echo "</pre>";

?>
<?php
extract($_POST);
$insert_products="INSERT INTO products (category_id, brands_id, products_name, 
products_code, product_udm, products_mrp_price, products_description, created_date
) VALUES ('$category_id','$brands_id','$products_name','$products_code','$product_udm', '$products_mrp_price','$products_description','$created_date')";
$result_products=mysqli_query($conn,$insert_products);
if($result_products){
header("location:../products.php");}
?>
?>