<?php 
include "components/navbar.php"; 
include "components/connection.php"; 
?>

<div class="row">
    <div class="col-md-12 mb-3">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class='bx bx-plus-circle me-2'></i>Add Size</button>
    </div>
</div>

<!-- Fetch categories -->
<?php
$category = $conn->query("SELECT * FROM category");
?>

<!-- Add category Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-uppercase" id="exampleModalLabel">Add New Size</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="components/save_size.php">
                    <input type="hidden" id="c_date" name="created_date">
                    <div class="row">
                    <div class="col-md-6 mt-2">
                            <label for="category_id" class="form-label">Select Product</label>
                            <select class="form-select" id="category_id" name="category_id" aria-label="category_id">
                                <option value="" selected>Select Product</option>
                                <?php
                                while ($row = $category->fetch_assoc()) {
                                    echo "<option value='" . $row['category_id'] . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="product_size" class="form-label">category Size</label>
                            <input class="form-control" type="text" id="product_size" name="product_size"
                                placeholder="Enter product Size" required />
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Size</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Auto Date script -->
<script>
document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>

<!-- Product Size List -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6 table-responsive">
            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Product Size List</h5>
                <table class="table table-bordered table-hover table-sm  display nowrap w-100" id="example"
                    >
                    <thead>
                        <tr>
                            <th scope="col" class="fw-bold">Sr No</th>
                            <th scope="col" class="fw-bold">Product</th>
                            <th scope="col" class="fw-bold">Product Size</th>
                            <th scope="col" class="fw-bold">Date</th>
                            <th scope="col" class="fw-bold">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "components/connection.php";
                        extract($_GET);
                        $select_product_size = "SELECT ps.product_size_id, ps.product_size, ps.created_date, c.category_name
                                                FROM product_size ps
                                                JOIN category c ON ps.category_id = c.category_id";
                        $product_size_result = mysqli_query($conn, $select_product_size);
                        foreach ($product_size_result as $key => $data) {
                            ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $data['category_name'] ?></td>
                            <td><?= $data['product_size'] ?></td>
                            <td><?= $data['created_date'] ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="edit_product_size.php?product_size_id=<?= $data['product_size_id'] ?>"><i
                                        class='bx bx-edit'></i></a>
                                <a class="btn btn-danger btn-sm" onClick="return confirm('Are You Sure?');"
                                    href="components/delete_product_size.php?product_size_id=<?= $data['product_size_id'] ?>"><i
                                        class='bx bx-trash'></i></a>
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