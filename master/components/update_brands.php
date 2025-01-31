<?php include "connection.php"; 
extract($_POST);
if($_FILES['brands_image']['size']>0)
{
    $brands_image=time().".jpg";
    move_uploaded_file($_FILES['brands_image']['tmp_name'],"uploads/".$brands_image);
    $update_brands="UPDATE brands SET brands_image='$brands_image' WHERE brands_id='$brands_id'";
    mysqli_query($conn,$update_brands);
}
else
{
    $brands_image="";
}

$update_brands="UPDATE brands SET brands_name='$brands_name' WHERE brands_id='$brands_id'";
$res=mysqli_query($conn,$update_brands);
header("location:../brands.php");
?>