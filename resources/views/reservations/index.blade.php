@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Reservations</h1>
        <a href="{{ route('reservations.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Reservation</a>
    </div>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4">Member</th>
                <th class="py-2 px-4">Course</th>
                <th class="py-2 px-4">Reservation Date</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr class="border-b">
                    <td class="py-2 px-4 text-center">{{ $reservation->member->name }}</td>
                    <td class="py-2 px-4 text-center">{{ $reservation->course->name }}</td>
                    <td class="py-2 px-4 text-center">{{ $reservation->reservation_date }}</td>
                    <td class="py-2 px-4 text-center ">
                     
                        <a href="{{ route('reservations.edit', $reservation) }}" class="text-yellow-500 ml-2">Edit</a>
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
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

