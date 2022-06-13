@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Update Course</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(['route' => 'course.update', 'method' => 'POST']) }}
            {{ Form::hidden('id', $course->id) }}

            <div class="form-group">
                {{ Form::label('course_name', 'Course Name') }}
                {{ Form::text('course_name', $course->course_name, ['class' => 'form-control']) }}
            </div>
            @error('course_name')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('course_dt', 'Course Date') }}
                {{ Form::date('course_dt', $course->course_dt, ['class' => 'form-control']) }}
            </div>
            @error('course_dt')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', $course->description, [
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
                {{ Form::number('duration', $course->duration, ['class' => 'form-control']) }}
            </div>
            @error('duration')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group text-center">
                {{ Form::submit('Update', ['class' => 'btn btn-success form-inline']) }}
                <a class="btn btn-info" href="{{ route('course.list') }}">Back</a>
            </div>
            {{ Form::close() }}
        </div>
    @endsection
