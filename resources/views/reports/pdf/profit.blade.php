<?php
use Mpdf\Mpdf;
use App\Custom\UrduNumber;

$uf = new UrduNumber();

$pdf = new mPDF([
        'mode' => 'utf-8', 
        'format' => 'A4', 
        'orientation' => 'P'
    ]);
//$pdf->charset_in = 'UTF-8';
$pdf->SetTitle('Title');
$pdf->SetFont('Arial', 'B', 15);

$p = explode(" ", $period->title);
$m = $p[0];
$y = $p[1];
$dt = null;


$pdf->shrink_tables_to_fit = false;
$pdf->AddPage();

$html = ' 
<style>   
    .urdu { font-family : xbriyaz; }
    table { border-collapse : collapse; }
    th, td { vertical-align: middle; padding:3px; }
    table, th, td { border : 1px solid gray; }
    .tcell { border:none; border-top:1px solid gray; border-right:1px solid gray; font-size:22px; font-weight:bold; }
    .vcell { border:1px solid gray; font-size:20px; }
    .ucell { border-top:1px solid white; font-size:15px; }
</style>
';
$pdf->writeHTML($html);

ob_start();
?>

<div class="header urdu">
    <table autosize="0" dir="rtl" width="100%" style="border:1px solid white;" class="urdu">
        <tr>
            <th style="border:2px solid white; font-size:20pt" width="20%"><?=  __($m) ?></th>
            <th style="border:2px solid white;" align="center" width="60%">
                <div style="font-size:24pt" >انجمن خدام القرآن</div>
                <div style="font-size:13pt" >راولپنڈی / اسلام آباد</div>
                <?php if ($site['id'] != 1): ?>
                <div>&nbsp;</div>
                <div style="font-size:11pt; font-style:italic" ><?= $site['title'] ?></div>
                <?php endif; ?>
            </th>
            <th style="border:2px solid white; font-size:20pt" width="20%"><?= $y ?></th>
        </tr>
    </table>
</div>

<?php
$htmlHeader = ob_get_contents();
ob_end_clean();

$pdf->writeHTML($htmlHeader);
    
ob_start();    
?>

<div class="header urdu" height="144pt"></div>

<div class="header urdu">
    <table autosize="0" dir="rtl" width="100%" style="border:1px solid white;" class="urdu">
        <tr>
            <th style="border:2px solid white;" align="center" width="100%" colspan="2">
                <div style="font-size:48pt">گوشوارہ</div>
            </th>
        </tr>
        <tr>
            <td style="border:2px solid white" colspan="2"><div class="header urdu" height="96pt">&nbsp;</div></td>
        </tr>
        <tr>
            <th style="border:2px solid white;" align="center" width="100%" colspan="2">
                <div style="font-size:48pt" >آمدن و اخراجات</div>
            </th>
        </tr>
        <tr>
            <td style="border:2px solid white" colspan="2"><div class="header urdu" height="96pt">&nbsp;</div></td>
        </tr>
        <tr>
            <th style="border:2px solid white; padding-left: 10px; font-size:48pt; text-align: left" width="20%"><?=  __($m) ?></th>
            <th style="border:2px solid white; padding-right: 10px; font-size:48pt; text-align: right" width="20%"><?= $y ?></th>
        </tr>
    </table>
</div>

<?php            
$htmlBody = ob_get_contents();
ob_end_clean();  

$pdf->writeHTML($htmlBody);

// Page 2
$pdf->AddPage();
$pdf->writeHTML($htmlHeader);
    
ob_start(); 
?>

<div class="header urdu" height="48pt">&nbsp;</div>

<div class="header urdu">
    <table autosize="0" dir="rtl" width="100%" style="border:1px solid white;" class="urdu">
        <tr>
            <th style="border:1px solid white;" align="center">
                <div style="font-size:24pt">حتمی آمدن و خرچ گوشوارہ</div>
            </th>
        </tr>
        <tr>
            <td style="border:1px solid white" colspan="5"><div class="header urdu" height="48pt">&nbsp;</div></td>
        </tr>
        <tr>
            <th style="border:1px solid white; font-size:22pt; text-align: center">برائے ماہ <?=  __($m) ?> <?= $y ?></th>
        </tr>
        <tr>
            <td style="border:1px solid white" colspan="5"><div class="header urdu" height="48pt">&nbsp;</div></td>
        </tr>
    </table>
</div>

<div>
    <table dir="rtl" width="100%" autosize="0" class="urdu trans" cellpadding="0" cellspacing="0">
        <tr style="height:20px">
            <td class="tcell" >سابقہ آمدن</td>
            <td class="vcell" rowspan="2">&nbsp;</td>
            <td class="vcell" rowspan="2"><?= number_format($ixr->opening) ?></td>
        </tr>
        <tr style="height:20px">
            <td class="ucell"><?= $ixr->opening > -0.01 ? $uf->getUrdu($ixr->opening)." "."روپے" : "منفی " . $uf->getUrdu(-$ixr->opening) ?></td>
        </tr>
        
        <tr style="height:20px">
            <td class="tcell" >آمدن ماہ <?=  __($m) ?></td>  
            <td class="vcell" rowspan="2" align="center">+</td>
            <td class="vcell" rowspan="2"><?= number_format($ixr->isum) ?></td>
        </tr>
        <tr style="height:20px">
            <td class="ucell"><?= $ixr->isum >= 0 ? $uf->getUrdu($ixr->isum)." "."روپے" : "منفی " . $uf->getUrdu(-$ixr->isum) ?></td>
        </tr>        
        
       <tr style="height:20px">
            <td class="tcell" >کل آمدن</td>
            <td class="vcell" rowspan="2" align="center">=</td>
            <td class="vcell" rowspan="2"><?= number_format($ixr->tincome) ?></td>
        </tr>
        <tr style="height:20px">
            <td class="ucell"><?= $ixr->tincome > -0.01 ? $uf->getUrdu($ixr->tincome)." "."روپے" : "منفی " . $uf->getUrdu(-$ixr->tincome) ?></td>
        </tr>
        
        <tr style="height:20px">
            <td class="tcell" >اخراجات ماہ <?=  __($m) ?></td>
            <td class="vcell" rowspan="2" align="center">-</td>
            <td class="vcell" rowspan="2"><?= number_format($ixr->esum) ?></td>
        </tr>
        <tr style="height:20px">
            <td class="ucell"><?= $uf->getUrdu($ixr->esum)." "."روپے" ?></td>
        </tr>
        
        <tr style="height:20px">
            <td class="tcell" >بقایا آمدن</td>
            <td class="vcell" rowspan="2" align="center">=</td>
            <td class="vcell" rowspan="2"><?= number_format($ixr->balance) ?></td>
        </tr>
        <tr style="height:20px">
            <td class="ucell"><?= $ixr->balance > 0.0 ? $uf->getUrdu($ixr->balance)." "."روپے" : "منفی " . $uf->getUrdu(-$ixr->balance) ?></td>
        </tr>
    </table>
</div>    

<?php            
    $htmlBody = ob_get_contents();
    ob_end_clean();   
    $pdf->writeHTML($htmlBody);

    $pdf->Output('title.pdf', 'I');
?>
        