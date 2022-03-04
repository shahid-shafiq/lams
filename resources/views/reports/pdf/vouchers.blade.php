<?php
use Mpdf\Mpdf;
use App\Custom\UrduNumber;
use Carbon\Carbon;

$uf = new UrduNumber();

$pdf = new mPDF([
        'mode' => 'utf-8', 
        'format' => 'A4', 
        'orientation' => 'P'
    ]);

//$pdf->charset_in = 'UTF-8';
$pdf->SetTitle('Vouchers');
$pdf->SetFont('Arial', 'B', 15);

$height = 842; // A4 Page height (pt)
$hft = 7 * 72; // header footer title (pt)
$area = $height-$hft; // remaining area
$lh = 17*1.4; // line height
$maxlines = floor($area/$lh); // maximum lines
$lines = $profile->vouchers_pagesize;
if ($lines > $maxlines) {
    $lines = $maxlines;
}

$p = explode(" ", $period->title);
$m = $p[0];
$y = $p[1];
$count = sizeof($data);
$rows = $lines;
$pages = (int)ceil($count/$rows);
$dt = null;

// widow orphan control
if (($count % $rows) < $pages) {
    $rows++;
    $pages = (int)ceil($count/$rows);
}

$pdf->shrink_tables_to_fit = false;
$pdf->AddPage();

$html = ' 
<style>   
    .urdu { font-family : xbriyaz; }
    table { border-collapse : collapse; }
    th { font-size : 17px; font-weight: bold }
    td { font-size : 16px; font-weight : normal }
    th, td { vertical-align: middle; padding:3px; }
    table, th, td { border : 1pt solid gray; }
    .header { border: 1px red solid; height : 96pt; }
    .hlabel { font-weight:bold; font-size:19px; text-align:center; width: 13%; }
    .hvalue { border-bottom:2px solid black; text-align:center;  }
</style>
';
$pdf->writeHTML($html);

ob_start();
?>

<div class="header urdu">
    <div style="font-weight:bold; text-align: center; font-size:24pt" >انجمن خدام القرآن</div>
    <div style="text-align: center; font-size:13pt" >راولپنڈی / اسلام آباد</div>
    <div style="text-align: center; text-decoration: underline; font-size:11pt" >نقد / چیک ادائیگی ووچر</div>
    <?php if ($site['id'] != 1): ?>
    <div style="text-align: center; font-size:11pt; font-style:italic" ><?= $site['title'] ?></div>
    <?php endif; ?>
</div>

<?php
$htmlHeader = ob_get_contents();
ob_end_clean();

for ($page = 0; $page < $pages; $page++) {
    $pdf->writeHTML($htmlHeader);
    $firstrow = true; 
    $bills = array_slice($data, $page * $rows, $rows);
    

    $sum = 0;
    foreach ($bills as $item) {
      $bill = (object)$item;
      if ($dt == null || $bill->bdate > $dt) {
          $dt = $bill->bdate;
      }
    }
    
    ob_start();
    
?>

    <div class="urdu">
        <div class="hlabel" style="float: right;">
            <?=  __("Date") ?>
        </div>
        <div class="hvalue" style="float: right; width: 17%;">
            <?= $dt ?>
        </div>

        <div class="hvalue" style="float: left; width: 10%;">
            <?= $page+1 ?>
        </div>
        <div class="hlabel" style="float: left;">
            <?=  __("Voucher") ?>
        </div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </div>

<div>&nbsp;</div>

    <table dir="rtl" width="100%" autosize="0" class="urdu trans" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th ><?= __('Bill No.') ?></th>
                <th ><?= __('Date') ?></th>
                <th ><?= __('Details') ?></th>
                <th ><?= __('Amount') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bills as $item): 
              $bill = (object)$item;
              
            ?>
            <tr style="height:20px">
                <td style='padding-left:10px'><?= number_format($bill->no) ?></td>
                <td align="center"><?= Carbon::createFromDate($bill->bdate)->format('d-m-Y') ?></td>
                <td align='right'>
                    <?= ($bill->title) ?>
                    <?= ($bill->description) ?>
                </td>
                <td style="text-align: right"><?= number_format($bill->amount) ?></td>
            </tr>
            <?php 
                $sum += $bill->amount;
                if ($dt ==null || $bill->bdate > $dt) {
                    $dt = $bill->bdate;
                }
            ?>
            <?php endforeach; ?>
        </tbody>
    </table>

<div>&nbsp;</div>

    <!-- Totals -->
    <div style="border-bottom:1px solid black; border-top:1px solid black; width:300px; height:5px"></div>
    <div class="urdu" style="border-bottom:1px solid black; width:300px">
        <div style="font-weight:bold; text-align:left; width:40%; float: right;">
            :<?=  __("Total") ?>
        </div>

        <div style="font-weight:bold; text-align:right; float: left; width: 40%;">
           <?= number_format($sum) ?>
        </div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </div>
   

<div>&nbsp;</div>

    <div class="urdu">
        <div style="border:1px solid black; text-align:center; width:35%; height:100; float: right;">
            &nbsp;
        </div>

        <div style="float: left; height:90; width: 55%;">
           <div style="border-bottom:1px solid black; text-align:right;">&nbsp;</div>
           <div style="border-bottom:1px solid black; text-align:right;"><?= $uf->getUrdu($sum)." "."روپے" ?></div>
           <div style="border-bottom:1px solid black; text-align:right;">&nbsp;</div>
        </div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </div>    
    
<div style="height:80px">&nbsp;</div>

    <!-- Signatories -->
    <div class="urdu">
        <div style="border-top:1px solid black; text-align:center; width:40%; float: right;">
            <?=  __("Approved by") ?>
        </div>

        <div style="border-top:1px solid black; text-align:center; float: left; width: 40%;">
           <?=  __("Prepared by") ?>
        </div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </div>

<?php            
    $htmlBody = ob_get_contents();
    ob_end_clean();   
    $pdf->writeHTML($htmlBody);

    if ($page < $pages-1) $pdf->AddPage();
}

$pdf->Output('vouchers.pdf', 'I');
?>
        