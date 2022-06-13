@extends('app')

@section('content')
    <div class="navbar">
        <ul class="navbar-contant clearfix">
            <li class="li-navbar"><a class="active" href="#">HOME</a></li>
            <li class="li-navbar"><a href="{{ route('teacher.list') }}">TEACHER LISTS</a></li>
            <li class="li-navbar"><a href="{{ route('course.list') }}">COURSE LISTS</a></li>
            <li class="li-navbar">
                <div class="dropdown">
                    <button class="dropbtn">
                        {{ $teacher->teacher_name }}
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('teacher.profile.show') }}">Profile</a>
                        <a href="{{ route('teacher.logout') }}">Logout</a>
                    </div>
            </li>
        </ul>
    </div>
    <div>
        <div>
            <h1 class="main-hdr">STUDENT LISTS</h1><br /><br />
            <div>
                <div class="form-group text-center">
                    {{ Form::open(['route' => 'student.search', 'method' => 'POST']) }}
                    <div class="form-inline text-center">
                        {{ Form::text('name', null, ['class' => 'form-inline', 'placeholder' => 'Search by name...']) }}
                        {{ Form::text('email', null, ['class' => 'form-inline', 'placeholder' => 'Search by email...']) }}
                        {{ Form::submit('Search', ['class' => 'btn btn-primary form-inline']) }}
                        <div>
                            {{ Form::radio('gender', 'm', false, ['id' => 'gender-m']) }}
                            {{ Form::label('gender-m', 'Male', ['class' => 'cyan']) }}
                            {{ Form::radio('gender', 'f', false, ['id' => 'gender-f']) }}
                            {{ Form::label('gender-f', 'Female', ['class' => 'purple']) }}
                        </div>
                        <div>
                            {{ Form::label('active', 'Active:', ['class' => 'green']) }}
                            {{ Form::checkbox('is_active[]', '1', false, ['id' => 'active']) }}
                            {{ Form::label('in_active', 'in-Active:', ['class' => 'red']) }}
                            {{ Form::checkbox('is_active[]', '0', false, ['id' => 'in_active']) }}
                        </div>
                    </div>
                    <br /><a class="btn btn-success" href="{{ route('student.create') }}">Create Student</a><br /><br />
                    {{ Form::close() }}
                </div>
                <table class="table table-bordered">
                    <thead class="alert-danger">
                        <tr>
                            <th class="text-center">Student Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Active Status</th>
                            <th class="text-center">Date of Birth</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Total Courses</th>
                            <th colspan="4" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="alert-warning">
                        @forelse ($students as $student)
                            <tr>
                                <td>{{ $student->student_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    @if ($student->gender == 'm')
                                        <span class="orange">{{ 'Male' }}</span>
                                    @else
                                        <span class="purple">{{ 'Female' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($student->is_active == '1')
                                        <span class="green">{{ 'Active' }}</span>
                                    @else
                                        <span class="red">{{ 'in-Active' }}</span>
                                    @endif
                                </td>
                                <td>{{ $student->dob }}</td>
                                <td>{{ $student->age }}</td>
                                <td>{{ $student->address }}</td>
                                <td>{{ $student->courses->count() }}</td>
                                <td><a class="btn btn-info" href="{{ route('student.detail', $student->id) }}">Show</a>
                                </td>
                                <td><a class="btn btn-primary"
                                        href="{{ route('student.update.show', $student->id) }}">Update</a></td>
                                <td><a class="btn btn-danger"
                                        href="{{ route('student.delete', $student->id) }}">Delete</a>
                                </td>
                                <td><a class="btn btn-success"
                                        href="{{ route('student.change_password.show', $student->id) }}">Change
                                        Password</a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="9">There is no data</td>
                        @endforelse

                    </tbody>
                </table>
                <span class="text-center">

                    {{ $students->links() }}

                </span>
            </div>
        </div>
    @endsection
