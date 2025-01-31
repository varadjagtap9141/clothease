<?php include("components/navbar.php"); ?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row mb-6">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><i class="bx bx-sm bx-user me-1_5"></i>
                        Business Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="setting.php"><i class="bx bx-sm bxs-cog me-1_5"></i> Setting</a>
                </li>
            </ul>
        </div>
        <div class="card mb-6">
            <!-- settings -->

            <div class="card-body pt-4">
                <h5>Change Password</h5>
                <form action="components/change_password.php" method="POST">
                    <div class="row g-6">
                        <div class="col-md-4">
                            <label for="currunt_password" class="form-label">Currunt Password</label>
                            <input class="form-control" type="text" id="currunt_password" name="currunt_password"
                                placeholder="Enter Currunt Password" autofocus />
                        </div>
                        <div class="col-md-4">
                            <label for="new_password" class="form-label">New Password</label>
                            <input class="form-control" type="text" name="new_password" id="new_password"
                                placeholder="Enter New Password" />
                        </div>
                        <div class="col-md-4">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input class="form-control" type="text" name="confirm_password" id="confirm_password"
                                placeholder="Enter Confirm Password" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Change Password</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
                <div class="col-md-12 mt-5">
                    <strong>Password Requirements:</strong>
                    <li>Minimum 8 characters long - the more, the better</li>
                    <li>At least one lowercase character</li>
                    <li>At least one number, symbol, or whitespace character</li>
                </div>
            </div>
            <!-- /Account -->
        </div>

    </div>
</div>

<?php include("components/footer.php"); ?>