<?php include("components/navbar.php"); ?>
<?php 
// master session data
$master = $conn->query("SELECT * FROM business_profiles WHERE business_id='$_SESSION[session_id]'");
$res = mysqli_fetch_assoc($master);
?>
<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row mb-6">
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php"><i class="bx bx-sm bx-user me-1_5"></i>
                        Business Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="setting.php"><i class="bx bx-sm bxs-cog me-1_5"></i> Setting</a>
                </li>
            </ul>
        </div>
        <div class="card mb-6">
            <div class="card-body">
                <form action="components/update_profile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="business_id" value="<?=$res['business_id']?>">
                    <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                        <img src="components/uploads/<?=$res['profile_img']?>" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="profile_upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Profile Photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="profile_upload" name="profile_img" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                    </div>
            </div>
            <div class="card-body pt-4">
                <div class="row g-6">
                    <div class="col-md-3">
                        <label for="ownerName" class="form-label">Owner Name</label>
                        <input type="text" class="form-control" id="ownerName" name="ownerName" value="<?=$res['ownerName']?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="shopName" class="form-label">Business Name</label>
                        <input class="form-control" type="text" id="shopName" name="shopName" value="<?=$res['shopName']?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input class="form-control" type="text" id="mobile" name="mobile" value="<?=$res['mobile']?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="gstn" class="form-label">GST No.</label>
                        <input class="form-control" type="text" id="gstn" name="gstn" value="<?=$res['gstn']?>" />
                    </div>
                    <div class="col-md-12">
                        <label for="shop_address">Business Address</label>
                        <textarea class="form-control" type="text" name="shop_address" id="shop_address"><?=$res['shop_address']?></textarea>
                    </div>
                    <div class="col-md-6">
                        <img src="components/uploads/<?=$res['b_logo']?>" class="d-block w-px-150 h-px-auto rounded mb-3" id="b_logo_preview" />
                        <label for="business_logo_upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block"><i class='bx bx-cloud-upload me-2'></i>Business Logo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="business_logo_upload" name="b_logo" class="account-file-input" hidden
                                accept="image/png, image/jpeg" />
                        </label>
                    </div>
                    <div class="col-md-6">
                        <img src="components/uploads/<?=$res['signature']?>" class="d-block w-px-300 h-px-auto rounded mb-3" id="signature_preview" />
                        <label for="signature_upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block"><i class='bx bx-cloud-upload me-2'></i>Signature</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="signature_upload" name="signature" class="account-file-input" hidden
                                accept="image/png, image/jpeg" />
                        </label>
                    </div>
                </div>
                <div class="mt-6">
                    <button onClick="return confirm('Are You Sure?');" type="submit" class="btn btn-primary me-3">Save changes</button>
                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include("components/footer.php"); ?>
