@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Create Course</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(['route' => 'course.create', 'method' => 'POST']) }}

            <div class="form-group">
                {{ Form::label('course_name', 'Course Name') }}
                {{ Form::text('course_name', null, ['class' => 'form-control']) }}
            </div>
            @error('course_name')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('course_dt', 'Course Date') }}
                {{ Form::date('course_dt', null, ['class' => 'form-control']) }}
            </div>
            @error('course_dt')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', null, [
                    'class' => 'form-control',
                    'rows' => 3,
                    'cols' => 35,
                ]) }}
            </div>
            @error('description')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('duration', 'Duration') }}
                {{ Form::number('duration', null, ['class' => 'form-control']) }}
            </div>
            @error('duration')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group text-center">
                {{ Form::submit('Submit', ['class' => 'btn btn-success form-inline']) }}
                <a class="btn btn-info" href="{{ route('course.list') }}">Back</a>
            </div>
            {{ Form::close() }}
        </div>
    @endsection
