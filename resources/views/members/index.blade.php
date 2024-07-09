@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center p-4 mb-4">
        <h1 class="text-2xl font-semibold">Members</h1>
        {{-- <a href="{{ route('members.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Member</a> --}}
    </div>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full bg-white shadow-md rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Role</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>

        //hhhhhhhhhhhhd
        <tbody>
            @foreach ($members as $member)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $member->name }}</td>
                    <td class="py-2 px-4">{{ $member->email }}</td>
                    <td class="py-2 px-4">{{ $member->role }}</td>
                    <td class="py-2 px-4">
                        {{-- <a href="{{ route('members.show', $member) }}" class="text-blue-500">View</a>
                        <a href="{{ route('members.edit', $member) }}" class="text-yellow-500 ml-2">Edit</a> --}}
                        <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline">
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
