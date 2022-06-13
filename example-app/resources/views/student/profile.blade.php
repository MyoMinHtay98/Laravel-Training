@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Student Details</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="form-group">
                <label>Name - </label>
                <span>
                    {{ $student['student_name'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Email - </label>
                <span>
                    {{ $student['email'] }}
                </span>
            </div>
            <div class="form-group">
                <label for="gender">Gender - </label>
                <span>
                    @if ($student->gender == 'm')
                        <span class="cyan">{{ 'Male' }}</span>
                    @else
                        <span class="purple">{{ 'Female' }}</span>
                    @endif
                </span>
            </div>
            <div class="form-group">
                <label>Active Status - </label>
                <span>
                    @if ($student->is_active == '1')
                        <span class="green">{{ 'Active' }}</span>
                    @else
                        <span class="red">{{ 'in-Active' }}</span>
                    @endif
                </span>
            </div>
            <div class="form-group">
                <label>Date of Birth - </label>
                <span>
                    {{ $student['dob'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Age - </label>
                <span>
                    {{ $student['age'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Address - </label>
                <span>
                    {{ $student['address'] }}
                </span>
            </div>
            <div class="form-group text-center">
                <a class="btn btn-success" href="{{ route('student.profileEdit.show') }}">Update</a>
                <a class="btn btn-danger" href="{{ route('student.profileDelete') }}">Delete</a>
                <a class="btn btn-primary" href="{{ route('student.logout') }}">Logout</a>
                <a class="btn btn-info" href="{{ route('student.list') }}">Back</a>
            </div>
            <h4 class="green text-center"><u>Course Lists</u></h4>
            <table class="table table-bordered">
                <thead class="alert-danger">
                    <tr>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody class="alert-warning">
                    @foreach ($student->courses as $course)
                        <tr>
                            <td>{{ $course['course_name'] }} </td>
                            <td>{{ $course['description'] }} </td>
                            <td>{{ $course['course_dt'] }}</td>
                            <td>{{ $course['duration'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="purple text-center"><u>Project Lists</u></h4>
            <table class="table table-bordered">
                <thead class="alert-info">
                    <tr>
                        <th class="text-center">Project Title</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody class="alert-success">
                    @foreach ($student->assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->project_title }} </td>
                            <td>{{ $assignment->duration }} </td>
                            <td>{{ $assignment->date }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
