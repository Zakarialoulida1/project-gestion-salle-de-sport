@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Edit Member</h1>
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('members.update', $member) }}" method="POST" class="p-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded" value="{{ old('name', $member->name) }}">
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded" value="{{ old('email', $member->email) }}">
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password:</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded">
            <small class="text-gray-600">Leave blank if you don't want to change the password</small>
        </div>
        
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Role:</label>
            <select name="role" class="w-full px-4 py-2 border rounded">
                <option value="user" {{ old('role', $member->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $member->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
@endsection

