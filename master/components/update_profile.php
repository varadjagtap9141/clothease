<?php include "connection.php"; 
extract($_POST);
session_start();
if($_FILES['profile_img']['size']>0)
{
    $profile_img=time().".jpg";
    move_uploaded_file($_FILES['profile_img']['tmp_name'],"uploads/".$profile_img);
    $update_profile="UPDATE business_profiles SET profile_img='$profile_img' WHERE business_id='$_SESSION[session_id]'";
    mysqli_query($conn,$update_profile);
}
else
{
    $profile_img="No Image Available";
}
if($_FILES['b_logo']['size']>0)
{
    $b_logo=time().".jpg";
    move_uploaded_file($_FILES['b_logo']['tmp_name'],"uploads/".$b_logo);
    $update_profile="UPDATE business_profiles SET b_logo='$b_logo' WHERE business_id='$_SESSION[session_id]'";
    mysqli_query($conn,$update_profile);
}
else
{
    $b_logo="No logo Available";
}
if($_FILES['signature']['size']>0)
{
    $signature=time().".jpg";
    move_uploaded_file($_FILES['signature']['tmp_name'],"uploads/".$signature);
    $update_profile="UPDATE business_profiles SET signature='$signature' WHERE business_id='$_SESSION[session_id]'";
    mysqli_query($conn,$update_profile);
}
else
{
    $signature="No signature Available";
}
$update_profile="UPDATE business_profiles SET ownerName='$ownerName',shopName='$shopName',mobile='$mobile',gstn='$gstn',shop_address='$shop_address' WHERE business_id='$_SESSION[session_id]'";
$res=mysqli_query($conn,$update_profile);
header("location:../profile.php");
?>