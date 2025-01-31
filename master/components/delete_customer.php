<!-- Delete Customer -->
<?php
include "connection.php";
?>
<?php
extract($_GET);
$delete_customer="DELETE FROM customer WHERE customer_id ='$customer_id'";
$del_res=mysqli_query($conn,$delete_customer);
if($del_res)
{
header("location:../customer.php");
}
?>