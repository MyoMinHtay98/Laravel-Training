@extends('app')

@section('content')

    <body>
        <div class="navbar">
            <ul class="navbar-contant clearfix">
                <li class="li-navbar"><a class="active" href="#">HOME</a></li>
                <li class="li-navbar"><a href="{{ route('course.list') }}">COURSE LISTS</a></li>
                <li class="li-navbar"><a href="{{ route('student.list') }}">STUDENT LISTS</a></li>
                <li class="li-navbar">
                    <div class="dropdown">
                        <button class="dropbtn">
                            {{ auth()->user()->teacher_name }}
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('teacher.profile.show') }}">Profile</a>
                            <a href="{{ route('teacher.logout') }}">Logout</a>
                        </div>
                </li>
            </ul>
        </div>
        <div>
            <h1 class="main-hdr">TEACHER LISTS</h1><br /><br />
            <div>
                <div class="form-group text-center">
                    {{ Form::open(['route' => 'teacher.search', 'method' => 'POST']) }}
                    <div class="form-inline">
                        {{ Form::text('name', null, ['class' => 'form-inline', 'placeholder' => 'Search by name...']) }}
                        {{ Form::text('email', null, ['class' => 'form-inline', 'placeholder' => 'Search by email...']) }}
                        {{ Form::submit('Search', ['class' => 'btn btn-primary form-inline']) }}
                        <div>
                            {{ Form::radio('gender', 'm', false, ['id' => 'gender-m']) }}
                            {{ Form::label('gender-m', 'Male', ['class' => 'cyan']) }}
                            {{ Form::radio('gender', 'f', false, ['id' => 'gender-f']) }}
                            {{ Form::label('gender-f', 'Female', ['class' => 'orange']) }}
                        </div>
                        <div>
                            {{ Form::label('active', 'Active:', ['class' => 'green']) }}
                            {{ Form::checkbox('is_active[]', '1', false, ['id' => 'active']) }}
                            {{ Form::label('in_active', 'in-Active:', ['class' => 'red']) }}
                            {{ Form::checkbox('is_active[]', '0', false, ['id' => 'in_active']) }}
                        </div>
                    </div>
                    <br /><a class="btn btn-success" href="{{ route('teacher.create') }}">Create Teacher</a><br /><br />
                    {{ Form::close() }}
                </div>
                <table class="table table-bordered">
                    <thead class="alert-danger">
                        <tr>
                            <th class="text-center">Teacher Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">NRC Number</th>
                            <th class="text-center">Active Status</th>
                            <th class="text-center">Date of Birth</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Total Courses</th>
                            <th colspan="4" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="alert-warning">
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->teacher_name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>
                                    @if ($teacher->gender == 'm')
                                        <span class="orange">{{ 'Male' }}</span>
                                    @else
                                        <span class="purple"> {{ 'Female' }}</span>
                                    @endif
                                </td>
                                <td>{{ $teacher->nrc }}</td>
                                <td>
                                    @if ($teacher->is_active == '1')
                                        <span class="green">{{ 'Active' }}</span>
                                    @else
                                        <span class="red">{{ 'in-Active' }}</span>
                                    @endif
                                </td>
                                <td>{{ $teacher->dob }}</td>
                                <td>{{ $teacher->age }}</td>
                                <td>{{ $teacher->address }}</td>
                                <td>{{ $teacher->courses->count() }}</td>
                                <td><a class="btn btn-info"
                                        href="{{ route('teacher.details', $teacher->id) }}">Show</a>
                                </td>
                                <td><a class="btn btn-primary"
                                        href="{{ route('teacher.update.show', $teacher->id) }}">Update</a>
                                <td><a class="btn btn-danger"
                                        href="{{ route('teacher.delete', $teacher->id) }}">Delete</a>
                                </td>
                                <td><a class="btn btn-success"
                                        href="{{ route('teacher.change_password.show', $teacher->id) }}">Change
                                        Password</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <span class="text-center">
                    {{ $teachers->links() }}
                </span>
            </div>
        </div>
    </body>
@endsection
