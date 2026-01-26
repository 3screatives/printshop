<?php
session_start();
$formSuccess = $_SESSION['form_success'] ?? false;
$formError   = $_SESSION['form_error'] ?? null;

// Clear flash messages
unset($_SESSION['form_success'], $_SESSION['form_error']);

include 'ps-admin/config.php';

include 'include/head.php';
include 'include/header.php';
?>

<section class="get-quote" style="min-height: 50vh; padding-bottom: 96px;">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>
                Quote
            </div>

            <h2>Get a Quote</h2>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="card shadow-sm">
                    <div class="card-header text-center text-uppercase">
                        <h5 class="mb-0">Send Us a Query</h5>
                    </div>

                    <div class="card-body">
                        <?php if ($formSuccess): ?>

                        <!-- SUCCESS MESSAGE -->
                        <div class="alert alert-success text-center">
                            <h5 class="mb-2">✅ Thank You!</h5>
                            <p class="mb-0">
                                Your query has been sent successfully.<br>
                                Our team will contact you shortly.
                            </p>
                        </div>

                        <?php else: ?>

                        <?php if ($formError): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($formError) ?>
                        </div>
                        <?php endif; ?>
                        <form method="post" action="submit-query.php">

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <!-- Business Name -->
                            <div class="mb-3">
                                <label class="form-label">Business Name</label>
                                <input type="text" name="business_name" class="form-control">
                            </div>

                            <!-- Query -->
                            <div class="mb-3">
                                <label class="form-label">Your Query</label>
                                <textarea name="query" rows="4" class="form-control" required></textarea>
                            </div>

                            <!-- CAPTCHA -->
                            <div class="mb-3">
                                <label class="form-label">Security Check</label>

                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="captcha.php" id="captcha_img" class="border rounded" alt="Captcha">

                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="refreshCaptcha()">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>

                                <input type="text" name="captcha" class="form-control"
                                    placeholder="Enter the text above" required>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger">
                                    Submit Query
                                </button>
                            </div>

                        </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
function refreshCaptcha() {
    document.getElementById('captcha_img').src = 'captcha.php?' + Date.now();
}
</script>

<?php include 'include/footer.php'; ?>