@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Student Details</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Profile Image</label>
                <img src="{{ asset('uploads/' . $student->file_path) }}" width="70px" height="70px" alt="Image">
            </div>
            <div class="form-group">
                <label>Name - </label>
                <span>
                    {{ $student->student_name }}
                </span>
            </div>
            <div class="form-group">
                <label>Mother Name - </label>
                <span> {{ $student->detail->mother_name }} </span>
            </div>
            <div class="form-group">
                <label>Father Name - </label>
                <span> {{ $student->detail->father_name }} </span>
            </div>
            <div class="form-group">
                <label>Email - </label>
                <span>
                    {{ $student->email }}
                </span>
            </div>
            <div class="form-group">
                <label>Age - </label>
                <span>
                    {{ $student->age }}
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
                <label>Date of Birth - </label>
                <span>
                    {{ $student->dob }}
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
                <label>Hobby - </label>
                <span> {{ $student->detail->hobby }} </span>
            </div>
            <div class="form-group">
                <label>Address - </label>
                <span>
                    {{ $student->address }}
                </span>
            </div>

            <div class="text-center">
                <a class="btn btn-primary" href="{{ route('student.update.show', $student->id) }}">Update</a>
                <a class="btn btn-danger" href="{{ route('student.delete', $student->id) }}">Delete</a>
                <a class="btn btn-info" href="{{ route('student.list') }}">Back</a><br /><br />
            </div>
            <h4 class="green text-center"><u>Course Lists</u></h4>
            <table class="table table-bordered">
                <thead class="alert-danger">
                    <tr>
                        <th class="text-center">Course Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody class="alert-warning">
                    @foreach ($student->courses as $course)
                        <tr>
                            <td>{{ $course['course_name'] }} </td>
                            <td>{{ $course['description'] }} </td>
                            <td>{{ $course['duration'] }} </td>
                            <td>{{ $course['course_dt'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table><br />
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
