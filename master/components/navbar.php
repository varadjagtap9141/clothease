<?php include("connection.php") ?>
<?php
session_start();

if (!isset($_SESSION["session_id"])) {
    header('location:../index.php');
    exit();
}
// master session data
$master = $conn->query("SELECT * FROM business_profiles WHERE business_id='$_SESSION[session_id]'");
$res=mysqli_fetch_assoc($master);

// today sale count
$todaySaleCount = "SELECT COUNT(*) AS today_sale_count FROM sales WHERE DATE(sale_date) = CURDATE();";
$result = $conn->query($todaySaleCount);
$sumTodaySaleCount = 0;
if ($result && $row = $result->fetch_assoc()) {
    $sumTodaySaleCount = $row['today_sale_count']?? 0;
}
?>
<!doctype html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/" data-template="vertical-menu-template-free" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>ClothEase CRM</title>

    <meta name="description" content="ClothEase By A2Z IT HUB PVT LTD" />

    <!-- data table css -->
    <link rel="stylesheet" href="datatables/table-dataTables.css">
    <link rel="stylesheet" href="datatables/buttons-dataTables.css">

    <!-- invoice assets -->
    <!-- <link rel="stylesheet" href="invoice/css/app.min.css">
    <link rel="stylesheet" href="invoice/css/style.css"> -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/a2z_logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- sweet alert / toast -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
    <style>
        .drop-zone {
            border: 2px dashed #ccc;
            border-radius: 5px;
            text-align: center;
            padding: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .drop-zone.dragover {
            background-color: #f0f0f0;
        }

        .drop-zone span {
            font-size: 16px;
            color: #999;
        }

        #b_logo {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="dashboard.php" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="../assets/img/icons/brands/ClothEase_logo2.png" alt="" height="auto" width="180">
                        </span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item  ">
                        <a href="dashboard.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                            <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
                            <span class="badge rounded-pill bg-danger ms-auto"><?php echo number_format($sumTodaySaleCount,); ?></span>
                        </a>

                    </li>

                    <!-- Items -->
                    <li class="menu-item active-menu">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div class="text-truncate" data-i18n="Items">Items</div>
                        </a>

                        <ul class="menu-sub">
                        <li class="menu-item">
                                <a href="products.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Products">Products</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="products_size.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Products Size">Products Size</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="category.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Category">Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="brands.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Brands">Brands</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- purchase -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-purchase-tag"></i>
                            <div class="text-truncate" data-i18n="Purchase">Purchase</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="add_purchase.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add Purchase">Add Purchase</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="purchase_list.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Purchase Orders">Purchase Orders</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- sale -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-cart"></i>
                            <div class="text-truncate" data-i18n="Purchase">Sale</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="add_sale.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add Sale">Add Sale</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="sale_list.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Sale Invoice">Sale Invoice</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Supplier -->
                    <li class="menu-item">
                        <a href="supplier.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-store-alt"></i>
                            <div class="text-truncate" data-i18n="Supplier">Supplier</div>
                        </a>
                    </li>

                    <!-- Customer -->
                    <li class="menu-item">
                        <a href="customer.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div class="text-truncate" data-i18n="Customer">Customer</div>
                        </a>
                    </li>

                    <!-- stock -->
                    <li class="menu-item">
                        <a href="stock.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-bar-chart-square"></i>
                            <div class="text-truncate" data-i18n="Stock">Stock</div>
                        </a>
                    </li>
                    <!-- <li class="menu-item">
                        <a href="reports.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-report"></i>
                            <div class="text-truncate" data-i18n="Reports">Reports</div>
                        </a>
                    </li> -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-report"></i>
                            <div class="text-truncate" data-i18n="Purchase">Reports</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="products_reports.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add Sale">Products</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="sale_reports.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Sale Invoice">Sale</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="purchase_reports.php" class="menu-link">
                                    <div class="text-truncate" data-i18n="Sale Invoice">Purchase</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Support Team -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Support</span></li>
                    <li class="menu-item">
                        <a href="support.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-support"></i>
                            <div class="text-truncate" data-i18n="Support Team">Support Team</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="bx bx-menu bx-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item lh-1 me-4">
                                <a href="add_sale.php" class="btn btn-danger btn-sm sale">
                                    <i class='bx bx-plus-circle me-2'></i>Add Sale
                                </a>
                            </li>
                            <li class="nav-item lh-1 me-4">
                                <a href="add_purchase.php" class="btn btn-primary btn-sm purchase">
                                    <i class='bx bx-plus-circle me-2'></i>Add Purchase
                                </a>
                            </li>
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="components/uploads/<?=$res['profile_img']?>" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="components/uploads/<?=$res['profile_img']?>" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0"><?=$res['ownerName']?></h6>
                                                    <small class="text-muted"><?=$res['role']?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="profile.php">
                                            <i class="bx bx-user bx-md me-3"></i><span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="setting.php"> <i
                                                class="bx bx-cog bx-md me-3"></i><span>Settings</span> </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="components/logout.php">
                                            <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">