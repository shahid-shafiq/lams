@extends('reports.layout')

@section('content')

  <?php 
    use App\Custom\UrduNumber;
  ?>

<div class='table-responsive'>
    <table id='infaq-grid' class='table table-striped table-sm'>
        <thead class="thead-dark">
            <tr>
                <th><?= __('Name') ?></th>
                <th><?= __('Regno') ?></th>
                <th><?= __('Mobile') ?></th>
                <th><?= __('Pledge') ?></th>
                <th><?= __('Jan') ?></th>
                <th><?= __('Feb') ?></th>
                <th><?= __('Mar') ?></th>
                <th><?= __('Apr') ?></th>
                <th><?= __('May') ?></th>
                <th><?= __('Jun') ?></th>
                <th><?= __('Jul') ?></th>
                <th><?= __('Aug') ?></th>
                <th><?= __('Sep') ?></th>
                <th><?= __('Oct') ?></th>
                <th><?= __('Nov') ?></th>
                <th><?= __('Dec') ?></th>
            </tr>
        </thead>
    
<tbody style="font-size: 0.85rem">
@foreach ($data as $row)
<tr>
@foreach ($row as $cell)
<td>{{ $cell }}</td>
@endforeach
</tr>
@endforeach
</table>
</div>

@endsection

@section('pdflink')
<a target="_blank" href="{{ route('reports.infaaq', 'csv') }}" class="btn btn-secondary btn-sml">CSV</a>
@endsection

@section('pages')
<div class="d-inline w-20 h5">
  <select class="text-info"
  style="
    padding: 0.3rem;
    font-weight:bold;
    background-color:rgba(0,0,0,0.0);
    border: none;
  " 
  onchange = "refreshYear(this)">
  @foreach ($years as $y)
  <option value="{{$y->year}}"
  {{ $y->year == $year ? 'selected' : ''}}
  >{{$y->year}}
  </option>
  @endforeach
  </select>
</div>
<script>
        $(function() {});
        function refreshYear(obj) { self.location.search = '?year='+ obj.value; }
    </script>
@endsection