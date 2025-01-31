<?php
include "connection.php";
?>
<!-- size -->
<?php
extract($_POST);

$insert_size="INSERT INTO product_size (product_size, category_id, created_date,stock) VALUES ('$product_size', '$category_id','$created_date',0)";
$result_size=mysqli_query($conn,$insert_size);
if($result_size){
header("location:../products_size.php"); }
?>