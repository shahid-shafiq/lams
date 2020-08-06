<?php
use Mpdf\Mpdf;
use Carbon\Carbon;

$pdf = new mPDF([
        'mode' => 'utf-8', 
        'format' => 'A4', 
        'orientation' => 'P'
    ]);
//$pdf->charset_in = 'UTF-8';
$pdf->SetTitle('Expenses');
$pdf->SetFont('Arial', 'B', 15);

$height = 842; // A4 Page height (pt)
$hft = 2.5 * 72; // header footer title (pt)
$area = $height-$hft; // remaining area
$lh = 17*1.4; // line height
$maxlines = floor($area/$lh); // maximum lines
$lines = $profile->bills_pagesize;
if ($lines > $maxlines) {
    $lines = $maxlines;
}

$p = explode(" ", $period->title);
$m = $p[0];
$y = $p[1];
$count = sizeof($data);
$rows = $lines;
$pages = (int)ceil($count/$rows);

// widow orphan control
if (($count % $rows) < $pages) {
    $rows++;
    $pages = (int)ceil($count/$rows);
}

$sum = 0;
$pdf->shrink_tables_to_fit = false;
$pdf->AddPage();

$html = ' 
<style>   
    .urdu { font-family : xbriyaz; }
    table { border-collapse : collapse; }
    th { font-size : 17pt; font-weight: bold }
    td { font-size : 16px; font-weight : normal }
    th, td { vertical-align: middle; padding:3px; }
    table, th, td { border : 1pt solid gray; }
    .header { border: 1px red solid; height : 96pt; }
</style>
';
$pdf->writeHTML($html);

ob_start();
?>

<div class="header">
    <table autosize="0" dir="rtl" width="100%" style="border:1px solid white;" class="urdu">
        <tr>
            <th style="border:2px solid white; font-size:20pt" width="20%"><?=  __("labels.".$m) ?></th>
            <th style="border:2px solid white;" align="center" width="60%">
                <div style="font-size:24pt" >انجمن خدام القرآن</div>
                <div style="font-size:13pt" >راولپنڈی / اسلام آباد</div>
                <?php if ($site['id'] != 1): ?>
                <div style="font-size:11pt; font-style:italic" ><?= $site['title'] ?></div>
                <?php endif; ?>
            </th>
            <th style="border:2px solid white; font-size:20pt" width="20%"><?= $y ?></th>
        </tr>
    </table>
    <!--div><?php echo $count.'-'.$pages.'-'.$count/$rows; ?></div-->
</div>

<?php
$htmlHeader = ob_get_contents();
ob_end_clean();

for ($page = 0; $page < $pages; $page++) {
    $pdf->writeHTML($htmlHeader);
    $firstrow = true; 
    $bills = array_slice($data, $page * $rows, $rows);

    ob_start();
?>
    <table dir="rtl" width="100%" autosize="0" class="urdu trans" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <!-- previously used widths 14, 45, 20, 15 -->
                <th ><?= __('Voucher') ?></th>
                <th ><?= __('Date') ?></th>
                <th ><?= __('Expense Detail') ?></th>
                <th ><?= __('Amount') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($page > 0): ?>
            <tr style="background-color: #dfdfdf">
                <td style="font-weight: bold; font-size:16pt" align="center" colspan="3" ><?= 'B/F' ?></td>
                <td style="font-weight: bold; font-size:16pt" align="right" ><?= number_format($sum) ?></td>
            </tr>
            <?php else: ?>
            <tr style="background-color: #dfdfdf">
                <td style="font-weight: bold; font-size:16pt" align="center" colspan="4" >&nbsp;</td>
                <!--td style="font-weight: bold; font-size:18pt" align="right" >&nbsp;</td-->
            </tr>
            <?php endif; ?>
            
            <?php foreach ($bills as $item): 
              $bill = (object)$item;
            ?>
            <tr>
                <td align="center"><?= number_format($bill->no) ?></td>
                <td><?= Carbon::createFromDate($bill->bdate)->format('d-m-Y') ?></td>
                <td align="right">
                    <?= ($bill->title) ?>
                    <?= ($bill->description) ?>
                </td>
                
                <td style="text-align: right"><?= number_format($bill->amount) ?></td>
            </tr>
            <?php 
                $sum += $bill->amount;
                $firstrow = false;
            ?>
            <?php endforeach; ?>
            <tr class="border-top: 4px solid black;">
                <td style="font-weight: bold; font-size:17pt" align="center" colspan="3" ><?= ($page < $pages-1) ? 'C/O' : __('Total expenses') ?></td>
                <td style="font-weight: bold; font-size:17pt" align="right"><?= number_format($sum) ?></td>
            </tr>
        </tbody>
    </table>
<?php            
    $htmlBody = ob_get_contents();
    ob_end_clean();   
    $pdf->writeHTML($htmlBody);

    if ($page < $pages-1) $pdf->AddPage();
}

$pdf->Output('expense.pdf', 'I');
?>
        