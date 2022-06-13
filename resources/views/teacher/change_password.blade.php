@extends('app')

@section('content')
    <div class="col-md-4 well">
        <h3 class="text-primary text-center">Reset Password</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(['route' => 'teacher.change_password', 'method' => 'POST']) }}
            {{ Form::hidden('id', $teacher->id) }}

            <div class="form-group">
                {{ Form::label('old_password', 'Current Password') }}
                {{ Form::password('old_password', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('new_password', 'New Password') }}
                {{ Form::password('new_password', ['class' => 'form-control']) }}
            </div>
            <br />
            <div class="form-group">
                {{ Form::submit('Submit', ['class' => 'btn btn-success form-inline']) }}
                <a class="btn btn-info" href="{{ route('teacher.list') }}">Back</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
