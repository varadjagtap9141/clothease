<?php include "components/navbar.php"; ?>

<?php
// Fetch customers
$customer = $conn->query("SELECT customer_id, customer_name FROM customer");

// Fetch product list
$product_list = $conn->query(
    "SELECT * FROM products INNER JOIN purchase_invoice_products ON products.products_id = purchase_invoice_products.product_id"
);
?>


<!-- Add Category Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Customer</h1>
                <button type="button" class="btn-close rounded-circle bg-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
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
<script>
document.getElementById('c_date').value = new Date().toISOString().split('T')[0]
</script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="m-0 text-uppercase">Create Sale</h5>
                <hr class="mt-1">
                <div class="d-flex mb-3">
                    <div class="p-2">
                        <select class="form-select form-control" id="customer_id" name="customer_id" required>
                            <option value="" selected>Select customer</option>
                            <?php while ($row = $customer->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['customer_id']) ?>">
                                <?= htmlspecialchars($row['customer_name']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                class='bx bx-plus-circle'></i></button>
                    </div>
                    <div class="ms-auto p-2">
                        <input type="date" name="sale_date" id="today_date" class="form-control" required>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="col-md-12 mt-5 table-responsive">
                    <table class="table table-sm" id="product_table">
                        <thead class="table-primary">
                            <tr>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Unit</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>MRP</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="product_rows">
                            <tr>
                                <td class="px-1 py-2">
                                    <select class="form-select form-control product-select" name="products_id[]">
                                        <option value="" selected>Select Product</option>
                                        <?php while ($row = $product_list->fetch_assoc()): ?>
                                        <option value="<?= $row['products_id'] ?>"
                                            data-code="<?= htmlspecialchars($row['products_code']) ?>"
                                            data-unit="<?= htmlspecialchars($row['product_udm']) ?>"
                                            data-color="<?= htmlspecialchars($row['color']) ?>"
                                            data-size="<?= htmlspecialchars($row['size']) ?>"
                                            data-mrp="<?= htmlspecialchars($row['products_mrp_price']) ?>">
                                            <?= htmlspecialchars($row['products_name']) ?> | Size:
                                            <?= htmlspecialchars($row['size']) ?> | Color:
                                            <?= htmlspecialchars($row['color']) ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td class="px-1 py-2"><input type="text" class="form-control product-code" readonly>
                                </td>
                                <td class="px-1 py-2"><input type="text" class="form-control product-unit" readonly>
                                </td>
                                <td class="px-1 py-2"><input type="text" class="form-control color" readonly></td>
                                <td class="px-1 py-2"><input type="text" class="form-control size" readonly></td>
                                <td class="px-1 py-2"><input type="number" class="form-control product-mrp" min="0"
                                        readonly></td>
                                <td class="px-1 py-2"><input type="number" class="form-control product-quantity"
                                        value="1" min="1"></td>
                                <td class="px-1 py-2"><input type="text" class="form-control product-total" readonly>
                                </td>
                                <td class="px-1 py-2"><button type="button" class="btn btn-danger btn-sm remove-row"><i
                                            class="bi bi-trash3-fill"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-sm mt-2" id="add_row"><i
                            class="bi bi-plus-circle me-2"></i> Add Product</button>
                </div>

                <!-- Summary Table -->
                <div class="col-md-12">
                    <table class="table table-bordered table-sm mt-5">
                        <tr>
                            <th>Total Amount</th>
                            <th>Total GST (28%)</th>
                            <th>Total Bill</th>
                            <th>Paid</th>
                            <th>Balance</th>
                        </tr>
                        <tr>
                            <td><input type="text" id="total_amount" name="sale_total_amount" class="form-control"
                                    readonly></td>
                            <td><input type="text" id="total_gst" name="sale_total_gst" class="form-control" readonly>
                            </td>
                            <td><input type="text" id="total_bill" name="sale_total_bill" class="form-control" readonly>
                            </td>
                            <td><input type="number" id="paid_amount" name="sale_paid_amount" class="form-control"
                                    min="0"></td>
                            <td><input type="text" id="balance_amount" name="sale_balance_amount" class="form-control"
                                    readonly></td>
                        </tr>
                    </table>
                    <form action="components/sale_invoice.php" method="POST" id="saleForm">
                        <input type="hidden" id="customer_id_hidden" name="customer_id">
                        <input type="hidden" id="sale_date_hidden" name="sale_date">
                        <input type="hidden" id="total_amount_hidden" name="total_amount">
                        <input type="hidden" id="total_gst_hidden" name="total_gst">
                        <input type="hidden" id="total_bill_hidden" name="total_bill">
                        <input type="hidden" id="paid_amount_hidden" name="paid_amount">
                        <input type="hidden" id="balance_amount_hidden" name="balance_amount">
                        <input type="hidden" id="product_data" name="product_data">
                        <button type="submit" class="btn btn-primary mt-5 float-end">Add Sale</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    function updateRowTotal(row) {
        const price = parseFloat(row.querySelector(".product-mrp").value) || 0;
        const quantity = parseFloat(row.querySelector(".product-quantity").value) || 1;
        row.querySelector(".product-total").value = (price * quantity).toFixed(2);
        updateSummary();
    }

    function updateRowDetails(selectElement) {
        const row = selectElement.closest("tr");
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        row.querySelector(".product-code").value = selectedOption.getAttribute("data-code") || "";
        row.querySelector(".product-unit").value = selectedOption.getAttribute("data-unit") || "";
        row.querySelector(".color").value = selectedOption.getAttribute("data-color") || "";
        row.querySelector(".size").value = selectedOption.getAttribute("data-size") || "";
        row.querySelector(".product-mrp").value = selectedOption.getAttribute("data-mrp") || "";

        updateRowTotal(row);
    }

    function updateSummary() {
        let totalAmount = 0;
        document.querySelectorAll("#product_rows tr").forEach(row => {
            totalAmount += parseFloat(row.querySelector(".product-total").value) || 0;
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
        document.querySelector("#balance_amount").value = (totalBill - paid).toFixed(2);
    }

    document.querySelector("#product_rows").addEventListener("input", function(e) {
        if (e.target.matches(".product-mrp, .product-quantity")) {
            updateRowTotal(e.target.closest("tr"));
        }
    });

    document.querySelector("#product_rows").addEventListener("change", function(e) {
        if (e.target.matches(".product-select")) {
            updateRowDetails(e.target);
        }
    });

    document.querySelector("#product_rows").addEventListener("click", function(e) {
        if (e.target.closest(".remove-row")) {
            e.target.closest("tr").remove();
            updateSummary();
        }
    });

    document.querySelector("#add_row").addEventListener("click", function() {
        const tableBody = document.querySelector("#product_rows");
        const newRow = tableBody.rows[0].cloneNode(true);

        newRow.querySelectorAll("input").forEach(input => {
            input.value = "";
            if (input.classList.contains("product-quantity")) input.value = 1;
        });

        newRow.querySelector(".product-select").selectedIndex = 0;
        tableBody.appendChild(newRow);
    });

    document.querySelector("#paid_amount").addEventListener("input", updateBalance);

    document.querySelector("#saleForm").addEventListener("submit", function(e) {
        const customerId = document.querySelector("#customer_id").value;
        const saleDate = document.querySelector("#today_date").value;
        const totalAmount = document.querySelector("#total_amount").value;
        const totalGst = document.querySelector("#total_gst").value;
        const totalBill = document.querySelector("#total_bill").value;
        const paidAmount = document.querySelector("#paid_amount").value;
        const balanceAmount = document.querySelector("#balance_amount").value;

        const productData = Array.from(document.querySelectorAll("#product_rows tr")).map(row => {
            return {
                product_id: row.querySelector(".product-select").value,
                color: row.querySelector(".color").value,
                size: row.querySelector(".size").value,
                price: row.querySelector(".product-mrp").value,
                quantity: row.querySelector(".product-quantity").value,
                total: row.querySelector(".product-total").value
            };
        }).filter(item => item.product_id);

        document.querySelector("#customer_id_hidden").value = customerId;
        document.querySelector("#sale_date_hidden").value = saleDate;
        document.querySelector("#total_amount_hidden").value = totalAmount;
        document.querySelector("#total_gst_hidden").value = totalGst;
        document.querySelector("#total_bill_hidden").value = totalBill;
        document.querySelector("#paid_amount_hidden").value = paidAmount;
        document.querySelector("#balance_amount_hidden").value = balanceAmount;
        document.querySelector("#product_data").value = JSON.stringify(productData);
    });
});
</script>

<?php include "components/footer.php"; ?>