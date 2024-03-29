<?php
use Carbon\Carbon;
use Mpdf\Mpdf;

$pdf = new mPDF([
        'mode' => 'utf-8', 
        'format' => 'A4', 
        'orientation' => 'P'
    ]);
//$pdf->charset_in = 'UTF-8';
$pdf->SetTitle('Income');
$pdf->SetFont('Arial', 'B', 15);

$height = 842; // A4 Page height (pt)
$hft = 2.5 * 72; // header footer title (pt)
$area = $height-$hft; // remaining area
$lh = 17*1.4; // line height
$maxlines = floor($area/$lh); // maximum lines
$lines = $profile->receipts_pagesize;
if ($lines > $maxlines) {
    $lines = $maxlines;
}

if ($period != null) {
    $p = explode(" ", $period->title);
    $m = $p[0];
    $y = $p[1];
}

$count = sizeof($data);
$rows = $lines;
$pages = (int)ceil($count/$rows);

// widow orphan control
if (($count % $rows) < $pages) {
    $rows++;
    $pages = (int)ceil($count/$rows);
}

if ($pages < 1) {
    $pages = 1;
}

$showseq = ($profile->receipt_seqno != 0);
$seq = 1; 

$sum = 0;
$pdf->shrink_tables_to_fit = false;
$pdf->AddPage();

$html = ' 
<style>   
    .urdu { font-family : xbriyaz; }
    table { border-collapse : collapse; }
    th { font-size : 19pt; font-weight: bold }
    td { font-size : 15px; font-weight : normal }
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
            <th style="border:2px solid white; font-size:20pt" width="20%"><?= ($period != null) ? __("labels.".$m) : "" ?></th>
            <th style="border:2px solid white;" align="center" width="60%">
                <div style="font-size:24pt" >انجمن خدام القرآن</div>
                <div style="font-size:13pt" >راولپنڈی / اسلام آباد</div>
                <?php if ($site['id'] != 1): ?>
                <div style="font-size:11pt; font-style:italic" ><?= $site['title'] ?></div>
                <?php endif; ?>
            </th>
            <th style="border:2px solid white; font-size:20pt" width="20%"><?= ($period != null) ? $y : "" ?></th>
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
    $receipts = array_slice($data, $page * $rows, $rows);

    ob_start();
?>

    <table dir="rtl" width="100%" autosize="0" class="urdu trans">
        <thead>
            <tr>
                @if ($showseq)
                <th ><?= __('No') ?></th>
                @endif
                <th ><?= __('Receipt') ?></th>
                <th><?= __('Date') ?></th>
                <th><?= __('Income Detail') ?></th>
                <th><?= __('Amount') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($page > 0): ?>
            <tr style="background-color: #dfdfdf">
                <td style="font-weight: bold; font-size:17pt" align="center" colspan="3" ><?= 'B/F' ?></td>
                <td style="font-weight: bold; font-size:17pt" align="right" ><?= number_format($sum) ?></td>
            </tr>
            <?php else: ?>
            <tr style="background-color: #dfdfdf">
                <td style="font-weight: bold; font-size:17pt" align="center" colspan="4" >&nbsp;</td>
                <!--td style="font-weight: bold; font-size:19pt" align="right" >&nbsp;</td-->
            </tr>
            <?php endif; ?>
            
            <?php if (count($receipts) ==  0) { ?>
                <tr><td>{{__("NO RECORDS FOUND!")}}</td></tr>
            <?php } else { ?> 
            <?php foreach ($receipts as $ritem): 
              $receipt = (object)$ritem;  
            ?>
            <tr>
                @if ($showseq)
                <td><?= ($seq) ?></td>
                @endif
                <td><?= ($receipt->no) ?></td>
                <td style="font-size:15px"><?= Carbon::createFromDate($receipt->rdate)->format('d-m-Y') ?></td>
                <td align='right'>
                    <?= ($receipt->title) ?>
                    <?= ($receipt->description) ?></td>
                
                <td style="text-align: right"><?= number_format($receipt->amount) ?></td>
                <?php 
                    $sum += $receipt->amount;
                    $firstrow = false;
                    $seq += 1;
                ?>
            </tr>
            <?php endforeach; ?>
            <?php } ?>
            <tr class="border-top: 4px solid black;">
                <td style="font-weight: bold; font-size:17pt" align="center" colspan="3" ><?= ($page < $pages-1) ? 'C/O' : __('Total income') ?></td>
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

$pdf->Output('income.pdf', 'I');
?>