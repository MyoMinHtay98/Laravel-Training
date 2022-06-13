@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Reset Password</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">

            {{ Form::open(['route' => 'student.forgetpassword', 'method' => 'POST']) }}
            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', null, ['class' => 'form-control']) }}
            </div>
            {{-- @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif --}}
            <div class="form-group text-center">
                {{ Form::submit('Send Password Reset Link', ['class' => 'btn btn-success form-inline']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
