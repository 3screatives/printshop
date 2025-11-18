<?php
include 'ps-admin/db_function.php';

$conn = db_connect();

// Fetch all categories with group and section
$sql = "
    SELECT cat_id, cat_name, cat_group, cat_section, cat_slug
    FROM material_category
    ORDER BY cat_group ASC, cat_section ASC, cat_order ASC
";
$categories = select_query($conn, $sql);

// Group categories by cat_group and cat_section
$menu = [];
foreach ($categories as $cat) {
    $menu[$cat['cat_group']][$cat['cat_section']][] = $cat;
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
                    <?php foreach ($menu as $groupName => $sections): ?>
                        <li class="nav-item dropdown dropdown-hover position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <?= htmlspecialchars($groupName) ?>
                            </a>
                            <div class="dropdown-menu w-100 mt-0">
                                <div class="container">
                                    <div class="row my-4">
                                        <?php foreach ($sections as $sectionName => $items): ?>
                                            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                                <div class="list-group list-group-flush">
                                                    <?php if ($sectionName): ?>
                                                        <p class="mb-0 list-group-item text-uppercase fw-bold">
                                                            <?= htmlspecialchars($sectionName) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php foreach ($items as $cat): ?>
                                                        <a href="order/<?= htmlspecialchars($cat['cat_slug']) ?>/<?= $cat['cat_id'] ?>"
                                                            class="list-group-item list-group-item-action">
                                                            <?= htmlspecialchars($cat['cat_name']) ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>

                    <!-- Get a Quote -->
                    <li class="nav-item">
                        <a class="nav-link" href="./get-a-quote">Get a Quote</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>