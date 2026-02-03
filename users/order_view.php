<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="orderModalBody" class="py-4">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.view-order-btn');
        if (!btn) return;

        const orderId = btn.dataset.orderId;
        const body = document.getElementById('orderModalBody');

        body.innerHTML = '<div class="spinner-border" role="status"></div>';

        fetch('ps-admin/get/order.php?order_id=' + orderId)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    body.innerHTML = '<div class="alert alert-danger">' + data.error + '</div>';
                    return;
                }

                body.innerHTML = `
                <h6>Order #${data.order.order_id}</h6>
                <p><strong>Client:</strong> ${data.order.business_name}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge" style="background:${data.order.status_color}; color:#000">
                        ${data.order.status_name}
                    </span>
                </p>
                <p><strong>Total:</strong> $${data.order.after_tax}</p>
                <hr>

                <h6>Items</h6>
                <ul class="list-group">
                    ${data.items.map(item => `
                        <li class="list-group-item">
                        <div class="d-block">
                            ${item.quantity} × ${item.material}
                            (${item.size_width}" × ${item.size_height}")
                            <span class="float-end">$${item.total}</span>
                            </div>
                            <span class="d-block" style="font-size: 12px; color: #99999;">${item.details}</span>
                        </li>
                    `).join('')}
                </ul>
            `;
            })
            .catch(() => {
                body.innerHTML = '<div class="alert alert-danger">Failed to load order</div>';
            });
    });
</script>