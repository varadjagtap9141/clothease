<?php include "components/navbar.php";?>
<div class="row">
    <div class="col-md-12 mb-3">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class='bx bx-plus-circle me-2'></i>Add Category</button>
    </div>
</div>
<!-- Add Category Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="components/save_category.php">
                    <label for="category_name" class="form-label">Enter New Category</label>
                    <input class="form-control" type="text" id="category_name" name="category_name"
                        placeholder="Enter New Category" autofocus required />
                    <input type="hidden" id="c_date" name="register_date">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Auto Date script -->
<script>
document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>

<!-- Category List -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6 table-responsive">
            <div class="card-body pt-4">
                <h5 class="text-uppercase py-2">Category List</h5>
                <table class="table table-bordered table-hover table-sm text-center display nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-bold">Sr No</th>
                            <th scope="col" class="fw-bold">Category Name</th>
                            <th scope="col" class="fw-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
   include "components/connection.php";
   extract($_GET);
   $select_category="SELECT * FROM category";
   $cate_result=mysqli_query($conn,$select_category);
   foreach($cate_result as $key => $data)
   {
    ?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$data['category_name']?></td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="edit_category.php?category_id=<?=$data['category_id']?>"><i
                                        class='bx bx-edit'></i></a>
                                <a class="btn btn-sm btn-danger" onClick="return confirm('Are You Sure?');"
                                    href="components/delete_category.php?category_id=<?=$data['category_id']?>"><i
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

<?php include "components/footer.php";?>