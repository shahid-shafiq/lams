@extends('layout')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-8"><h2>{{__('User Profile')}}</h2></div>
  </div>

  {{-- $user }}
  {{ $user->profile --}}
  
  <form action="{{ route('update.profile') }}" method="POST">
  {{ csrf_field() }}

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
          <strong>{{__('Period')}}:</strong>
          <select name="period" class="form-control">
          @foreach ($periods as $item)
              <option value="{{$item->id}}" 
                  @if ($item->id ===  $period->id)
                      selected
                  @endif
              >{{$item->title}}</option>
          @endforeach
          </select>
      </div>
    </div>

@if ($user->role === 'admin')
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
          <strong>{{__('Site')}}:</strong>
          <select name="site" id="site" class="form-control">
          @foreach ($sites as $item)
              <option value="{{$item->id}}" 
                  @if ($item->id ===  $site->id)
                      selected
                  @endif
              >{{$item->title}}</option>
          @endforeach
          </select>
      </div>
    </div>
@else
<input type="hidden" name="site" value="{{$site->id}}"/>
@endif

</div>

  <div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
          <strong>{{__('Receipt-Rows per Page')}}:</strong>
          <input name="receipt_pagesize" type="number" value="{{ $user->profile->receipts_pagesize }}" class="form-control" placeholder="Receipts per Pgae">
          </select>
      </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
          <strong>{{__('Bill-Rows per Page')}}:</strong>
          <input name="bill_pagesize" type="number" value="{{ $user->profile->bills_pagesize }}" class="form-control" placeholder="Bills per Pgae">
          </select>
      </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
          <strong>{{__('Bill-Rows per Voucher')}}:</strong>
          <input name="voucher_pagesize" type="number" value="{{ $user->profile->vouchers_pagesize }}" class="form-control" placeholder="Receipts per Pgae">
          </select>
      </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
        <strong>{{__('Language')}}:</strong>
        <select name="locale" class="form-control">
        @foreach ($locales as $key=>$val)
            <option value="{{$key}}" 
                @if ($key ===  $user->profile->locale)
                    selected
                @endif
            >{{$val}}</option>
        @endforeach
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
    </div>
  </div>
        
</div>

@endsection