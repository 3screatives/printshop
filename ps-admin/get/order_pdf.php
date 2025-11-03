<?php
require('../../tcpdf/tcpdf.php');
require_once('../db_function.php');

// Connect to database
$conn = db_connect();

// Get Order ID
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id <= 0) {
    die("Invalid order ID.");
}

// Fetch order details
$order_sql = "
    SELECT o.*, c.business_name, c.business_address, c.contact_name, c.contact_phone, c.contact_email
    FROM ps_orders AS o
    LEFT JOIN ps_clients AS c ON o.client_id = c.client_id
    WHERE o.order_id = ?
";
$order_data = select_query($conn, $order_sql, "i", $order_id);
if (empty($order_data)) {
    die("Order not found.");
}
$order = $order_data[0];

// Fetch order items
$item_sql = "
    SELECT item_name, item_description, qty, unit_price, (qty * unit_price) AS total
    FROM ps_order_items
    WHERE order_id = ?
";
$order_items = select_query($conn, $item_sql, "i", $order_id);

// --------------------------------
// PDF Creation (using FPDF)
// --------------------------------
class MYPDF extends TCPDF
{
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$obj_pdf->SetTitle("Invoice: #PS25-" . $clientData['order_id'] . " - " . $clientData['customer']);
$obj_pdf->setPrintHeader(false);
$obj_pdf->setPrintFooter(true);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, 10);
$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->AddPage();

$content = '
<table cellspacing="0" cellpadding="6">
    <tr>
        <td width="12%">
            <img src="img/stma-print-logo.jpg" width="40px">
        </td>
        <td width="68%">
            <h5 style="line-height: 9px; font-size: 14px;">STMA Printing</h5>
            <p style="line-height: 0px; font-size: 10px">12054 Starcrest Dr, San Antonio, TX 78247</p>
        </td>
        <td width="20%" align="right">
            <h3>
            INVOICE
            <span>#PS25-' . $clientData['order_id'] . '</span>
            </h3>
        </td>
    </tr>
</table>
<table style="padding-bottom: 12px;">
    <tr>
        <td width="60%">
            From,<br>
            <b>STMA Printing</b><br>
            12054 Starcrest Drive, San Antonio, TX 78247<br>
            (210) 672 6006 Ext: 109
        </td>
        <td width="40%">To,<br>
            <b>' . $clientData['customer'] . '</b><br>
            ' . $clientData['address'] . '<br>
            ' . $clientData['email'] . '<br>
            ' . $clientData['phone'] . '
        </td>
    </tr>
</table>
<table cellspacing="0" cellpadding="6" style="border: 1px solid #ebebeb; width: 100%;">
    <tr>
        <th width="6%" align="center" style="font-weight: bold;">Qty</th>
        <th width="20%" style="font-weight: bold; border: 1px solid #ebebeb;">Material</th>
        <th width="47%" style="font-weight: bold; border: 1px solid #ebebeb;">Details</th>
        <th width="15%" align="center" style="font-weight: bold; border: 1px solid #ebebeb;">Size</th>
        <th width="12%" align="center" style="font-weight: bold;">Price</th>
    </tr>
    ' . fetch_data('pdf', $gotID) . '
</table>
<table cellspacing="0" cellpadding="6">
    <tr>
        <td width="60%"><b>Payment ID:</b> ' . $clientData['payment_id'] . '</td>
        <td width="25%" style="border: 1px solid #ebebeb;">Sub Total</td>
        <td width="15%" style="text-align: right; border: 1px solid #ebebeb;">$' . $clientData['subtotal_amt'] . '</td>
    </tr>
    <tr>
        <td width="60%" rowspan="4"><b>Comment:</b> ' . $clientData['comment'] . '</td>
        <td width="25%" style="border: 1px solid #ebebeb;">Total Tax (8.25%)</td>
        <td width="15%" style="text-align: right; border: 1px solid #ebebeb;">$' . $clientData['tax_amt'] . '</td>
    </tr>
    <tr>
        <td width="25%" style="border: 1px solid #ebebeb;"><b>Total</b></td>
        <td width="15%" style="text-align: right; border: 1px solid #ebebeb;"><b>$' . $clientData['total_amt'] . '</b></td>
    </tr>
    <tr>
        <td width="25%" style="border: 1px solid #ebebeb;">Total Paid</td>
        <td width="15%" style="text-align: right; border: 1px solid #ebebeb;">$' . $clientData['total_amt_paid'] . '</td>
    </tr>
    <tr>
        <td width="25%" style="border: 1px solid #ebebeb;"><b>Due</b></td>
        <td width="15%" style="text-align: right; border: 1px solid #ebebeb;"><b>$' . $clientData['total_amt_due'] . '</b></td>
    </tr>
</table>';

ob_end_clean(); // clear any previous output
$obj_pdf->writeHTML($content);
$obj_pdf->Output("Invoice-PS25-" . $clientData['order_id'] . ".pdf", 'I');
exit;

// --------------------------------
// Generate PDF
// --------------------------------
$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Order ID: ' . $order['order_id'], 0, 1, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, 'Date: ' . $order['order_date'], 0, 1, 'L');
$pdf->Ln(5);

$pdf->ClientInfo($order);
$pdf->OrderTable($order_items);

$pdf->Output("I", "Order_{$order_id}.pdf");
