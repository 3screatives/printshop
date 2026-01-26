<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="submit-query.php" class="p-4 border rounded">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Business Name</label>
            <input type="text" name="business_name" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Query</label>
            <textarea name="query" rows="4" class="form-control" required></textarea>
        </div>

        <!-- CAPTCHA -->
        <div class="mb-3">
            <label class="form-label">Enter Captcha</label>
            <div class="d-flex align-items-center gap-3">
                <img src="captcha.php?<?= time() ?>" alt="Captcha" id="captcha_img">
                <button type="button" class="btn btn-sm btn-secondary" onclick="refreshCaptcha()">
                    ↻
                </button>
            </div>
            <input type="text" name="captcha" class="form-control mt-2" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Submit</button>
    </form>

    <script>
        function refreshCaptcha() {
            document.getElementById('captcha_img').src = 'captcha.php?' + Date.now();
        }
    </script>

</body>

</html>