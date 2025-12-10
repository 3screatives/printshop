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
                        <a class="nav-link" href="./">
                            <i class="bi bi-card-checklist"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="clients.php">
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
                            <span>New client</span>
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
                    <input type="text" class="form-control form-control-sm flex-grow-1" name="" id=""
                        placeholder="search order here...">
                </div>
                <div class="data-record p-3">
                    <table class="table" id="clientsTable">
                        <thead>
                            <tr>
                                <th width="64px">C. ID</th>
                                <th width="96px">STMA ID</th>
                                <th width="164px">B. Name</th>
                                <th width="316px">Address</th>
                                <th width="164px">C. Name</th>
                                <th width="164px">Phone</th>
                                <th width="264px">E-Mail</th>
                                <th width="136px">Tax ID</th>
                                <th width="116px">Since</th>
                                <th width="96px" class="text-center">Action</th>
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