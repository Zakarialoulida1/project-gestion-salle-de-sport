@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center p-4 mb-4">
        <h1 class="text-2xl font-semibold">Subscriptions</h1>
        {{-- <a href="{{ route('subscriptions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Subscription</a> --}}
        <form action="{{ route('subscriptions.deleteExpired') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Expired Subscriptions</button>
        </form>
    </div>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex justify-center">
        <table class="min-w-full bg-white shadow-md rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4">Member</th>
                    <th class="py-2 px-4">Start Date</th>
                    <th class="py-2 px-4">End Date</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr class="border-b">
                        <td class="py-2 px-4 text-center">{{ $subscription->member->name }}</td>
                        <td class="py-2 px-4 text-center">{{ $subscription->start_date }}</td>
                        <td class="py-2 px-4 text-center">{{ $subscription->end_date }}</td>
                        <td class="py-2 px-4 text-center">
                            @if (strtotime($subscription->end_date) < strtotime(now()))
                                Expired
                            @else
                                {{ $subscription->status }}
                            @endif
                        </td>
                        <td class="py-2 px-4 text-center">
                            <a href="{{ route('subscriptions.edit', $subscription) }}" class="text-yellow-500 ml-2">Edit</a>
                            <form action="{{ route('subscriptions.destroy', $subscription) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2">Delete</button>
                            </form>
                            @if ($subscription->status == 'valid')
                                <form action="{{ route('subscriptions.invalidate', $subscription) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-500 ml-2">Invalidate</button>
                                </form>
                            @else
                                <form action="{{ route('subscriptions.validate', $subscription) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-500 ml-2">Validate</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
