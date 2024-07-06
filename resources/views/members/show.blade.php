@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Member Details</h1>
    <p><strong>Name:</strong> {{ $member->name }}</p>
    <p><strong>Email:</strong> {{ $member->email }}</p>
    <p><strong>Role:</strong> {{ $member->role }}</p>
    <a href="{{ route('members.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Members</a>
@endsection
