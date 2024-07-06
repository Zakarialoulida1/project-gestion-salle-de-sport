<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Salle de Sport</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 text-gray-900">
    <nav class="bg-white shadow">
        <div class="container bg-slate-300   mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('dashboard') }}" class="text-2xl font-semibold text-black">Gym Manager</a>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('dashboard') }}" class="text-xl text-black">Dashboard</a></li>
                    @auth('member')
                        @if (Auth::guard('member')->user()->role === 'admin')
                            <li><a href="{{ route('members.index') }}" class="text-white">Members</a></li>
                            <li><a href="{{ route('subscriptions.index') }}" class="text-white">Subscriptions</a></li>
                            <li><a href="{{ route('courses.index') }}" class="text-white">Courses</a></li>
                            <li><a href="{{ route('reservations.index') }}" class="text-white">Reservations</a></li>
                        @endif
                    @endauth
                </ul>
                <div>
                    @auth('member')
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-black p-3 rounded bg-red-500">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white p-3 rounded bg-blue-400">Login</a>
                        <a href="{{ route('register') }}" class="text-white p-3 rounded bg-blue-400 ml-4">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto  ">
        <div>
            
        </div>
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
