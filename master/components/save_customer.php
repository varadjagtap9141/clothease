<?php
include "connection.php";
?>
<!-- Customer -->
<?php
extract($_POST);

$insert_customer="INSERT INTO customer(customer_name,customer_number,customer_address,register_date) VALUES ('$customer_name','$customer_number','$customer_address','$register_date')";
$result_customer=mysqli_query($conn,$insert_customer);
if($result_customer){
header("location:../customer.php"); }
?>



