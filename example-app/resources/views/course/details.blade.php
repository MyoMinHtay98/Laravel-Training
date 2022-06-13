@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Course Details</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="form-group">
                <label>Course Name - </label>
                <span>
                    {{ $course['course_name'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Course Date - </label>
                <span>
                    {{ $course['course_dt'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Description - </label>
                <span>
                    {{ $course['description'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Duration - </label>
                <span>
                    {{ $course['duration'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Total Student - </label>
                <span>
                    {{ $course->students->count() }}
                </span>
            </div>
            <div class="form-group">
                <label>Total Teacher - </label>
                <span>
                    {{ $course->teachers->count() }}
                </span>
            </div>
            <div class="text-center">
                <a class="btn btn-primary" href="{{ route('course.update.show', $course->id) }}">Update</a>
                <a class="btn btn-danger" href="{{ route('course.delete', $course->id) }}">Delete</a>
                <a class="btn btn-info" href="{{ route('course.list') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
