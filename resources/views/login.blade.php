@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start py-20
    [background-image:radial-gradient(circle,_rgba(0,0,0,0.05)_1px,_transparent_1px),_linear-gradient(to_bottom_right,_#f3e8ff,_#fce7f3,_#dbeafe)] 
    [background-size:20px_20px,_cover] px-4">

    <div class="sm:mx-auto sm:w-full sm:max-w-lg">
        <img src="{{ asset('images/CinleiLogo.png') }}" alt="Your Company" class="mx-auto h-20 w-auto" />
        <h2 class="mt-2 text-center text-3xl font-extrabold text-purple-600 tracking-tight">
            Sign in to your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Welcome back! Please login to continue.
        </p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-6 border border-gray-100">
            <form action="#" method="POST" class="space-y-6">
                <div class="relative">
                    <label for="email" class="sr-only">
                        Email address
                    </label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <x-heroicon-o-envelope class="h-5 w-5" />
                        </div>
                        <input id="email" type="email" name="email" required autocomplete="email" 
                            placeholder="Email address"
                            class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                    </div>
                </div>

                <div class="relative">
                    <div class="flex items-center justify-between">
                        <label for="password" class="sr-only">
                            Password
                        </label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-purple-600 hover:text-purple-800">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <x-heroicon-o-lock-closed class="h-5 w-5" />
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            placeholder="Password"
                            class="block w-full rounded-md border border-gray-300 bg-gray-100 py-3 pl-11 pr-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none sm:text-sm" />
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="flex w-full justify-center rounded-md bg-gradient-to-r from-purple-600 to-pink-500 px-4 py-3 text-sm font-semibold text-white shadow-md hover:from-purple-700 hover:to-pink-600 transition duration-200">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection