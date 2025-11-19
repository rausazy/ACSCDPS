@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full max-w-7xl mb-14">
        <div class="max-w-2xl mb-6 sm:mb-0 text-center sm:text-left">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
               bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
               leading-tight pb-2">
                History
            </h1>
            <p class="mt-2 sm:mt-4 text-sm sm:text-lg text-gray-700 leading-relaxed">
                A record of your past activities and system logs.
            </p>
        </div>
    </div>

</div>
@endsection
