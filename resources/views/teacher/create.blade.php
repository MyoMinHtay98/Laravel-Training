@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Create Teacher</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(['route' => 'teacher.create', 'method' => 'POST', 'files' => 'true']) }}

            <div class="form-group">
                {{ Form::label('teacher_name', 'Name') }}
                {{ Form::text('teacher_name', null, ['class' => 'form-control']) }}
            </div>
            @error('name')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('father_name', 'Father Name') }}
                {{ Form::text('father_name', null, ['class' => 'form-control']) }}
                @error('father_name')
                    <p class="error-msg red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('mother_name', 'Mother Name') }}
                {{ Form::text('mother_name', null, ['class' => 'form-control']) }}
                @error('mother_name')
                    <p class="error-msg red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('file_path', 'Profile Picture') }}
                {{ Form::file('file_path', null, ['class' => 'form-control', 'placeholder' => 'No file chosen']) }}
                @error('file_path')
                    <p class="error-msg red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email', null, ['class' => 'form-control']) }}
            </div>
            @error('email')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', ['class' => 'form-control']) }}
            </div>
            @error('password')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('nrc', 'NRC Number') }}
                {{ Form::text('nrc', null, ['class' => 'form-control']) }}
            </div>
            @error('nrc')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('gender', 'Gender:') }}
                {{ Form::radio('gender', 'm', false, ['id' => 'gender-m']) }}
                {{ Form::label('gender-m', 'Male') }}
                {{ Form::radio('gender', 'f', false, ['id' => 'gender-f']) }}
                {{ Form::label('gender-f', 'Female') }}
            </div>
            @error('gender')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('is_active', 'Active-Status:') }}
                {{ Form::checkbox('is_active', '1', ['id' => 'is_active']) }}
            </div>
            @error('is_active')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('dob', 'Date of Birth') }}
                {{ Form::date('dob', null, ['class' => 'form-control']) }}
            </div>
            @error('dob')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('age', 'Age') }}
                {{ Form::number('age', null, ['class' => 'form-control']) }}
            </div>
            @error('age')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('course', 'Courses :') }}
                @foreach ($courses as $course)
                    {{ Form::checkbox('courses[]', $course->id, false, ['id' => 'course-' . $course->id]) }}
                    {{ Form::label('course-' . $course->id, $course->course_name) }}<br />
                @endforeach
            </div>
            @error('courses')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('address', 'Address') }}
                {{ Form::textarea('address', null, [
                    'class' => 'form-control',
                    'rows' => 3,
                    'cols' => 35,
                ]) }}
            </div>
            @error('address')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('hobby', 'Hobby') }}
                {{ Form::textarea('hobby', null, [
                    'class' => 'form-control',
                    'rows' => 3,
                    'cols' => 35,
                ]) }}
            </div>
            @error('hobby')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group text-cente">
                {{ Form::submit('Submit', ['class' => 'btn btn-success form-inline']) }}
                <a class="btn btn-primary" href="{{ route('teacher.list') }}">Back</a>
            </div>
            {{ Form::close() }}
        </div>
    @endsection
