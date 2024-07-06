@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center p-4 mb-4">
        <h1 class="text-2xl font-semibold">Courses</h1>
        <a href="{{ route('courses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Course</a>
    </div>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4">Image</th>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Description</th>
                <th class="py-2 px-4">Start Time</th>
                <th class="py-2 px-4">End Time</th>
                <th class="py-2 px-4">Instructor</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr class="border-b">
                    <td class="py-2 px-4">
                        @if ($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-500">No image</span>
                        @endif
                    </td>
                    <td class="py-2 px-4">{{ $course->name }}</td>
                    <td class="py-2 px-4">{{ $course->description }}</td>
                    <td class="py-2 px-4">{{ $course->start_time }}</td>
                    <td class="py-2 px-4">{{ $course->end_time }}</td>
                    <td class="py-2 px-4">{{ $course->instructor }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('courses.show', $course) }}" class="text-blue-500">View</a>
                        <a href="{{ route('courses.edit', $course) }}" class="text-yellow-500 ml-2">Edit</a>
                        <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
