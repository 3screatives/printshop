<?php
include 'view-order.php';
include 'create-order.php';
include 'create-client.php';
include 'create-material.php';
include 'order-designer.php';
include 'create-material-category.php';
?>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="js/custom.js"></script>
<?php if ($edit): ?>
    <script>
        const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
        modal.show();
    </script>
<?php endif; ?>
</body>

</html>