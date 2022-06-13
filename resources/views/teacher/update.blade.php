@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Update Teacher</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-3"></div>
        <div class="col-md-6">
            {{ Form::open(['route' => 'teacher.update', 'method' => 'POST', 'files' => 'true']) }}
            {{ Form::hidden('id', $teacher->id) }}
            <div class="form-group">
                {{ Form::label('teacher_name', 'Name') }}
                {{ Form::text('teacher_name', $teacher->teacher_name, ['class' => 'form-control']) }}
            </div>
            @error('teacher_name')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('mother_name', 'Mother Name') }}
                {{ Form::text('mother_name', $teacher->detail->mother_name, ['class' => 'form-control']) }}
            </div>
            @error('mother_name')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('father_name', 'Father Name') }}
                {{ Form::text('father_name', $teacher->detail->father_name, ['class' => 'form-control']) }}
            </div>
            @error('father_name')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                <img id="image" name="image" style="width:100px;">
            </div>
            <div class="form-group">
                {{ Form::label('file_path', 'Profile Picture') }}
                {{ Form::file('file_path', null, ['id' => 'file_path', 'class' => 'form-control', 'placeholder' => 'No file chosen']) }}
                @error('file_path')
                    <p class="error-msg red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email', $teacher->email, ['class' => 'form-control']) }}
            </div>
            @error('email')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('gender', 'Gender:') }}
                {{ Form::radio('gender', 'm', false, ['id' => 'gender-m', $teacher['gender'] == 'm' ? 'checked' : '']) }}
                {{ Form::label('gender-m', 'Male') }}
                {{ Form::radio('gender', 'f', false, ['id' => 'gender-f', $teacher['gender'] == 'f' ? 'checked' : '']) }}
                {{ Form::label('gender-f', 'Female') }}
            </div>
            @error('gender')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('nrc', 'NRC Number') }}
                {{ Form::text('nrc', $teacher->nrc, ['class' => 'form-control']) }}
            </div>
            @error('nrc')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('is_active', 'Active-Status:') }}
                {{ Form::checkbox('is_active', '1', $teacher['is_active'], ['id' => 'is_active']) }}
            </div>
            @error('is_active')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('dob', 'Date of Birth') }}
                {{ Form::date('dob', $teacher->dob, ['class' => 'form-control']) }}
            </div>
            @error('dob')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('age', 'Age') }}
                {{ Form::number('age', $teacher->age, ['class' => 'form-control']) }}
            </div>
            @error('age')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('course', 'Courses :') }}
                @foreach ($courses as $course)
                    {{ Form::checkbox('courses[]',$course->id,in_array($course['id'],$teacher->courses()->pluck('course_id')->toArray()),['id' => 'course-' . $course->id]) }}
                    {{ Form::label('course-' . $course->id, $course->course_name) }}<br />
                @endforeach
            </div>
            @error('courses')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::label('address', 'Address') }}
                {{ Form::textarea('address', $teacher->address, [
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
                {{ Form::textarea('hobby', $teacher->detail->hobby, [
                    'class' => 'form-control',
                    'rows' => 3,
                    'cols' => 35,
                ]) }}
            </div>
            @error('hobby')
                <p class="error-msg red">{{ $message }}</p>
            @enderror
            <div class="form-group">
                {{ Form::submit('Update', ['class' => 'btn btn-success form-inline']) }}
                <a class="btn btn-info" href="{{ route('teacher.list') }}">Back</a>
            </div>
            {{ Form::close() }}
        </div>
    @endsection

    @section('scripts')
        <script type="text/javascript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#file_path").change(function() {
                readURL(this);
            });
        </script>
    @endsection
