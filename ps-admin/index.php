<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>STMA Printing</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" />
    <link href="css/dashboard.css" rel="stylesheet" rel="preload" as="style" />
</head>

<body>
    <div class="container-fluid h-100">
        <div class="container h-100">
            <div class="d-flex justify-content-between h-100 py-3">
                <nav class="navbar show navbar-vertical shadow-l-1 h-100 border-radius-1">
                    <div class="container-fluid">
                        <a class="navbar-brand pb-3" href="#">
                            <img src="../img/stma-print-logo.jpg" alt="">
                        </a>

                        <ul class="navbar-nav">
                            <!-- <li class="nav-item">
                                <a class="nav-link active" href="./">
                                    <i class="bi bi-house"></i>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link active" href="./">
                                    <i class="bi bi-card-checklist"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clients.php">
                                    <i class="bi bi-people"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="materials.php">
                                    <i class="bi bi-circle"></i>
                                </a>
                            </li>
                        </ul>

                        <div class="mt-auto"></div>
                        <ul class="navbar-nav user-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-person-square"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="db/logout.php">
                                    <i class="bi bi-box-arrow-left"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main class="content-wrap">
                    <div class="main-content w-100 h-100 shadow-l-1 border-radius-1">
                        <div class="content-head px-4 py-3 border-bottom d-flex justify-content-between">
                            <div class="heading">
                                <h3 class="text-bold">Orders</h3>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="user me-3">
                                    Welcome,<b>&nbsp; Username</b>
                                </div>
                                <a href="#" id="newOrder" class="btn btn-outline-primary btn-sm mx-1">
                                    <span class=" pe-2">
                                        <i class="bi bi-plus"></i>
                                    </span>
                                    <span>New Order</span>
                                </a>
                                <a href="#" id="newMember" class="btn btn-outline-primary btn-sm mx-1">
                                    <span class=" pe-2">
                                        <i class="bi bi-plus"></i>
                                    </span>
                                    <span>New Member</span>
                                </a>
                            </div>
                        </div>
                        <div class="search-bar p-3 border-bottom">
                            <input type="text" class="form-control" name="" id="" placeholder="search order here...">
                        </div>
                        <div class="data-record p-3">
                            <table class="table" id="orderListMain">
                                <thead>
                                    <tr>
                                        <th width="10%">Order #</th>
                                        <th width="10%">Order Date</th>
                                        <th width="30%">Client Name</th>
                                        <th width="10%">Amount</th>
                                        <th width="20%">Status</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <?php include 'view-order.php'; ?>
    <?php include 'create-order.php'; ?>
    <?php include 'order-designer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>