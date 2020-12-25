@extends('reports.layout')

@section('content')

  <?php 
  use App\Custom\UrduNumber;

      //echo $ixr->pid;
      //echo UrduNumber::getUrdu(1432);

    function urdu($val) {
      return;
      if ((gettype($val) == "integer") || (gettype($val) == "double")) {
        echo "Numeric detected";
      }
      else echo "Non-Numeric!!";
    }
?>

{{ __("labels.Dec") }}
<?= app()->getlocale() ?>

<div class="row">
    <div class="col">
        <table class="table table-sm">
            <tbody>
              <tr><th>{{ __('Previous balance') }}</th>
              <td class="text-right">{{ number_format($ixr->opening, 2) }}</td>
              <td>{{ UrduNumber::getUrdu(($ixr->opening)) }}</td>
              </tr>

                <tr><th>{{ __('Total income') }}</th>
                <td class="text-right">{{ number_format($ixr->isum, 2) }}</td>
                <td>{{ UrduNumber::getUrdu($ixr->isum) }}</td>
                </tr>
                
                <tr><th></th>
                <td class="text-right">{{ number_format($ixr->tincome, 2) }}</td>
                <td>{{ UrduNumber::getUrdu($ixr->tincome) }}</td>
                </tr>

                <tr><th>{{ __('Total expenses') }}</th>
                <td class="text-right">{{ number_format($ixr->esum, 2) }}</td>
                <td>{{ UrduNumber::getUrdu($ixr->esum) }}</td>
                </tr>

                <tr><th>{{ __('Balance') }}</th>
                <td class="text-right">{{ number_format($ixr->balance, 2) }}</td>
                <td>{{ UrduNumber::getUrdu($ixr->balance) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('pdflink')
<a target="_blank" href="{{ route('reports', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
@endsection