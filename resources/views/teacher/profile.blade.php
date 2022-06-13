@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Teacher Details</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="form-group">
                <label>Name - </label>
                <span>
                    {{ $teacher['teacher_name'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Email - </label>
                <span>
                    {{ $teacher['email'] }}
                </span>
            </div>
            <div class="form-group">
                <label>NRC Number - </label>
                <span>
                    {{ $teacher['nrc'] }}
                </span>
            </div>
            <div class="form-group">
                <label for="gender">Gender - </label>
                <span>
                    @if ($teacher->gender == 'm')
                        <span class="cyan">{{ 'Male' }}</span>
                    @else
                        <span class="pink">{{ 'Female' }}</span>
                    @endif
                </span>
            </div>
            <div class="form-group">
                <label>Active Status - </label>
                <span>
                    @if ($teacher->is_active == '1')
                        <span class="green">{{ 'Active' }}</span>
                    @else
                        <span class="red">{{ 'in-Active' }}</span>
                    @endif
                </span>
            </div>
            <div class="form-group">
                <label>Date of Birth - </label>
                <span>
                    {{ $teacher['dob'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Age - </label>
                <span>
                    {{ $teacher['age'] }}
                </span>
            </div>
            <div class="form-group">
                <label>Address - </label>
                <span>
                    {{ $teacher['address'] }}
                </span>
            </div>
            <div class="form-group text-center">
                <a class="btn btn-success" href="{{ route('teacher.profileEdit.show') }}">Update</a>
                <a class="btn btn-info" href="{{ route('teacher.profileDelete') }}">Delete</a>
                <a class="btn btn-danger" href="{{ route('teacher.logout') }}">Logout</a>
                <a class="btn btn-primary" href="{{ route('teacher.list') }}">Back</a>
            </div>
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
                    @foreach ($teacher->courses as $course)
                        <tr>
                            <td>{{ $course['course_name'] }} </td>
                            <td>{{ $course['description'] }} </td>
                            <td>{{ $course['course_dt'] }}</td>
                            <td>{{ $course['duration'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
