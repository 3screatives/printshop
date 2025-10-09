<?php
include 'include/head.php';
include 'include/header.php';
?>

<section class="order-page">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a> <i class="bi bi-chevron-right"></i> <a href="shop">Shop</a> <i
                    class="bi bi-chevron-right"></i> <?php echo 'Form Title'; ?>
            </div>
            <h2><?php echo 'Form Title'; ?></h2>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="img/product.jpg" alt="<?php echo 'Form Title'; ?>">
            </div>
            <div class="col-6">
                <form id="calcForm">
                    <div class="order-form-wrap">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Material <span class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="material_id" id="material_id" required>
                                    <option value="">-- Select Material --</option>
                                </select>
                            </div>
                        </div> <!-- Materials -->

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Size <span class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <div class="d-flex gap-3">
                                    <!-- Width Input -->
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="width" name="width" value="24">
                                        <span class="input-group-text">in</span>
                                    </div>

                                    <!-- Height Input -->
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="height" name="height" value="36">
                                        <span class="input-group-text">in</span>
                                    </div>
                                </div>
                                <div class="sec-disc mt-3">
                                    <b>Width:</b> min 24 - max 48<br>
                                    <b>Height:</b> min 24 - max 220
                                </div>
                            </div>
                        </div><!-- Size -->

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Quantity <span class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" name="quantity" id="quantity" value="1"
                                    required>
                            </div>
                        </div><!-- Quantity -->

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Sides <span class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <select name="sides" id="sides" class="form-control">
                                    <option value="single">Single Side</option>
                                    <option value="double">Double Side</option>
                                </select>
                            </div>
                        </div><!-- Sides -->

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Grommets <span class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <input type="checkbox" name="grommets" id="grommets" value="1"> Add Grommets (+$5)
                            </div>
                        </div><!-- Grommets -->

                        <div class="mb-3 row">
                            <label for="order_grommets" class="col-sm-4 col-form-label">H-Frame <span
                                    class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control toggle-custom-input" name="order_sides" id="order_sides">
                                    <option value="0">Wire H-Frame</option>
                                    <option value="1">No Wire H-Frame</option>
                                </select>
                            </div>
                        </div><!-- H Frame -->

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Production Time <span class="tc-red">*</span></label>
                            <div class="col-sm-8">
                                <select name="production_time" id="production_time" class="form-control">
                                    <option value="0">Normal (no extra)</option>
                                    <option value="0.15">Rush (2-Day +15%)</option>
                                    <option value="0.30">Same-Day +30%</option>
                                </select>
                            </div>
                        </div><!-- Production Time -->

                        <div class="mb-3 row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8 text-end">
                                <button type="button" class="thm-btn thm-btn-small" name="order_reset" id="order_reset">
                                    <span>Reset Order</span>
                                </button>
                            </div>
                        </div><!-- Reset Order -->

                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <h4 class="fw-bold" id="result">Final Price: $0.00</h4>
                                <div id="breakdown"></div>
                            </div>
                        </div><!-- Final Price -->

                        <div class="mb-3 row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8 text-end">
                                <button type="button" class="thm-btn thm-btn-small" name="order_reset" id="order_reset">
                                    <span>Upload File</span>
                                </button>
                                <button type="button" class="thm-btn thm-btn-small gray" name="order_reset"
                                    id="order_reset">
                                    <span>Create Design</span>
                                </button>
                            </div>
                        </div><!-- Upload/Design -->

                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <button type="button" class="thm-btn red w-100" name="order_reset" id="order_reset">
                                    <span>Add to Cart</span>
                                </button>
                            </div>
                        </div><!-- Add To Cart -->

                        <div class="row">
                            <div class="col-sm-12">
                                <p class="fs-7"><b>Note:</b> STMA Printing reserves the right to correct any pricing
                                    errors displayed on the
                                    website, including typographical mistakes or omissions. If necessary, the
                                    buyer/client will be notified
                                    of any revised pricing prior to order processing. Applicable sales tax is
                                    additional. Shipping costs are
                                    not included in the listed prices. Prices may vary between in-store and online
                                    orders.</p>
                            </div>
                        </div><!-- Note -->

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="product-details">
    <div class="container">
        <div class="order-form-wrap">
            <div class="row">
                <div class="col-sm-12">
                    <div class="sec-head">
                        <h2>Product Description<span class="tc-red">Your message, clearly displayed—where it matters
                                most.</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>Looking for a way to grab attention and make a high impact? Look no further than custom vinyl
                        banners. These banners are perfect for indoor or outdoor use and come with grommets and
                        reinforced edges as an option for easy hanging. Get your custom banner printing done
                        Locally!</p>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-5">
                    <ul>
                        <li>High visual impact</li>
                        <li>Highly Customizable</li>
                        <li>Easy to install</li>
                        <li>Durable</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="call-action">
                        <p>Looking for help with design? We offer <a class="thm-link blue"
                                href="graphic-design.php">graphic
                                design services</a> and can help you with all your graphic design needs.</p>

                        <p>Let us help you with your next project! Submit a request for a <a class="thm-link red"
                                href="get-a-quote.php">printing quote</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'include/footer.php'; ?>