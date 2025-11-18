<?php
include 'ps-admin/db_function.php';

$conn = db_connect();

$sql = "
    SELECT cat_id, cat_name, cat_group
    FROM ps_material_categories
    ORDER BY cat_group ASC, cat_name ASC
";

$categories = select_query($conn, $sql);

// Group by cat_group
$groups = [];
foreach ($categories as $cat) {
    $groups[$cat['cat_group']][] = $cat;
}
?>

<header>
    <div class="top-bar">
        <div class="container h-100">
            <div class="h-100 d-flex align-items-center justify-content-between">
                <a class="navbar-brand" href="./">
                    <img src="img/logo-new-top-color.png" alt="STMA Printing">
                </a>
                <div class="d-flex align-items-center flex-grow-1 ms-3">
                    <div class="search-bar me-2">
                        <div class="input-group h-100">
                            <input type="text" class="form-control" placeholder="Search for products"
                                aria-label="Search for products" aria-describedby="basic-addon1">
                            <button class="input-group-text" id="basic-addon1">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="me-2 contact-no">
                        +1 (210) 672-6006 Ext:109
                    </div>
                    <a class="btn-cart" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample">
                        0 Item(s) | $0.00 <i class="bi bi-cart3 ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg" style="padding: 0px;">
        <div class="container">
            <button data-mdb-button-init class="navbar-toggler px-0" type="button" data-mdb-collapse-init
                data-mdb-target="#navbarExampleOnHover" aria-controls="navbarExampleOnHover" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">

                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <!-- Dynamic Product Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Products
                        </a>

                        <ul class="dropdown-menu">

                            <?php foreach ($groups as $groupName => $items): ?>
                                <li>
                                    <h6 class="dropdown-header">
                                        <?= htmlspecialchars($groupName) ?>
                                    </h6>
                                </li>

                                <?php foreach ($items as $cat): ?>
                                    <li>
                                        <a class="dropdown-item"
                                            href="order/<?php echo strtolower(str_replace(' ', '-', $cat['cat_name'])); ?>/<?php echo $cat['cat_id'] ?>">
                                            <?= htmlspecialchars($cat['cat_name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </li>

                    <!-- Get a Quote -->
                    <li class="nav-item">
                        <a class="nav-link" href="./get-a-quote">Get a Quote</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>