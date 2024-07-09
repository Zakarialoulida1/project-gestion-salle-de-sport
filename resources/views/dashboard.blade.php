@extends('layouts.app')
 
@section('content')

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
<div class="mb-8  shadow-lg relative" style="background-image: url('{{ asset('storage/images/gym.png') }}');opacity:80%;  background-size: cover; background-position: center; height: 100vh;">
    <div class="absolute inset-x-0 bottom-44 flex justify-center  my-auto mx-auto text-md md:text-7xl md:w-[40vw] text-bold text-black">
        <h1 class="text-center"> REJOIGNEZ LE LEADER DU FITNESS
            AU MAROC</h1>
    </div>
    <div class="absolute inset-x-0 bottom-4 flex justify-center">
     
        <a href="{{ route('subscriptions.create') }}" class="bg-orange-500 text-white py-3 px-6 rounded-full text-lg hover:bg-orange-600">S'abonner</a>
    </div>
</div>
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Available Courses</h1>
        <div class="grid grid-cols-1 ">
            @php
                $colors = ['bg-red-500', 'bg-green-500', 'bg-blue-500', 'bg-yellow-500', 'bg-purple-500'];
            @endphp
            @foreach ($courses as $index => $course)
                <div class="relative {{ $colors[$index % count($colors)] }} text-white p-8  shadow-lg overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-black opacity-50 pointer-events-none"></div>
                    <div class="relative z-10 md:absolute top-4 right-4">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-96 h-64 object-cover rounded-md">
                        @else
                            <img src="default-image.jpg" alt="{{ $course->name }}" class="w-32 h-32 object-cover rounded-md">
                        @endif
                    </div>
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold">{{ $course->name }}</h2>
                        <p class="mt-2 text-xl">{{ Str::limit($course->description, 100) }}</p>
                        <div class="mt-4 text-lg">
                            <span class="block">Instructor: {{ $course->instructor }}</span>
                            <span class="block">Start Time: {{ $course->start_time }}</span>
                            <span class="block">End Time: {{ $course->end_time }}</span>
                        </div>
                        <div class="flex justify-center w-2/3 items-center">
                            <a href="{{ route('courses.show', $course) }}" class="inline-block mt-6 center z-20 bg-orange-500 text-white py-2 px-4 rounded-full hover:bg-orange-600">Essayer l'activité</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
