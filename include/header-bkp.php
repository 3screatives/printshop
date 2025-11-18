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
            <div class="collapse navbar-collapse" id="navbarExampleOnHover">
                <ul class="navbar-nav me-auto ps-lg-0" style="padding-left: 0.15rem">
                    <li class="nav-item dropdown dropdown-hover position-static">
                        <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="largeFormat"
                            role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            Large Format
                        </a>
                        <div class="dropdown-menu w-100 mt-0" aria-labelledby="largeFormat">
                            <div class="container">
                                <div class="row my-4">
                                    <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Signs & Banners</p>
                                            <a href="order/poster"
                                                class="list-group-item list-group-item-action">Posters</a>
                                            <a href="order/yard"
                                                class="list-group-item list-group-item-action">Yard/Lawn
                                                Signs</a>
                                            <a href="order/foamboard"
                                                class="list-group-item list-group-item-action">Foam Board
                                                Signs</a>
                                            <a href="order/coroplast"
                                                class="list-group-item list-group-item-action">Coroplast
                                                Signs</a>
                                            <a href="order/banner"
                                                class="list-group-item list-group-item-action">Banners</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Window Graphics</p>
                                            <a href="order/window-viny"
                                                class="list-group-item list-group-item-action">Storefront
                                                Window
                                                Vinyl</a>
                                            <a href="order/window-vinyl-clear"
                                                class="list-group-item list-group-item-action">Storefront
                                                Window
                                                Vinyl Clear</a>
                                            <a href="order/window-perforated"
                                                class="list-group-item list-group-item-action">Window
                                                Perforated
                                                Vinly</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3 mb-md-0">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Banner Stands</p>
                                            <a href="order/x-stand"
                                                class="list-group-item list-group-item-action">X-Stands</a>
                                            <a href="order/retractable-stand"
                                                class="list-group-item list-group-item-action">Retractable Banner
                                                Stand</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Sidewalk Signs</p>
                                            <a href="order/a-sign"
                                                class="list-group-item list-group-item-action">A-Signs</a>
                                        </div>
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Wall Art</p>
                                            <a href="order/canvas" class="list-group-item list-group-item-action">Canvas
                                                Print</a>
                                            <a href="order/clear-acrylic"
                                                class="list-group-item list-group-item-action">Clear Acrylic
                                                Signs</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-hover position-static">
                        <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="digitalPrinting"
                            role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            Digital Printing
                        </a>
                        <div class="dropdown-menu w-100 mt-0" aria-labelledby="digitalPrinting">
                            <div class="container">
                                <div class="row my-4">
                                    <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Business Cards</p>
                                            <a href="order/businesscards"
                                                class="list-group-item list-group-item-action">
                                                Standard Business card
                                            </a>
                                        </div>
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">ID Badges & Cards</p>
                                            <a href="order/badges" class="list-group-item list-group-item-action">
                                                Custom ID Badge
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Stationary</p>
                                            <a href="order/Letterheads" class="list-group-item list-group-item-action">
                                                Letterhead
                                            </a>
                                            <a href="order/greeting-cards"
                                                class="list-group-item list-group-item-action">
                                                Greeting Cards
                                            </a>
                                            <a href="order/postcards" class="list-group-item list-group-item-action">
                                                Postcards
                                            </a>
                                            <a href="order/envelopes" class="list-group-item list-group-item-action">
                                                Envelopes
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3 mb-md-0">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Marketing Material
                                            </p>
                                            <a href="order/flyers" class="list-group-item list-group-item-action">
                                                Flyers
                                            </a>
                                            <a href="order/postcards" class="list-group-item list-group-item-action">
                                                Postcards
                                            </a>
                                            <a href="order/booklets" class="list-group-item list-group-item-action">
                                                Booklet
                                            </a>
                                            <a href="order/poster" class="list-group-item list-group-item-action">
                                                Poster
                                            </a>
                                            <a href="order/tickets" class="list-group-item list-group-item-action">
                                                Tickets
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="list-group list-group-flush">
                                            <p class="mb-0 list-group-item text-uppercase fw-bold">Envelopes</p>
                                            <a href="order/tags" class="list-group-item list-group-item-action">
                                                Tags
                                            </a>
                                            <a href="order/stickers" class="list-group-item list-group-item-action">
                                                Stickers
                                            </a>
                                            <a href="order/labels" class="list-group-item list-group-item-action">
                                                labels
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Graphic Design</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link thm-btn" href="#">
                            <span>Get a Quote</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav h-100">
                    <?php if (!empty($_SESSION['customer_id'])): ?>
                        <li class="nav-item h-100">
                            <a class="nav-link" href="./users/my-orders">My Orders</a>
                        </li>
                        <li class="nav-item dropdown dropdown-hover position-static user h-100">
                            <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="userinfo" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person fs-5 me-2"></i>
                                <?php echo htmlspecialchars($_SESSION['customer_name'] ?? ''); ?>
                            </a>
                            <div class="dropdown-menu mt-0" aria-labelledby="userinfo">
                                <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                                <a href="profile.php" class="list-group-item list-group-item-action">Profile Settings</a>
                                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item h-100">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item h-100">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?php include 'cart-slide.php'; ?>