@extends('auth.layout')

@section('content')

<div class="p-5">
    <form action="{{ route('authenticate') }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group">
            <strong>Username</strong>
            <input type="text" name="username" class="form-control" placeholder="Username">
        </div>

        <div class="form-group">
            <strong>Password</strong>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-secondary">Login</button>

    </form>
</div>
   
@endsection