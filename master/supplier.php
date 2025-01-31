<?php
include "components/navbar.php";
?>
<div class="row">
    <div class="col-md-12 mb-3">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class='bx bx-plus-circle me-2'></i>Add Supplier</button>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Supplier</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form  method="POST" action="components/save_supplier.php">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="supplier_name" class="form-label">Enter Name</label>
                            <input class="form-control" type="text" id="supplier_name" name="supplier_name"
                                placeholder="Enter Your Name" autofocus required />
                        </div>
                        <div class="col-md-6">
                            <label for="supplier_number" class="form-label">Enter Contact No</label>
                            <input class="form-control" type="number" name="supplier_number" id="supplier_number"
                                placeholder="Enter Contact No" required />
                        </div>
                        <div class="col-md-6">
                            <label for="gst_number" class="form-label">Enter GST No</label>
                            <input class="form-control" type="text" name="gst_number" id="gst_number"
                                placeholder="Enter GST No" required />
                        </div>
                        <div class="col-md-6">
                            <label for="supplier_address" class="form-label">Enter Address</label>
                            <input class="form-control" type="text" name="supplier_address" id="supplier_address"
                                placeholder="Enter Your Address" required />
                        </div>
                        <input type="hidden" id="c_date" name="register_date">
                    </div>
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

<div class="row">
    <div class="col-md-12">
    <div class="card mb-6 table-responsive">
    <div class="card-body pt-4">
    <h5 class="text-uppercase py-2">Supplier List</h5>
    <table class="table table-bordered table-hover table-sm text-center display nowrap" id="example" >
  <thead>
    <tr>
      <th scope="col" class="fw-bold">Sr No</th>
      <th scope="col" class="fw-bold">Supplier Name</th>
      <th scope="col" class="fw-bold">Supplier Mobile</th>
      <th scope="col" class="fw-bold">GST No</th>
      <th scope="col" class="fw-bold">Supplier Address</th>
      <th scope="col" class="fw-bold">Date</th>
      <th scope="col" class="fw-bold">Action</th>
    </tr>
  </thead>
  <tbody>
   <?php
   include "components/connection.php";
   $select_supplier="SELECT * FROM supplier";
   $result=mysqli_query($conn,$select_supplier);
   foreach($result as $key => $data)
   {
    ?>
    <tr>
        <td><?=$key+1?></td>
        <td><?=$data['supplier_name']?></td>
        <td><?=$data['supplier_number']?></td>
        <td><?=$data['gst_number']?></td>
        <td><?=$data['supplier_address']?></td>
        <td><?=$data['register_date']?></td>
        <td><a class="text-decoration-none btn btn-sm btn-primary" href="edit_supplier.php?supplier_id=<?=$data['supplier_id']?>"><i class='bx bx-edit '></i></a> 
            <a class="btn btn-sm btn-danger" onClick="return confirm('Are You Sure?');" href="components/delete_supplier.php?supplier_id=<?=$data['supplier_id']?>"><i class='bx bx-trash'></i></a></td>
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

<?php
include "components/footer.php";
?>
