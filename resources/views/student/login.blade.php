@extends('app')

@section('content')
@if (Session::has('message'))
<div class="alert alert-success" role="alert">
   {{ Session::get('message') }}
</div>
@endif
    <div class="container">
        {{ Form::open(['route' => 'student.login', 'method' => 'POST', 'class' => 'login-email']) }}

        <p class="login-text" style="font-size: 2rem; font-weight: 800;">STUDENT LOGIN</p>
        <div class="input-group">
            {{ Form::email('email', null, ['placeholder' => 'Email']) }}
        </div>
        <div class="input-group">
            {{ Form::password('password', null, ['placeholder' => 'Password']) }}
        </div>
        <div class="input-group">
            {{ Form::submit('Login', ['class' => 'btn btn-success form-inline']) }}
        </div>
        <p class="login-register-text">Don't have an account? <a href="{{ route('student.create') }}">Register Here</a>.
        </p>
        {{-- <p class="login-register-text">Forgot your password? <a href="{{ route('student.forgotPassword') }}">Reset Here</a>.
        </p> --}}
        {{ Form::close() }}
    </div>
@endsection
