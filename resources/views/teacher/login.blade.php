@extends('app')

@section('content')
    @if (session('error'))
        <script type='text/javascript'>
            alert("Your Email or Password is Wroung");
        </script>
    @endif
    <div class="container">
        {{ Form::open(['route' => 'teacher.login', 'method' => 'POST', 'class' => 'login-email']) }}

        <p class="login-text" style="font-size: 2rem; font-weight: 800;">TEACHER LOGIN</p>
        <div class="input-group">
            {{ Form::email('email', null, ['placeholder' => 'Email']) }}
        </div>
        @error('email')
            <p class="error-msg red">{{ $message }}</p>
        @enderror
        <div class="input-group">
            {{ Form::password('password', null, ['placeholder' => 'Password']) }}
        </div>
        @error('password')
            <p class="error-msg red">{{ $message }}</p>
        @enderror
        <div class="input-group">
            {{ Form::submit('Login', ['class' => 'btn btn-success form-inline']) }}
        </div>
        <p class="login-register-text">Don't have an account? <a href="{{ route('teacher.create') }}">Register Here</a>.
        </p>
        {{-- <p class="login-register-text">Forgot your password? <a href="{{ route('teacher.forgotPassword') }}">Reset Here</a>.
        </p> --}}
        {{ Form::close() }}
    </div>
@endsection
