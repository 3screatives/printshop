<?php

require_once "db_function.php";

$conn = db_connect();

/* =========================
   DELETE
========================= */
if (isset($_GET['delete'])) {
    execute_query(
        $conn,
        "DELETE FROM ps_material_categories WHERE cat_id = ?",
        "i",
        (int)$_GET['delete']
    );
    header("Location: material_categories.php");
    exit;
}

/* =========================
   ADD / UPDATE
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id      = $_POST['cat_id'] ?? '';
    $name    = $_POST['cat_name'];
    $desc    = $_POST['cat_description'];
    $image   = $_POST['cat_image'];
    $slug    = $_POST['cat_slug'];
    $group   = $_POST['cat_group'];
    $section = $_POST['cat_section'];
    $order   = (int)$_POST['cat_order'];

    if ($id) {
        execute_query(
            $conn,
            "UPDATE ps_material_categories
             SET cat_name=?, cat_description=?, cat_image=?, cat_slug=?,
                 cat_group=?, cat_section=?, cat_order=?
             WHERE cat_id=?",
            "ssssssii",
            $name,
            $desc,
            $image,
            $slug,
            $group,
            $section,
            $order,
            $id
        );
    } else {
        execute_query(
            $conn,
            "INSERT INTO ps_material_categories
             (cat_name, cat_description, cat_image, cat_slug,
              cat_group, cat_section, cat_order)
             VALUES (?,?,?,?,?,?,?)",
            "ssssssi",
            $name,
            $desc,
            $image,
            $slug,
            $group,
            $section,
            $order
        );
    }

    header("Location: material_categories.php");
    exit;
}

/* =========================
   EDIT DATA
========================= */
$edit = null;
if (isset($_GET['edit'])) {
    $row = select_query(
        $conn,
        "SELECT * FROM ps_material_categories WHERE cat_id = ?",
        "i",
        (int)$_GET['edit']
    );
    $edit = $row[0] ?? null;
}

/* =========================
   FETCH ALL
========================= */
$categories = select_query(
    $conn,
    "SELECT * FROM ps_material_categories
     ORDER BY cat_group, cat_section, cat_order"
);

include 'include/head.php';
?>

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
                        <a class="nav-link" href="../users/logout.php">
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
                        <h3 class="text-bold">Material Categories</h3>
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
                        <button class="btn btn-outline-primary btn-sm mx-1" data-bs-toggle="modal"
                            data-bs-target="#categoryModal">
                            <span class="pe-2">
                                <i class="bi bi-plus"></i>
                            </span>
                            <span>Add Category</span>
                        </button>
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
                <div class="data-record px-3">
                    <table class="table table-hover">
                        <thead class="sticky-top">
                            <tr>
                                <th width="96px">ID</th>
                                <th width="196px">Name</th>
                                <th width="">Description</th>
                                <th width="224px">Image</th>
                                <th width="224px">Slug</th>
                                <th width="224px">Group</th>
                                <th width="224px">Section</th>
                                <th width="96px">Order</th>
                                <th width="140px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><?= $cat['cat_id'] ?></td>
                                    <td><?= htmlspecialchars($cat['cat_name']) ?></td>
                                    <td><?= htmlspecialchars($cat['cat_description']) ?></td>
                                    <td><?= htmlspecialchars($cat['cat_image']) ?></td>
                                    <td><?= htmlspecialchars($cat['cat_slug']) ?></td>
                                    <td><?= htmlspecialchars($cat['cat_group']) ?></td>
                                    <td><?= htmlspecialchars($cat['cat_section']) ?></td>
                                    <td><?= $cat['cat_order'] ?></td>
                                    <td>
                                        <a href="?edit=<?= $cat['cat_id'] ?>" class="btn btn-outline-primary btn-sm me-2"
                                            style="color: var(--color-blue)">
                                            <span class="bi bi-pencil"></span>
                                        </a>
                                        <a href="?delete=<?= $cat['cat_id'] ?>" class="btn btn-outline-danger btn-sm"
                                            style="color: var(--color-red)"
                                            onclick="return confirm('Delete this category?')">
                                            <span class="bi bi-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'include/footer.php';
