@extends('app')

@section('content')
    <div>
        {{ Form::open(['route' => 'student.search', 'method' => 'POST']) }}
        <div class="text-center">
            <h1 class="main-hdr">SEARCH RESULT</h1><br /><br />
            <a class="btn btn-primary" href="{{ route('course.list') }}">Course Lists</a><br /><br />
        </div>
        @if ($result && $result != null)
            <table class="table table-bordered">
                <thead class="alert-info">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Duration</th>
                    </tr>
                </thead>
                <tbody class="alert-warning">
                    @foreach ($result as $course)
                        <tr>
                            <td> {{ $course['course_name'] }} </td>
                            <td> {{ $course['course_dt'] }} </td>
                            <td> {{ $course['description'] }} </td>
                            <td> {{ $course['duration'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $result->links() }}
        @endif
        {{ Form::close() }}
    </div>
