@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<h2>Available Courses</h2>
<table class="table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Title</th>
            <th>Max Students</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->course_code }}</td>
            <td>{{ $course->title }}</td>
            <td>{{ $course->max_students }}</td>
            <td>
                <form action="{{ route('student.register') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button class="btn btn-primary">Register Now</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection