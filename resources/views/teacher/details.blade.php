@extends('app')

@section('content')
    <div class="col-md-6 well">
        <h3 class="text-primary text-center">Teacher Details</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Profile Image</label>
                <img src="{{ asset('uploads/' . $teacher->file_path) }}" width="200px" height="100px" alt="Image">
            </div>
            <div class="form-group">
                <label>Name - </label>
                <span>
                    {{ $teacher->teacher_name }}
                </span>
            </div>
            <div class="form-group">
                <label>Mother Name - </label>
                <span> {{ $teacher->detail->mother_name }} </span>
            </div>
            <div class="form-group">
                <label>Father Name - </label>
                <span> {{ $teacher->detail->father_name }} </span>
            </div>
            <div class="form-group">
                <label>Email - </label>
                <span>
                    {{ $teacher->email }}
                </span>
            </div>
            <div class="form-group">
                <label>NRC Number - </label>
                <span>
                    {{ $teacher->nrc }}
                </span>
            </div>
            <div class="form-group">
                <label for="gender">Gender - </label>
                <span>
                    @if ($teacher->gender == 'm')
                        <span class="cyan">{{ 'Male' }}</span>
                    @else
                        <span class="purple">{{ 'Female' }}</span>
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
                <label>Hobby - </label>
                <span> {{ $teacher->detail->hobby }} </span>
            </div>
            <div class="form-group">
                <label>Date of Birth - </label>
                <span>
                    {{ $teacher->dob }}
                </span>
            </div>
            <div class="form-group">
                <label>Age - </label>
                <span>
                    {{ $teacher->age }}
                </span>
            </div>
            <div class="form-group">
                <label>Address - </label>
                <span>
                    {{ $teacher->address }}
                </span>
            </div>
            <div class="text-center">
                <a class="btn btn-primary" href="{{ route('teacher.update.show', $teacher->id) }}">Update</a>
                <a class="btn btn-danger" href="{{ route('teacher.delete', $teacher->id) }}">Delete</a>
                <a class="btn btn-info" href="{{ route('teacher.list') }}">Back</a> <br /><br />
            </div>
            <table class="table table-bordered">
                <thead class="alert-danger">
                    <tr>
                        <th>Course Name</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody class="alert-warning">
                    @foreach ($teacher->courses as $course)
                        <tr>
                            <td>{{ $course['course_name'] }} </td>
                            <td>{{ $course['course_dt'] }} </td>
                            <td>{{ $course['description'] }} </td>
                            <td>{{ $course['duration'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
