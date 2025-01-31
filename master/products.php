<?php
include "components/navbar.php";
include "components/connection.php";
?>

<div class="row">
    <div class="col-md-12 mb-3">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class='bx bx-plus-circle me-2'></i>Add Products</button>
    </div>
</div>
<!-- Fetch categories -->
<?php
$category = $conn->query("SELECT category_id, category_name FROM category");
$brands = $conn->query("SELECT brands_id, brands_name FROM brands");
?>
<!-- Add products Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Products</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="components/save_products.php" enctype="multipart/form-data">
                    <input type="hidden" id="c_date" name="created_date">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <label for="category_id" class="form-label">Select Category</label>
                            <select class="form-select" id="category_id" name="category_id" aria-label="category_id">
                                <option value="" selected>Select Category</option>
                                <?php
                                while ($row = $category->fetch_assoc()) {
                                    echo "<option value='" . $row['category_id'] . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="product_brands" class="form-label">Select Brands</label>
                            <select class="form-select" id="product_brands" name="brands_id"
                                aria-label="product_brands">
                                <option value="" selected>Select Brands</option>
                                <?php
                                while ($row = $brands->fetch_assoc()) {
                                    echo "<option value='" . $row['brands_id'] . "'>" . htmlspecialchars($row['brands_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="products_name" class="form-label">Enter Products Name</label>
                            <input class="form-control" type="text" id="products_name" name="products_name"
                                placeholder="Enter products name" required />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="products_code" class="form-label">Enter Products Code</label>
                            <input class="form-control" type="text" id="products_code" name="products_code"
                                placeholder="Enter products code" required />
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="product_udm" class="form-label">Product Unit</label>
                            <select class="form-select" id="product_udm" name="product_udm" aria-label="product unit">
                                <option selected>Select Products Units</option>
                                <option value="Piece">Piece</option>
                                <option value="Pack">Pack</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="products_mrp_price" class="form-label">Enter Products MRP</label>
                            <input class="form-control" type="text" id="products_mrp_price" name="products_mrp_price"
                                placeholder="Enter products MRP" required />
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="products_description" class="form-label">Enter Products Description</label>
                            <textarea class="form-control" id="products_description" name="products_description"
                                rows="3" placeholder="Enter products description" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Auto Date script -->
<script>
    document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>

<!-- Products List -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6 table-responsive">
            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Products List</h5>
                <table class="table table-bordered table-hover table-sm  display nowrap w-100" id="example">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-bold">Sr No</th>
                            <th scope="col" class="fw-bold">Products Name</th>
                            <th scope="col" class="fw-bold">Brand</th>
                            <th scope="col" class="fw-bold">Products Code</th>
                            <th scope="col" class="fw-bold">Products UNIT</th>
                            <th scope="col" class="fw-bold">Products MRP</th>
                            <th scope="col" class="fw-bold">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "components/connection.php";
                        extract($_GET);
                        $select_products = "
                                            SELECT products.*, brands.brands_name 
                                            FROM products 
                                            INNER JOIN brands 
                                            ON products.brands_id = brands.brands_id";
                        $cate_result = mysqli_query($conn, $select_products);
                        foreach ($cate_result as $key => $data) {
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><a
                                        href="view_product.php?products_id=<?= $data['products_id'] ?>"><?= $data['products_name'] ?></a>
                                </td>
                                <td><?= $data['brands_name'] ?></td>
                                <td><?= $data['products_code'] ?></td>
                                <td><?= $data['product_udm'] ?></td>
                                <td>&#8377;.<?= $data['products_mrp_price'] ?></td>
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="edit_product.php?products_id=<?= $data['products_id'] ?>"><i
                                            class='bx bx-edit'></i></a>
                                    <a class="btn btn-sm btn-danger" onClick="return confirm('Are You Sure?');"
                                        href="components/delete_product.php?products_id=<?= $data['products_id'] ?>"><i
                                            class='bx bx-trash '></i></a>
                                </td>
                            </tr>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "components/footer.php"; ?>