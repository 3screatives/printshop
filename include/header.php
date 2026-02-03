<?php
$sql = "
    SELECT
        c.cat_id,
        c.cat_name,
        c.cat_group,
        c.cat_section,
        c.cat_slug,
        COUNT(DISTINCT m.mat_type) AS type_count,
        MIN(m.mat_type) AS mat_type
    FROM ps_material_categories c
    LEFT JOIN ps_material_categories_map cm ON cm.cat_id = c.cat_id
    LEFT JOIN ps_materials m ON m.mat_id = cm.mat_id
    GROUP BY c.cat_id
    ORDER BY c.cat_group ASC, c.cat_section ASC, c.cat_order ASC
";
$categories = select_query($conn, $sql);

$menu = [];

foreach ($categories as $cat) {

    if ((int)$cat['type_count'] > 1) {
        $cat['mat_type'] = 'mixed';
    } elseif (empty($cat['mat_type'])) {
        // fallback based on group (safe in your data)
        $cat['mat_type'] = (stripos($cat['cat_group'], 'Digital') !== false)
            ? 'digital'
            : 'large';
    }

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
                        +1 (737) 381-2357
                    </div>
                    <!-- <a class="btn-cart" data-bs-toggle="offcanvas" href="#offcanvasCart" role="button"
                        aria-controls="offcanvasCart" id="cart_summary">
                        0 Item(s) | $0.00 <i class="bi bi-cart3 ms-2"></i>
                    </a> -->
                    <a class="btn-cart" id="cart_summary" href="view-cart.php">
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
                <ul class="navbar-nav me-auto ps-lg-0" style="padding-left: 0.15rem">

                    <?php foreach ($menu as $groupName => $sections): ?>
                        <li class="nav-item dropdown dropdown-hover position-static">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <?= htmlspecialchars($groupName) ?>
                            </a>
                            <div class="dropdown-menu w-100 mt-0">
                                <div class="container">
                                    <div class="mega-masonry my-4">

                                        <?php foreach ($sections as $sectionName => $items): ?>
                                            <ul class="list-box list-unstyled">

                                                <?php if ($sectionName): ?>
                                                    <li class="fw-bold text-uppercase mb-2">
                                                        <?= htmlspecialchars($sectionName) ?>
                                                    </li>
                                                <?php endif; ?>

                                                <?php foreach ($items as $cat): ?>
                                                    <li>
                                                        <a class="dropdown-item px-0"
                                                            href="shop/<?= htmlspecialchars($cat['mat_type']) ?>/<?= htmlspecialchars($cat['cat_slug']) ?>">
                                                            <?= htmlspecialchars($cat['cat_name']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>

                                            </ul>
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
                <ul class="navbar-nav h-100">
                    <?php if (!empty($_SESSION['client_id']) && $_SESSION['client_user_type'] === 'client'): ?>
                        <li class="nav-item h-100">
                            <a class="nav-link" href="./users/my-orders">My Orders</a>
                        </li>
                        <li class="nav-item dropdown dropdown-hover position-static user h-100">
                            <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="userinfo" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person fs-5 me-2"></i>
                                <?php echo htmlspecialchars($_SESSION['contact_name'] ?? ''); ?>
                            </a>
                            <div class="dropdown-menu mt-0" aria-labelledby="userinfo">
                                <a href="users/dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                                <a href="users/profile.php" class="list-group-item list-group-item-action">Profile
                                    Settings</a>
                                <a href="users/logout.php" class="list-group-item list-group-item-action">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item h-100">
                            <a class="nav-link" href="users/login.php">Login</a>
                        </li>
                        <li class="nav-item h-100">
                            <a class="nav-link" href="users/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>
</header>