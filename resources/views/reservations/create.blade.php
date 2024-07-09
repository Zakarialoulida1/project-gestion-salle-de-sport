@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white mt-12 p-8 rounded shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Create Reservation</h1>
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <input type="hidden" name="member_id" value="{{ Auth()->user()->id }}">
    
            </div>

            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                <select id="course_id" name="course_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Choose a course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="reservation_date" class="block text-sm font-medium text-gray-700">Reservation Date</label>
                <input type="datetime-local" id="reservation_date" name="reservation_date" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('reservation_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Reservation
                </button>
            </div>
        </form>
    </div>
@endsection
