@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start py-20
    [background-image:radial-gradient(circle,_rgba(0,0,0,0.05)_1px,_transparent_1px),_linear-gradient(to_bottom_right,_#f3e8ff,_#fce7f3,_#dbeafe)] 
    [background-size:20px_20px,_cover] px-4">

    <div class="sm:mx-auto sm:w-full sm:max-w-lg">
        <!-- Logo with white circle + shadow -->
        <div class="mx-auto bg-white rounded-full p-4 w-fit shadow-md">
            <img src="{{ asset('images/CinleiLogo.png') }}" alt="Logo" class="mx-auto h-20 w-auto" />
        </div>

        <h2 class="mt-2 text-center text-3xl font-extrabold text-purple-600 tracking-tight">
            <span id="form-title">Sign in to your account</span>
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            <span id="form-subtitle">Welcome back! Please login to continue.</span>
        </p>

        <!-- Tabs -->
        <div class="mt-4 flex justify-center space-x-4">
            <button id="login-tab" class="px-4 py-2 font-semibold rounded-md bg-purple-600 text-white hover:bg-purple-700 transition">
                Sign In
            </button>
            <button id="signup-tab" class="px-4 py-2 font-semibold rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                Sign Up
            </button>
        </div>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-6 border border-gray-100">

            <!-- Flash messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <x-heroicon-o-envelope class="h-5 w-5" />
                    </div>
                    <input type="email" name="email" required placeholder="Email address"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                </div>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <x-heroicon-o-lock-closed class="h-5 w-5" />
                    </div>
                    <input type="password" name="password" required placeholder="Password"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-gradient-to-r from-purple-600 to-pink-500 px-4 py-3 text-sm font-semibold text-white shadow-md hover:from-purple-700 hover:to-pink-600 transition duration-200">
                        Sign in
                    </button>
                </div>
            </form>

            <!-- Sign Up Form -->
            <form id="signup-form" action="{{ route('register') }}" method="POST" class="space-y-6 hidden">
                @csrf
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <x-heroicon-o-user class="h-5 w-5" />
                    </div>
                    <input type="text" name="name" required placeholder="Full Name"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                </div>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <x-heroicon-o-envelope class="h-5 w-5" />
                    </div>
                    <input type="email" name="email" required placeholder="Email address"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                </div>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <x-heroicon-o-lock-closed class="h-5 w-5" />
                    </div>
                    <input type="password" name="password" required placeholder="Password"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                </div>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <x-heroicon-o-lock-closed class="h-5 w-5" />
                    </div>
                    <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-gradient-to-r from-purple-600 to-pink-500 px-4 py-3 text-sm font-semibold text-white shadow-md hover:from-purple-700 hover:to-pink-600 transition duration-200">
                        Sign Up
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    const loginTab = document.getElementById('login-tab');
    const signupTab = document.getElementById('signup-tab');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const formTitle = document.getElementById('form-title');
    const formSubtitle = document.getElementById('form-subtitle');

    loginTab.addEventListener('click', () => {
        loginForm.classList.remove('hidden');
        signupForm.classList.add('hidden');
        loginTab.classList.add('bg-purple-600', 'text-white');
        loginTab.classList.remove('bg-gray-200', 'text-gray-700');
        signupTab.classList.add('bg-gray-200', 'text-gray-700');
        signupTab.classList.remove('bg-purple-600', 'text-white');
        formTitle.textContent = 'Sign in to your account';
        formSubtitle.textContent = 'Welcome back! Please login to continue.';
    });

    signupTab.addEventListener('click', () => {
        loginForm.classList.add('hidden');
        signupForm.classList.remove('hidden');
        signupTab.classList.add('bg-purple-600', 'text-white');
        signupTab.classList.remove('bg-gray-200', 'text-gray-700');
        loginTab.classList.add('bg-gray-200', 'text-gray-700');
        loginTab.classList.remove('bg-purple-600', 'text-white');
        formTitle.textContent = 'Create your account';
        formSubtitle.textContent = 'Sign up to start using your account.';
    });
</script>
@endsection
