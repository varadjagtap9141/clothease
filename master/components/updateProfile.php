<?php
include("connection.php"); 

// echo "<pre>";
// print_r($_POST);
// print_r($_FILES);
// echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ownerName = mysqli_real_escape_string($conn, $_POST['ownerName']);
    $shopName = mysqli_real_escape_string($conn, $_POST['shopName']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $gstn = mysqli_real_escape_string($conn, $_POST['gstn']);
    $shop_address = mysqli_real_escape_string($conn, $_POST['shop_address']);
    
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
        $profile_img = $_FILES['profile_img'];
        $profile_img_name = time() . "_" . basename($profile_img['name']);
        $profile_img_tmp_name = $profile_img['tmp_name'];
        $profile_img_target = "uploads/" . $profile_img_name;
        
        if (in_array(strtolower(pathinfo($profile_img_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
            if ($profile_img['size'] <= 8000000) { // Limit size to 800K
                move_uploaded_file($profile_img_tmp_name, $profile_img_target);
            } else {
                echo "File size is too large.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, or PNG are allowed.";
            exit;
        }
    } else {
        $profile_img_target = ''; 
    }

    // Business Logo Upload
    if (isset($_FILES['b_logo']) && $_FILES['b_logo']['error'] == 0) {
        $b_logo = $_FILES['b_logo'];
        $b_logo_name = time() . "_" . basename($b_logo['name']);
        $b_logo_tmp_name = $b_logo['tmp_name'];
        $b_logo_target = "uploads/" . $b_logo_name;
        
        // Check file type and size
        if (in_array(strtolower(pathinfo($b_logo_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
            if ($b_logo['size'] <= 8000000) {
                move_uploaded_file($b_logo_tmp_name, $b_logo_target);
            } else {
                echo "Business logo file size is too large.";
                exit;
            }
        } else {
            echo "Invalid file type for logo. Only JPG, JPEG, or PNG are allowed.";
            exit;
        }
    } else {
        $b_logo_target = '';
    }

    // Signature Upload
    if (isset($_FILES['signature']) && $_FILES['signature']['error'] == 0) {
        $signature = $_FILES['signature'];
        $signature_name = time() . "_" . basename($signature['name']);
        $signature_tmp_name = $signature['tmp_name'];
        $signature_target = "uploads/" . $signature_name;
        
        if (in_array(strtolower(pathinfo($signature_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
            if ($signature['size'] <= 8000000) {
                move_uploaded_file($signature_tmp_name, $signature_target);
            } else {
                echo "Signature file size is too large.";
                exit;
            }
        } else {
            echo "Invalid file type for signature. Only JPG, JPEG, or PNG are allowed.";
            exit;
        }
    } else {
        $signature_target = ''; 
    }

    // Insert 
    $query = "INSERT INTO business_profiles (ownerName, shopName, mobile, gstn, shop_address, profile_img, b_logo, signature) 
              VALUES ('$ownerName', '$shopName', '$mobile', '$gstn', '$shop_address', '$profile_img_target', '$b_logo_target', '$signature_target')";

    if (mysqli_query($conn, $query)) {
        echo "Profile updated successfully!";
        header('location:../dashboard.php');
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
