@extends('app')

@section('content')
    <div class="col-md-4 well">
        <h3 class="text-primary text-center">Reset Password</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(['route' => 'student.change_password', 'method' => 'POST']) }}
            {{ Form::hidden('id', $student->id) }}

            <div class="form-group">
                {{ Form::label('oldPassword', 'Current Password') }}
                {{ Form::password('oldPassword', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('newPassword', 'New Password') }}
                {{ Form::password('newPassword', ['class' => 'form-control']) }}
            </div>
            <br />
            <div class="form-group">
                {{ Form::submit('Submit', ['class' => 'btn btn-success form-inline']) }}
                <a class="btn btn-info" href="{{ route('student.list') }}">Back</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
