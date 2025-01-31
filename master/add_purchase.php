<?php include "components/navbar.php"; ?>
<?php
$supplier = $conn->query("SELECT supplier_id, supplier_name FROM supplier");
// $product_size = $conn->query("SELECT product_size_id, product_size FROM product_size WHERE products.products_id = purchase_invoice_products.product_id;");
$product_data = $conn->query("SELECT * FROM product_size, products WHERE products.category_id = product_size.category_id;");
$products = $conn->query("SELECT * FROM products");
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0 text-uppercase">Create Purchase</h5>
                <hr class="mt-1">
                <div class="d-flex mb-3">
                    <div class="p-2"> <select class="form-select form-control" id="supplier_id" name="supplier_id"
                            aria-label="supplier_id" required>
                            <option value="" selected>Select supplier</option>
                            <?php
                            while ($row = $supplier->fetch_assoc()) {
                                echo "<option value='" . $row['supplier_id'] . "'>" . htmlspecialchars($row['supplier_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="p-2"> <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class='bx bx-plus-circle'></i></button>
                    </div>
                    <div class="ms-auto p-2"><input type="date" name="purchase_date" id="today_date"
                            class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12 mt-5 table-responsive">
                        <table class="table table-sm" id="product_table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Code</th>
                                    <th scope="col">Product UDM</th>
                                    <th scope="col">Product Colour</th>
                                    <th scope="col">Product Size</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">MRP</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="product_rows">
                                <tr>
                                    <td class="px-1 py-2">
                                        <select class="form-select form-control product-select" name="products_id[]">
                                            <option value="" selected>Select Product</option>
                                            <?php
                                            while ($row = $products->fetch_assoc()) {
                                                echo "<option value='" . $row['products_id'] . "' 
                                                data-code='" . htmlspecialchars($row['products_code']) . "' 
                                                data-unit='" . htmlspecialchars($row['product_udm']) . "' 
                                                data-mrp='" . htmlspecialchars($row['products_mrp_price']) . "'>" . htmlspecialchars($row['products_name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td class="px-1 py-2"><input type="text" class="form-control product-code" readonly>
                                    </td>
                                    <td class="px-1 py-2"><input type="text" class="form-control product-unit" readonly>
                                    </td>
                                    <td class="px-1 py-2"><input type="text" class="form-control product-color"></td>
                                    <td class="px-1 py-2">
                                        <select class="form-control product-size">
                                            <option value="" selected>Select Size</option>
                                        </select>
                                    </td>
                                    <td class="px-1 py-2"><input type="number" class="form-control product-price"
                                            min="0"></td>
                                    <td class="px-1 py-2"><input type="number" class="form-control product-mrp"
                                            readonly></td>
                                    <td class="px-1 py-2"><input type="number" class="form-control product-quantity"
                                            value="1" min="1"></td>
                                    <td class="px-1 py-2"><input type="text" class="form-control product-total"
                                            readonly></td>
                                    <td class="px-5 py-2"><button type="button"
                                            class="btn btn-danger btn-sm remove-row"><i
                                                class="bi bi-trash3-fill"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm mt-2" id="add_row"><i
                                class="bi bi-plus-circle me-2"></i> Add Product</button>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm mt-5">
                            <tr>
                                <th>Total Ammount</th>
                                <th>Total GST (28%)</th>
                                <th>Total Bill</th>
                                <th>Paid</th>
                                <th>Balance</th>
                            </tr>
                            <tr>
                                <td><input type="text" id="total_amount" name="purchase_total_amount"
                                        class="form-control" readonly></td>
                                <td><input type="text" id="total_gst" name="purchase_total_gst" class="form-control"
                                        readonly></td>
                                <td><input type="text" id="total_bill" name="purchase_total_bill" class="form-control"
                                        readonly></td>
                                <td><input type="number" id="paid_amount" name="purchase_paid_amount"
                                        class="form-control" min="0"></td>
                                <td><input type="text" id="balance_amount" name="purchase_balance_amount"
                                        class="form-control" readonly></td>
                            </tr>
                        </table>
                        <form action="components/purchase_invoice.php" method="POST" id="purchaseForm">
                            <input type="hidden" id="supplier_id_hidden" name="supplier_id">
                            <input type="hidden" id="purchase_date_hidden" name="purchase_date">
                            <input type="hidden" id="total_amount_hidden" name="total_amount">
                            <input type="hidden" id="total_gst_hidden" name="total_gst">
                            <input type="hidden" id="total_bill_hidden" name="total_bill">
                            <input type="hidden" id="paid_amount_hidden" name="paid_amount">
                            <input type="hidden" id="balance_amount_hidden" name="balance_amount">
                            <input type="hidden" id="product_data" name="product_data">
                            <button type="submit" class="btn btn-primary mt-5 float-end">Add Purchase</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Supplier</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="components/save_supplier.php">
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


<?php include "components/footer.php"; ?>
<!-- fetch product details -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    function updateRowTotal(row) {
        const price = parseFloat(row.querySelector(".product-price").value) || 0;
        const quantity = parseFloat(row.querySelector(".product-quantity").value) || 1;
        row.querySelector(".product-total").value = (price * quantity).toFixed(2);
        updateSummary();
    }

    function updateRowDetails(selectElement) {
        const row = selectElement.closest("tr");
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        row.querySelector(".product-code").value = selectedOption.getAttribute("data-code") || "";
        row.querySelector(".product-unit").value = selectedOption.getAttribute("data-unit") || "";

        // Fetch sizes dynamically
        const productId = selectedOption.value;

        if (productId) {
            fetch(`get_sizes_of_products.php?id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="" selected>Select Size</option>';
                    data.forEach(size => {
                        options +=
                            `<option value="${size.product_size_id}">${size.product_size}</option>`;
                    });
                    row.querySelector(".product-size").innerHTML = options;
                })
                .catch(error => console.error("Error fetching sizes:", error));
        } else {
            row.querySelector(".product-size").innerHTML = '<option value="" selected>Select Size</option>';
        }

        row.querySelector(".product-mrp").value = selectedOption.getAttribute("data-mrp") || "";
        updateSummary();
    }


    function updateSummary() {
        let totalAmount = 0;
        const rows = document.querySelectorAll("#product_rows tr");

        rows.forEach(row => {
            const total = parseFloat(row.querySelector(".product-total").value) || 0;
            totalAmount += total;
        });

        const gst = (totalAmount * 0.28).toFixed(2);
        const totalBill = (totalAmount + parseFloat(gst)).toFixed(2);

        document.querySelector("#total_amount").value = totalAmount.toFixed(2);
        document.querySelector("#total_gst").value = gst;
        document.querySelector("#total_bill").value = totalBill;

        updateBalance();
    }

    function updateBalance() {
        const totalBill = parseFloat(document.querySelector("#total_bill").value) || 0;
        const paid = parseFloat(document.querySelector("#paid_amount").value) || 0;
        const balance = (totalBill - paid).toFixed(2);

        document.querySelector("#balance_amount").value = balance;
    }

    document.getElementById("product_rows").addEventListener("input", function(e) {
        const target = e.target;
        if (target.classList.contains("product-price") || target.classList.contains(
                "product-quantity")) {
            updateRowTotal(target.closest("tr"));
        }
    });

    document.getElementById("product_rows").addEventListener("change", function(e) {
        if (e.target.classList.contains("product-select")) {
            updateRowDetails(e.target);
        }
    });

    document.getElementById("product_rows").addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-row")) {
            e.target.closest("tr").remove();
            updateSummary();
        }
    });

    document.getElementById("add_row").addEventListener("click", function() {
        const tableBody = document.getElementById("product_rows");
        const newRow = tableBody.rows[0].cloneNode(true);

        newRow.querySelectorAll("input").forEach(input => {
            input.value = "";
            if (input.classList.contains("product-quantity")) {
                input.value = 1;
            }
        });

        newRow.querySelector(".product-select").selectedIndex = 0;
        tableBody.appendChild(newRow);
    });

    document.querySelector("#paid_amount").addEventListener("input", updateBalance);
});
</script>

<!--  -->
<script>
document.querySelector("#purchaseForm").addEventListener("submit", function(e) {
    const supplierId = document.querySelector("#supplier_id").value;
    const purchaseDate = document.querySelector("#today_date").value;
    const totalAmount = document.querySelector("#total_amount").value;
    const totalGst = document.querySelector("#total_gst").value;
    const totalBill = document.querySelector("#total_bill").value;
    const paidAmount = document.querySelector("#paid_amount").value;
    const balanceAmount = document.querySelector("#balance_amount").value;

    const productData = [];
    document.querySelectorAll("#product_rows tr").forEach(row => {
        const productId = row.querySelector(".product-select").value;
        const color = row.querySelector(".product-color").value;
        const size = row.querySelector(".product-size").value;
        const price = row.querySelector(".product-price").value;
        const quantity = row.querySelector(".product-quantity").value;
        const total = row.querySelector(".product-total").value;

        if (productId) {
            productData.push({
                product_id: productId,
                color,
                size,
                price,
                quantity,
                total
            });
        }
    });

    document.querySelector("#supplier_id_hidden").value = supplierId;
    document.querySelector("#purchase_date_hidden").value = purchaseDate;
    document.querySelector("#total_amount_hidden").value = totalAmount;
    document.querySelector("#total_gst_hidden").value = totalGst;
    document.querySelector("#total_bill_hidden").value = totalBill;
    document.querySelector("#paid_amount_hidden").value = paidAmount;
    document.querySelector("#balance_amount_hidden").value = balanceAmount;
    document.querySelector("#product_data").value = JSON.stringify(productData);
});
</script>
