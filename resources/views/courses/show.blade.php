@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">{{ $course->name }}</h2>
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-4">
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" class="w-full h-80 object-cover rounded-md mb-4">
            @endif
            <p class="text-sm text-gray-700 mb-4"><strong>Description:</strong> {{ $course->description }}</p>
            <p class="text-sm text-gray-700 mb-4"><strong>Start Time:</strong> {{ $course->start_time }}</p>
            <p class="text-sm text-gray-700 mb-4"><strong>End Time:</strong> {{ $course->end_time }}</p>
            <p class="text-sm text-gray-700 mb-4"><strong>Instructor:</strong> {{ $course->instructor }}</p>
        </div>
        <div class="flex justify-between">
            <form action="{{ route('courses.register', $course->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">S'inscrire sur ce cours</button>
            </form>
        </div>
    </div>
</div>
@endsection
