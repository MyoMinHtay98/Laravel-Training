@extends('app')

@section('content')
    {{ Form::open(['route' => 'student.search', 'method' => 'POST']) }}
    <div class="text-center">
        <h1 class="main-hdr">SEARCH RESULT</h1><br /><br />
        <a class="btn btn-primary" href="{{ route('student.list') }}">Student Lists</a><br /><br />
    </div>
    @if ($result)
        <table class="table table-bordered">
            <thead class="alert-info">
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Active Status</th>
                    <th class="text-center">Date of Birth</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Total Courses</th>
                </tr>
            </thead>
            <tbody class="alert-warning">
                @foreach ($result as $student)
                    <tr>
                        <td> {{ $student['student_name'] }} </td>
                        <td> {{ $student['email'] }} </td>
                        <td>
                            @if ($student->gender == 'm')
                                {{ 'Male' }}
                            @else
                                {{ 'Female' }}
                            @endif
                        </td>
                        <td>
                            @if ($student->is_active == '1')
                                {{ 'Active' }}
                            @else
                                {{ 'in-Active' }}
                            @endif
                        </td>
                        <td> {{ $student['dob'] }} </td>
                        <td> {{ $student['age'] }} </td>
                        <td> {{ $student['address'] }} </td>
                        <td> {{ $student['total_courses'] }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    {{ Form::close() }}
