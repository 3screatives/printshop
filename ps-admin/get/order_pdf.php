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

// Fetch order and client details
$order_sql = "
    SELECT 
        o.*, 
        c.business_name, 
        c.business_address, 
        c.contact_name, 
        c.contact_phone, 
        c.contact_email
    FROM ps_orders AS o
    LEFT JOIN ps_clients AS c ON o.client_id = c.client_id
    WHERE o.order_id = ?
";
$order_data = select_query($conn, $order_sql, "i", $order_id);

if (empty($order_data)) {
    die("Order not found.");
}
$order = $order_data[0];

// Fetch order items (join materials for material name/details)
$item_sql = "
    SELECT 
        i.item_id,
        i.item_quantity,
        i.item_details,
        i.item_price,
        i.item_total,
        i.item_size_width,
        i.item_size_height,
        m.mat_name,
        m.mat_details
    FROM ps_order_items AS i
    LEFT JOIN ps_materials AS m ON i.material_id = m.mat_id
    WHERE i.order_id = ?
";
$order_items = select_query($conn, $item_sql, "i", $order_id);

// --------------------------------
// PDF Creation using TCPDF
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

$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Invoice #PS25-" . $order['order_id']);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();

// Company & Client Header
$content = '
<table cellspacing="0" cellpadding="6">
    <tr>
        <td width="10%">
            <img src="http://localhost/printshop/ps-admin/img/stma-print-logo.jpg" width="40">
        </td>
        <td width="60%" style="font-size: 18px; font-weight: bold; line-height: 14px;">
            STMA Printing <br>
            <span style="font-size:10px; font-weight: normal; ">12054 Starcrest Dr, San Antonio, TX 78247</span>
        </td>
        <td width="30%" align="right">
            <h3>INVOICE<br>#PS25-' . $order['order_id'] . '</h3>
        </td>
    </tr>
</table>

<hr style="border:0; border-top:1px solid #ccc; width:100%;">

<table cellpadding="5">
    <tr>
        <td width="60%">
            <b>From:</b><br>
            STMA Printing<br>
            12054 Starcrest Dr<br>
            San Antonio, TX 78247
        </td>
        <td width="40%">
            <b>Bill To:</b><br>
            ' . htmlspecialchars($order['business_name']) . '<br>
            ' . htmlspecialchars($order['business_address']) . '<br>
            ' . htmlspecialchars($order['contact_name']) . '<br>
            ' . htmlspecialchars($order['contact_email']) . '<br>
            ' . htmlspecialchars($order['contact_phone']) . '
        </td>
    </tr>
</table>

<hr>

<table border="1" cellpadding="6" cellspacing="0" bordercolor="#cccccc;">
    <tr style="background-color:#f2f2f2;">
        <th width="8%" align="center"><b>Qty</b></th>
        <th width="18%"><b>Material</b></th>
        <th width="44%"><b>Details</b></th>
        <th width="20%" align="center"><b>Size (W×H)</b></th>
        <th width="10%" align="right"><b>Total ($)</b></th>
    </tr>
';

foreach ($order_items as $item) {
    $content .= '
    <tr>
        <td align="center">' . intval($item['item_quantity']) . '</td>
        <td>' . htmlspecialchars($item['mat_name']) . '</td>
        <td>' . htmlspecialchars($item['item_details']) . '</td>
        <td align="center">' . number_format($item['item_size_width'], 2) . ' × ' . number_format($item['item_size_height'], 2) . '</td>
        <td align="right">$' . number_format($item['item_total'], 2) . '</td>
    </tr>';
}

$content .= '</table><br><br>';

// Totals Section
//<td width="60%"><b>Comments:</b><br>' . htmlspecialchars($order['order_comment']) . '</td>
$content .= '
<table cellspacing="0" cellpadding="6">
    <tr>
        <td width="60%"><b>Thank you for business with us!</b></td>
        <td width="30%" style="border:1px solid #ddd;">Sub Total</td>
        <td width="10%" align="right" style="border:1px solid #ddd;">$' . number_format($order['order_before_tax'], 2) . '</td>
    </tr>
    <tr>
        <td></td>
        <td width="30%" style="border:1px solid #ddd;">Tax</td>
        <td width="10%" align="right" style="border:1px solid #ddd;">$' . number_format($order['order_tax'], 2) . '</td>
    </tr>
    <tr>
        <td></td>
        <td width="30%" style="border:1px solid #ddd;"><b>Total</b></td>
        <td width="10%" align="right" style="border:1px solid #ddd;"><b>$' . number_format($order['order_after_tax'], 2) . '</b></td>
    </tr>
    <tr>
        <td></td>
        <td width="30%" style="border:1px solid #ddd;">Amount Paid</td>
        <td width="10%" align="right" style="border:1px solid #ddd;">$' . number_format($order['order_amount_paid'], 2) . '</td>
    </tr>
    <tr>
        <td></td>
        <td width="30%" style="border:1px solid #ddd;"><b>Amount Due</b></td>
        <td width="10%" align="right" style="border:1px solid #ddd;"><b>$' . number_format($order['order_amount_due'], 2) . '</b></td>
    </tr>
</table>
';

ob_end_clean();
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output("Invoice-PS25-" . $order['order_id'] . ".pdf", 'I');
exit;
