@extends('auth.layout')

@section('content')
{{-- $autherror --}}

<div class="col-md-10">
    <div class="text-danger" style="font-weight:bold; margin-top: 1rem">
        <span id="msg">
        {{ $autherror !== null ? 'Invalid username or password.' : ''}}
        </span>
    </div>
    <div class="" style="padding-top:2rem; padding-bottom:2rem">
    <form action="{{ route('authenticate') }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <strong>Username</strong>
            <input type="text" onkeydown="clearmsg()" name="username" class="form-control" placeholder="Username">
        </div>

        <div class="form-group">
            <strong>Password</strong>
            <input type="password" onkeydown="clearmsg()" name="password" class="form-control" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-secondary">Login</button>
    </form>
    </div>
</div>
   
@endsection

<script>
function clearmsg() {
    d = document.getElementById("msg");
    d.style.visibility = 'hidden';
}
</script>