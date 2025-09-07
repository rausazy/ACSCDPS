@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="text-center mb-14">
        <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
           bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
           leading-tight pb-2">
            Our Services
        </h1>
        <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
            We provide fast and reliable services to meet your daily business and personal needs.
        </p>
    </div>

    <!-- Services Grid (3 top, 2 bottom) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 sm:gap-8 w-full max-w-5xl">

        @php
            $services = [
                ['name' => 'Photocopy', 'icon' => 'document-duplicate', 'url' => 'photocopy', 'color' => 'text-purple-500'],
                ['name' => 'Printing', 'icon' => 'printer', 'url' => 'printing', 'color' => 'text-blue-500'],
                ['name' => 'Lamination', 'icon' => 'rectangle-stack', 'url' => 'lamination', 'color' => 'text-green-500'],
                ['name' => 'Scan', 'icon' => 'document-text', 'url' => 'scan', 'color' => 'text-amber-500'],
                ['name' => 'Rush ID', 'icon' => 'identification', 'url' => 'rush-id', 'color' => 'text-pink-500'],
            ];
        @endphp

        @foreach ($services as $service)
            <a href="{{ url('/services/' . $service['url']) }}" 
               class="group relative rounded-2xl transition transform duration-500 hover:-translate-y-2">
                
                <!-- gradient border wrapper -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>
                
                <!-- inner white box -->
                <div class="relative bg-white rounded-2xl shadow-md group-hover:shadow-2xl p-6 sm:p-8 flex flex-col items-center text-center transition duration-500">
                    <x-dynamic-component :component="'heroicon-o-' . $service['icon']" 
                        class="w-12 h-12 {{ $service['color'] }} mb-3 transition-transform duration-500 group-hover:scale-110" />
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ $service['name'] }}
                    </h2>
                </div>
            </a>
        @endforeach

    </div>
</div>
@endsection
