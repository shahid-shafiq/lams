@extends('layout')

<?php
 $data = ["A" => 'Alpha', 'B' => 'Beta', 'C'=>'Gamma'];
?>

<style>
    .value {
        padding-left: 0.25rem;
        padding-right: 0.25 rem;
        text-align: right;
    }

    .level1-label {
        font-size: 1.5rem;
        font-weight: bold;
        background-color: #555;
        color: #fff;
    }

    .level2-label {
        padding-left:1rem;
        font-weight: bold;
    }

    .level3-label {
        text-align: right; 
        padding-right:1rem
    }
</style>

@section('content')

<div class="row">
    <h3 class=><?= __('Profit and Loss Statement') ?></h3>
</div>
</div>

<div class="row d-none d-md-flex justify-content-center">
    <div class="row col-md-8 col-lg-6 justify-content-around">
        <div class="card border-success mr-2 shadow">
            <div class="card-header bg-success text-white ">Total Income</div>
            <div class="card-body">
                <h5 class="card-title">{{ number_format($incomes->isum) }}</h5>
                <p class="card-text"></p>
            </div>
        </div>

        <div class="card border-danger mr-2 shadow">
            <div class="card-header bg-danger text-white">Total Expense</div>
            <div class="card-body">
                <h5 class="card-title">{{ number_format($expenses->esum) }}</h5>
                <p class="card-text"></p>
            </div>
        </div>

        <div class="card border-info mr-2 shadow">
            <div class="card-header bg-info text-white">Net Profit</div>
            <div class="card-body">
                <h5 class="card-title">{{ number_format($incomes->isum-$expenses->esum) }}</h5>
                <p class="card-text"></p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
<div class="col-sm-6" style="margin-top: 0.25rem; height:60vh; overflow:auto;">
    <table class='table'>
        <tbody>
            <tr class="level1-label" >
                <th colspan='2'><?= __('Income') ?></th>
                <th class="value"><?= number_format($incomes->isum) ?></th></tr>

            <?php 
            $d = '';
            foreach ($incomes as $income):
                $dlbl = '';
                if ($d != $income->department_id) {
                    $d = $income->department_id;
                    $dlbl = $dptlist->firstWhere('id', $income->income_id)->title;
                }
                $inctitle = $inclist->firstWhere('id', $income->income_id)->title;
                $link = strcasecmp($inctitle, "fee") != 0 ? true : false;
            ?>
                @if ($dlbl !== '')
                <tr><td colspan="2" class="level2-label">{{ $dlbl }}</td></tr>
                @endif
                <tr>
                <td colspan='2' class='level3-label'>
                    @if ($link)
                    <a href="{{ route('home.feedetail') }}">{{ $inctitle }}</a>
                    @else
                    {{ $inctitle }}
                    @endif</td>
                <td class="value"><?= number_format($income->income_sum) ?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    
        <tbody>
            <tr class="level1-label">
                <th colspan='2'><?= __('Expenses') ?></th>
                <th class="value"><?= number_format($expenses->esum) ?></th></tr>
            <?php 
                $d = '';
                foreach ($expenses as $expense):
                    if ($d != $expense->department_id) {
                        $d = $expense->department_id;
            ?>
            <tr><td colspan="2" class="level2-label">{{ $dptlist->firstWhere('id', $d)->title }}</td></tr>
            <tr>
                <td colspan='2' class="level3-label" style='text-align: right'>
            <?php
                    } else {
            ?>
            <tr>
                <td colspan='2' class="level3-label" style='text-align: right'>
            <?php
                    }
            ?>
                {{ $explist->firstWhere('id', $expense->expense_id)->title }}
                </td>
                <td class="value">{{ number_format($expense->expense_sum) }}</td>
            </tr>

            <?php endforeach; ?>
        </tbody>
                        
        <tbody>
            <tr class="level1-label">
                <th colspan='2'><?= __('Net Profit') ?></th>
                <th class="value"><?= number_format($incomes->isum-$expenses->esum) ?></th></tr>
        </tbody>
    </table>
</div>
</div>

@endsection