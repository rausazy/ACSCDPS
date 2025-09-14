@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Back link -->
    <div class="w-full max-w-7xl mb-6">
        <a href="{{ route('services.services') }}" 
           class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Services
        </a>
    </div>

    <!-- Header -->
    <div class="text-center mb-14 w-full flex justify-center items-center space-x-4">
        <!-- Service Icon -->
        <x-dynamic-component :component="'heroicon-o-' . $service->icon" 
            class="w-12 h-12 {{ $service->color }}" />
        
        <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
            bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
            leading-tight pb-2">
            {{ $service->name }}
        </h1>
    </div>

    <!-- Optional Service Description -->
    @if($service->description)
        <p class="text-lg text-gray-700 max-w-3xl text-center mb-10">
            {{ $service->description }}
        </p>
    @endif

</div>
@endsection
