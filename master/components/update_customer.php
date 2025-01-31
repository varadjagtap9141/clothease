<?php include "connection.php"; ?>
<?php
extract($_POST);
$update_customer="UPDATE customer SET customer_name='$customer_name' , customer_number='$customer_number' , customer_address='$customer_address' WHERE customer_id='$customer_id'";
$res=mysqli_query($conn,$update_customer);
header("location:../customer.php");
?>