<?php
include 'ps-admin/db_function.php';
$conn = db_connect();

include 'include/head.php';
include 'include/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-6 hero-head">
                <h1>Print and Digital <span>Solutions</span></h1>
                <p>
                    From Digital to Large Format—We Print What Matters.
                </p>
                <a href="./get-a-quote" class="thm-btn">
                    <span>Get A Quote</span>
                </a>
                <a href="./get-a-quote" class="thm-btn gray">
                    <span>Order Now!</span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="services" id="services">
    <div class="container">
        <div class="sec-head">
            <h2><span class="tc-blue">Elevating Your Brand with</span> Premium Print Solutions</h2>
        </div>
        <?php
        // Fetch categories
        $sql = "
            SELECT 
                c.cat_id,
                c.cat_name,
                c.cat_image,
                c.cat_slug,
                COALESCE(
                    CASE 
                        WHEN COUNT(DISTINCT m.mat_type) = 1 THEN MAX(m.mat_type)
                        ELSE 'mixed'
                    END,
                    'mixed'
                ) AS mat_type
            FROM ps_categories c
            LEFT JOIN ps_material_categories_map cm ON c.cat_id = cm.cat_id
            LEFT JOIN ps_materials m ON cm.mat_id = m.mat_id
            GROUP BY c.cat_id
            ORDER BY c.cat_id ASC
            ";
        $categories = select_query($conn, $sql);

        if (!empty($categories)) {
            echo '<div class="container"><div class="row">';

            foreach ($categories as $row) {

                $imgSrc = !empty($row['cat_image'])
                    ? 'img/product-' . $row['cat_image'] . '.jpg'
                    : 'img/no-product.jpg';

                echo '
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="box h-100">
                        <div class="img-holder">
                            <img class="bg img-fluid"
                                src="' . htmlspecialchars($imgSrc) . '"
                                alt="' . htmlspecialchars($row['cat_name']) . '" />
                        </div>
                        <div class="info">
                            <h3>
                                ' . htmlspecialchars($row['cat_name']) . '
                                <span class="d-block">starting at $10.00</span>
                            </h3>

                            <div class="d-inline">
                                <a class="thm-btn red"
                                href="shop/' . htmlspecialchars($row['mat_type']) . '/' . htmlspecialchars($row['cat_slug']) . '">
                                    <span>Order Now</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';
            }

            echo '</div></div>';
        } else {
            echo '<p class="text-center">No categories found.</p>';
        }

        mysqli_close($conn);
        ?>

    </div>
</section>

<section class="custom-design">
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="box text-center">
                    <h3>
                        <span>We Offer</span>
                        Custom Design Service
                    </h3>
                    <p>A design made just for you! Our in-house design team is ready to assist you in creating the
                        prints you've envisioned.</p>

                    <div class="steps">
                        <div class="step px-4">
                            <h1>1</h1>
                            <h4>Tell us you requirements</h4>
                        </div>
                        <div class="step px-4">
                            <h1>2</h1>
                            <h4>We design and share</h4>
                        </div>
                        <div class="step px-4">
                            <h1>3</h1>
                            <h4>Review and get printed/digital copy</h4>
                        </div>
                    </div>

                    <a href="#" class="thm-btn blue mt-4">
                        <span>Get Started</span>
                    </a>
                </div>
            </div>
        </div>
</section>

<?php include 'include/footer.php' ?>