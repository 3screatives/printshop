<?php include 'include/head.php'; ?>

<div class="container-fluid h-100">
    <div class="d-flex justify-content-between h-100 py-3">
        <nav class="navbar show navbar-vertical shadow-l-1 h-100 border-radius-1">
            <div class="container-fluid">
                <a class="navbar-brand pb-3" href="./">
                    <img src="../img/dashboard-logo-new-top-color.png" alt="">
                </a>

                <ul class="navbar-nav">
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
                            <i class="bi bi-record-circle-fill"></i>
                        </a>
                    </li>
                </ul>

                <div class="mt-auto"></div>
                <ul class="navbar-nav user-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="users/manage_users.php">
                            <i class="bi bi-person-square"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="get/logout.php">
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
                            Welcome,<b>&nbsp; <?php echo htmlspecialchars($_SESSION['user_name']); ?></b>
                        </div>
                        <a href="#" id="newOrder" class="btn btn-primary btn-sm mx-1">
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
                        <a href="#" id="newMaterial" class="btn btn-outline-primary btn-sm mx-1">
                            <span class="pe-2">
                                <i class="bi bi-plus"></i>
                            </span>
                            <span>New Material</span>
                        </a>
                    </div>
                </div>
                <div class="search-bar p-3 border-bottom">
                    <!-- <input type="text" class="form-control" name="" id="" placeholder="search order here..."> -->
                    <div class="d-flex align-items-center gap-2">
                        <input type="text" id="orderSearch" class="form-control form-control-sm flex-grow-1"
                            placeholder="Search by order #, business name, or amount">

                        <select id="statusFilter" class="form-select form-select-sm flex-shrink-0" style="width:150px;">
                            <option value="">All</option>
                        </select>

                        <button id="refreshOrders" class="btn btn-outline-secondary btn-sm flex-shrink-0">
                            <i class="bi bi-arrow-repeat"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="data-record p-3">
                    <table class="table table-hover" id="orderListMain">
                        <thead>
                            <tr>
                                <th width="116px">Order #</th>
                                <th width="136px">Order Date</th>
                                <th width="136px">Order Due</th>
                                <th>Client Name</th>
                                <th width="164px">Contact</th>
                                <th width="116px">Amount</th>
                                <th width="164px">Status</th>
                                <th width="164px" class="text-center">Action</th>
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

<?php include 'include/footer.php'; ?>