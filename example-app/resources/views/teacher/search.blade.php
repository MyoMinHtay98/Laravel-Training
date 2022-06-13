@extends('app')

@section('content')
    {{ Form::open(['route' => 'teacher.search', 'method' => 'POST']) }}
    <div class="text-center">
        <h1 class="main-hdr">SEARCH RESULT</h1><br /><br />
        <a class="btn btn-primary" href="{{ route('teacher.list') }}">Teacher Lists</a><br /><br />
    </div>
    @if ($result && $result != null)
        <table class="table table-bordered">
            <thead class="alert-info">
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">NRC Number</th>
                    <th class="text-center">Active Status</th>
                    <th class="text-center">Date of Birth</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Total Courses</th>
                </tr>
            </thead>
            <tbody class="alert-warning">
                @foreach ($result as $teacher)
                    <tr>
                        <td> {{ $teacher['teacher_name'] }} </td>
                        <td> {{ $teacher['email'] }} </td>
                        <td>
                            @if ($teacher->gender == 'm')
                                {{ 'Male' }}
                            @else
                                {{ 'Female' }}
                            @endif
                        </td>
                        <td> {{ $teacher['nrc'] }} </td>
                        <td>
                            @if ($teacher->is_active == '1')
                                {{ 'Active' }}
                            @else
                                {{ 'in-Active' }}
                            @endif
                        </td>
                        <td> {{ $teacher['dob'] }} </td>
                        <td> {{ $teacher['age'] }} </td>
                        <td> {{ $teacher['address'] }} </td>
                        <td> {{ $teacher['total_courses'] }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    {{ Form::close() }}
