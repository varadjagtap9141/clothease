<?php include("components/navbar.php"); ?>
<?php

if (isset($_POST['login'])) {
    // Login 
    $_SESSION['toast_message'] = 'Login successful!';
    header('Location: dashboard.php');
    exit;
} elseif (isset($_POST['logout'])) {
    // Logout 
    session_destroy();
    session_start();
    $_SESSION['toast_message'] = 'Logout successful!';
    header('Location: ../index.php');
    exit;
}
?>

<?php
extract($_POST);
$master = $conn->query("SELECT * FROM business_profiles WHERE business_id='$_SESSION[session_id]'");
$res=mysqli_fetch_assoc($master);

// total purchase
$purchase = "SELECT SUM(total_bill) AS sum_purchase 
        FROM purchase_invoices 
        WHERE MONTH(purchase_date) = MONTH(CURRENT_DATE()) 
          AND YEAR(purchase_date) = YEAR(CURRENT_DATE())";
$result = $conn->query($purchase);
$totalPurchaseSum = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPurchaseSum = $row['sum_purchase'] ?? 0; // Handle null case
}

// total Sale
$sale = "SELECT SUM(total_bill) AS sum_sale 
        FROM sales 
        WHERE MONTH(sale_date) = MONTH(CURRENT_DATE()) 
          AND YEAR(sale_date) = YEAR(CURRENT_DATE())";
$result = $conn->query($sale);
$totalSaleSum = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalSaleSum = $row['sum_sale'] ?? 0;
}

// today sale
$todaySale = "SELECT SUM(total_bill) AS today_sale FROM sales WHERE DATE(sale_date) = CURDATE();";
$result = $conn->query($todaySale);
$sumTodaySale = 0;
if ($result && $row = $result->fetch_assoc()) {
    $sumTodaySale = $row['today_sale'] ?? 0;
}

// total Payment In
$PaymentIn = "SELECT SUM(balance_amount) AS Total_paymentIn FROM sales";
$result = $conn->query($PaymentIn);
$totalPaymentIn = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPaymentIn = $row['Total_paymentIn'] ?? 0; 
}
// total Payment Out
$PaymentOut = "SELECT SUM(balance_amount) AS total_paymentOut FROM purchase_invoices";
$result = $conn->query($PaymentOut);
$totalPaymentOut = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalPaymentOut = $row['total_paymentOut'] ?? 0; 
}


// 
$OrderStat = "
SELECT DATE_FORMAT(s.sale_date, '%Y-%m') AS sale_month, c.category_name, 
       COUNT(p.products_id) AS sale_count, SUM(s.total_bill) AS total_bill 
FROM sales s 
JOIN sale_products ps ON s.sale_id = ps.sale_id 
JOIN products p ON ps.product_id = p.products_id 
JOIN category c ON p.category_id = c.category_id 
GROUP BY sale_month, c.category_name 
ORDER BY sale_month, c.category_name;
";

$result = $conn->query($OrderStat);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
?>

<div class="row">
    <div class="col-xxl-7 mb-6 order-0">
        <div class="card">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Welcome! <?=$res['ownerName']?> 🎉</h5>
                        <p class="mb-6">
                            You have done 72% more sales today.<br />Check your new badge in your profile.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="../assets/img/illustrations/man-with-laptop.png" height="175" class="scaleX-n1-rtl"
                            alt="View Badge User" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Purchase</p>
                        <h4 class="card-title mb-3">&#8377; <?php echo number_format($totalPurchaseSum, 2); ?></h4>
                        <small class="text-success fw-medium">This Month</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Sales</p>
                        <h4 class="card-title mb-3">&#8377; <?php echo number_format($totalSaleSum, 2); ?></h4>
                        <small class="text-success fw-medium">This Month</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Revenue -->
    <!-- <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="col-lg-8">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Total Revenue</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="totalRevenue" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded bx-lg text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalRevenue">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div id="totalRevenueChart" class="px-3"></div>
                </div>
                <div class="col-lg-4 d-flex align-items-center">
                    <div class="card-body px-xl-9">
                        <div class="text-center mb-6">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary">
                                    <script>
                                        document.write(new Date().getFullYear() - 1);
                                    </script>
                                </button>
                                <button type="button"
                                    class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);">2021</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">2020</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">2019</a></li>
                                </ul>
                            </div>
                        </div>

                        <div id="growthChart"></div>
                        <div class="text-center fw-medium my-6">62% Company Growth</div>

                        <div class="d-flex gap-3 justify-content-between">
                            <div class="d-flex">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-2 bg-label-primary"><i
                                            class="bx bx-dollar bx-lg text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>
                                        <script>
                                            document.write(new Date().getFullYear() - 1);
                                        </script>
                                    </small>
                                    <h6 class="mb-0">$32.5k</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-2 bg-label-info"><i
                                            class="bx bx-wallet bx-lg text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>
                                        <script>
                                            document.write(new Date().getFullYear() - 2);
                                        </script>
                                    </small>
                                    <h6 class="mb-0">$41.2k</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--/ Total Revenue -->
    <div class="col-12 col-md-12 col-lg-12 col-xxl-12 order-3 order-md-2">
        <div class="row">
            <div class="col-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/paypal.png" alt="paypal" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Payment In</p>
                        <h4 class="card-title mb-3 text-danger">&#8377; <?php echo number_format($totalPaymentIn, 2); ?><i class="bx bx-down-arrow-alt"></i></h4>
                    </div>
                </div>
            </div>
            <div class="col-3 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Payment Out</p>
                        <h4 class="card-title mb-3 text-success">&#8377; <?php echo number_format($totalPaymentOut, 2); ?><i class="bx bx-up-arrow-alt"></i></h4>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title mb-6">
                                    <h5 class="text-nowrap mb-1">Today's Sale</h5>
                                    <span class="badge bg-label-warning" id="todayDate"></span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h4 class="mb-0">&#8377; <?php echo number_format($sumTodaySale, 2); ?></h4>
                                </div>
                            </div>
                            <div id="profileReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  const currentDate = new Date();
  const day = String(currentDate.getDate()).padStart(2, '0');
  const month = String(currentDate.getMonth() + 1).padStart(2, '0'); 
  const year = currentDate.getFullYear();
  const formattedDate = `${day} -${month} -${year}`;
  document.getElementById('todayDate').textContent = formattedDate;
