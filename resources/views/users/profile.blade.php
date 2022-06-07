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
  <input type="hidden" name="back" value="{{$back}}"/>

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

@if ($user->role != 'user')
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
  </div>
  
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-check">
          <input class="form-check-input" id="receipt_seqno" name="receipt_seqno" type="checkbox" {{ $user->profile->receipt_seqno ? "checked" : "" }}>  
          <label class="form-check-label" for="receipt_seqno">{{__('Show sequence in receipt report')}}</label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-check">
          <input class="form-check-input" id="edit_billno" name="edit_billno" type="checkbox" {{ $user->profile->edit_billno ? "checked" : "" }}>  
          <label class="form-check-label" for="edit_billno">{{__('Enable bill no. editing')}}</label>
        </div>
      </div>
    </div>
@endif
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
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