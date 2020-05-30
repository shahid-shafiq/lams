@extends('layout')

@section('content')

{{-- $fee --}}

<style>

tr.total  {
  border-top: 4px double gray;
  border-bottom: 1px solid gray;
}

th.total {
  text-align: right;
}
</style>

<div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
            <div class="">
                <h2>{{ __('Fee Details') }}</h2>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
            <div class="">
                <a class="btn btn-sm btn-primary" href="{{ route('home') }}"> Back</a>
            </div>
        </div>
    </div>

<div class="users index large-9 medium-8 columns content">
    <table class="table">
        <thead>
            <tr>
                <th scope="col"><?= ('Department') ?></th>
                <th scope="col"><?= ('Course') ?></th>
                <th scope="col"><?= ('Amount') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $d = 0; 
                $t = 0;
                $gt = 0;
                $ftot = 0;
            ?>
            <?php 
            foreach ($fee as $item):
                if ($d != $item->department_id):
                    if ($d !== 0):
            ?>
            <tr class="total">
              <th class="total" colspan="2"><?= __('Sum') ?></th>
              <th><?= number_format($t) ?></th></tr>
            <?php   endif;
                    $d = $item->department_id;
                    $gt += $t;
                    $t = 0;
                    $ftot += $gt;
            ?>
            <tr><td colspan="3"><?= $item->department->title ?></td></tr>
            <?php endif; ?>
            <tr>
                <td></td>
                <td><?= $item->course->title ?></td>
                <td><?= number_format($item->sum) ?></td>
                <?php $t = $t + $item->sum; ?>
            </tr>
            <?php endforeach; ?>
            <tr class="total">
              <th class="total" colspan="2"><?= __('Sum') ?></th>
              <th><?= number_format($t) ?></th></tr>

            <tr class="total">
              <th class="total" colspan="2"><?= __('Total Fee') ?></th>
              <th><?= number_format($t+$ftot) ?></th></tr>
        </tbody>
    </table>
</div>

@endsection