</script>
<div class="row">
    <!-- Order Statistics -->
    <!-- <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
                <h5 class="mb-1 me-2">Order Statistics</h5>
                <p class="card-subtitle">&#8377; 
                    <?php 
                    $totalSales = array_sum(array_column($data, 'total_bill'));
                    echo number_format($totalSales) . " Total Sales";
                    ?>
                </p>
            </div>
                <div class="dropdown">
                    <button class="btn text-muted p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-6">
                    <div class="d-flex flex-column align-items-center gap-1">
                        <h3 class="mb-1">8,258</h3>
                        <small>Total Orders</small>
                    </div>
                    <div id="orderStatisticsChart"></div>
                </div>
                <ul class="p-0 m-0">
                <?php 
                foreach ($data as $row) {
                    $categoryIcon = ""; // Add appropriate icons for categories
                    $labelClass = "bg-label-primary"; // Default label class
                    switch ($row['category_name']) {
                        case 'SWEATER':
                            $categoryIcon = "bx bxs-t-shirt";
                            $labelClass = "bg-label-primary";
                            break;
                        case 'SHIRT':
                            $categoryIcon = "bx-closet";
                            $labelClass = "bg-label-success";
                            break;
                        case 'T-SHIRT':
                            $categoryIcon = "bx-home-alt";
                            $labelClass = "bg-label-info";
                            break;
                        case 'JEANS':
                            $categoryIcon = "bx-football";
                            $labelClass = "bg-label-secondary";
                            break;
                    }
                ?>
                <li class="d-flex align-items-center mb-5">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded <?php echo $labelClass; ?>">
                            <i class="bx <?php echo $categoryIcon; ?>"></i>
                        </span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0"><?php echo $row['category_name']; ?></h6>
                            <small>Total Orders: <?php echo $row['sale_count']; ?></small>
                        </div>
                        <div class="user-progress">
                            <h6 class="mb-0">&#8377; <?php echo number_format($row['total_bill']); ?></h6>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
            </div>
        </div>
    </div> -->
    <!--/ Order Statistics -->

    <!-- Expense Overview -->
    <!-- <div class="col-md-6 col-lg-4 order-1 mb-6">
        <div class="card h-100">
            <div class="card-header nav-align-top">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income"
                            aria-selected="true">
                            Income
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab">Expenses</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab">Profit</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                        <div class="d-flex mb-6">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                            </div>
                            <div>
                                <p class="mb-0">Total Balance</p>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1">$459.10</h6>
                                    <small class="text-success fw-medium">
                                        <i class="bx bx-chevron-up bx-lg"></i>
                                        42.9%
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div id="incomeChart"></div>
                        <div class="d-flex align-items-center justify-content-center mt-6 gap-3">
                            <div class="flex-shrink-0">
                                <div id="expensesOfWeek"></div>
                            </div>
                            <div>
                                <h6 class="mb-0">Income this week</h6>
                                <small>$39k less than last week</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--/ Expense Overview -->

    <!-- Transactions -->
    <!-- <div class="col-md-6 col-lg-4 order-2 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Transactions</h5>
                <div class="dropdown">
                    <button class="btn text-muted p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Paypal</small>
                                <h6 class="fw-normal mb-0">Send money</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">+82.6</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Wallet</small>
                                <h6 class="fw-normal mb-0">Mac'D</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">+270.69</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/chart.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Transfer</small>
                                <h6 class="fw-normal mb-0">Refund</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">+637.91</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/cc-primary.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Credit Card</small>
                                <h6 class="fw-normal mb-0">Ordered Food</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">-838.71</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Wallet</small>
                                <h6 class="fw-normal mb-0">Starbucks</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">+203.33</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded" />
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">Mastercard</small>
                                <h6 class="fw-normal mb-0">Ordered Food</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="fw-normal mb-0">-92.45</h6>
                                <span class="text-muted">USD</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> -->
    <!--/ Transactions -->
</div>

<?php include("components/footer.php"); ?>