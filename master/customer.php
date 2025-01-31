<?php
include "components/navbar.php";
?>
<div class="row">
    <div class="col-md-12 mb-3">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class='bx bx-plus-circle me-2'></i>Add Customer</button>
    </div>
</div>

<!-- Add Category Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Customer</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="components/save_customer.php">
                <input type="hidden" id="c_date" name="register_date">
                    <div class="row">
                    <div class="col-md-4">
                            <label for="customer_name" class="form-label">Enter Name</label>
                            <input class="form-control" type="text" id="customer_name" name="customer_name"
                                placeholder="Enter Your Name" autofocus required />
                        </div>
                        <div class="col-md-4">
                            <label for="customer_number" class="form-label">Enter Contact No</label>
                            <input class="form-control" type="number" name="customer_number" id="customer_number"
                                placeholder="Enter Contact No" required />
                        </div>
                        <div class="col-md-4">
                            <label for="customer_address" class="form-label">Enter Address</label>
                            <input class="form-control" type="text" name="customer_address" id="customer_address"
                                placeholder="Enter Your Address" required />
                        </div>
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
    <h5 class="text-uppercase py-2">Customer List</h5>
    <table class="table table-bordered table-hover table-sm text-center display nowrap" id="example" >
  <thead>
    <tr>
      <th scope="col" class="fw-bold">Sr No</th>
      <th scope="col" class="fw-bold">Customer Name</th>
      <th scope="col" class="fw-bold">Customer Mobile</th>
      <th scope="col" class="fw-bold">Customer Address</th>
      <th scope="col" class="fw-bold">Date</th>
      <th scope="col" class="fw-bold">Action</th>
    </tr>
  </thead>
  <tbody>
   <?php
   include "components/connection.php";
   $select="SELECT * FROM customer";
   $result=mysqli_query($conn,$select);
   foreach($result as $key => $data)
   {
    ?>
    <tr>
        <td><?=$key+1?></td>
        <td><?=$data['customer_name']?></td>
        <td><?=$data['customer_number']?></td>
        <td><?=$data['customer_address']?></td>
        <td><?=$data['register_date']?></td>
        <td><a class="text-decoration-none btn btn-sm btn-primary" href="edit_customer.php?customer_id=<?=$data['customer_id']?>"><i class='bx bx-edit'></i></a> 
            <a class="btn btn-sm btn-danger" onClick="return confirm('Are You Sure?');" href="components/delete_customer.php?customer_id=<?=$data['customer_id']?>"><i class='bx bx-trash'></i></a></td>
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
