<?php
include "components/navbar.php";
include "components/connection.php";
?>
<?php
extract($_GET);
$select = "
    SELECT 
        products.*, 
        category.category_name, 
        brands.brands_name 
    FROM products 
    LEFT JOIN category ON products.category_id = category.category_id 
    LEFT JOIN brands ON products.brands_id = brands.brands_id 
    WHERE products_id = '$products_id'";
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($result);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0">Details Of Product #CE00<?= $row['products_id'] ?></h5>
                <hr class="mt-1">

                <!-- Product Details -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th class="fw-semibold">Category Name</th>
                            <td><?= $row['category_name'] ?></td>
                        </tr>
                        <tr>
                            <th class="fw-semibold">Brand Name</th>
                            <td><?= $row['brands_name'] ?></td>
                        </tr>
                        <tr>
                            <th class="fw-semibold">Product Name</th>
                            <td><?= $row['products_name'] ?></td>
                        </tr>
                        <tr>
                            <th class="fw-semibold">Product Code</th>
                            <td><?= $row['products_code'] ?></td>
                        </tr>
                        <tr>
                            <th class="fw-semibold">Product UDM</th>
                            <td><?= $row['product_udm'] ?></td>
                        </tr>
                        <tr>
                            <th class="fw-semibold">Product Price</th>
                            <td><?= $row['products_mrp_price'] ?></td>
                        </tr>
                        <tr>
                            <th class="fw-semibold">Product Description</th>
                            <td><?= $row['products_description'] ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Back Button -->
                <div class="text-end mt-4">
                    <a href="products.php" class="btn btn-secondary">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "components/footer.php"; ?>