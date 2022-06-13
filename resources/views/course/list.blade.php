@extends('app')

@section('content')
    <div class="navbar">
        <ul class="navbar-contant clearfix">
            <li class="li-navbar"><a href="{{ route('teacher.list') }}">TEACHER LISTS</a></li>
            <li class="li-navbar"><a href="{{ route('student.list') }}">STUDENT LISTS</a></li>
            <li class="li-navbar"><a class="active" href="#">COURSE LISTS</a></li>
            <li class="li-navbar">
                <div class="dropdown">
                    <button class="dropbtn">
                        @if (Auth::guard('student')->user())
                            {{ $student->student_name }}
                        @endif
                        {{ $teacher->teacher_name }}
                    </button>
                    <div class="dropdown-content">
                        @if (Auth::guard('student')->user())
                            <a href="{{ route('student.profile.show') }}">Profile</a>
                            <a href="{{ route('student.logout') }}">Logout</a>
                        @endif
                        <a href="{{ route('teacher.profile.show') }}">Profile</a>
                        <a href="{{ route('teacher.logout') }}">Logout</a>
                    </div>
            </li>
        </ul>
    </div>
    <div>
        <h1 class="main-hdr">COURSE LISTS</h1><br /><br />
        <div>
            <div class="form-group text-center">
                {{ Form::open(['route' => 'course.search', 'method' => 'POST']) }}
                <div class="form-inline">
                    {{ Form::text('search', null, ['class' => 'form-inline', 'placeholder' => 'Search here...']) }}
                    {{ Form::submit('Search', ['class' => 'btn btn-primary form-inline']) }}
                </div>
                <br /><a class="btn btn-success" href="{{ route('course.create') }}">Create Course</a><br /><br />
                {{ Form::close() }}
            </div>
            <table class="table table-bordered">
                <thead class="alert-danger">
                    <tr>
                        <th class="text-center">Course Name</th>
                        <th class="text-center">Course Date</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Duration</th>
                        <th colspan="3" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="alert-warning">
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course['course_name'] }}</td>
                            <td>{{ $course['course_dt'] }}</td>
                            <td>{{ $course['description'] }}</td>
                            <td>{{ $course['duration'] }}</td>
                            @if($teacher)
                            <td><a class="btn btn-success" href="{{ route('course.detail', $course->id) }}">Show</a></td>
                            <td><a class="btn btn-primary"
                                    href="{{ route('course.update.show', $course->id) }}">Update</a></td>
                            <td><a class="btn btn-danger" href="{{ route('course.delete', $course->id) }}">Delete</a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span class="text-center">
                {{ $courses->links() }}
            </span>
        </div>
    </div>
@endsection
