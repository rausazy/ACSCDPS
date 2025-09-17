@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Header + Add Stocks Button -->
    <div class="flex items-center justify-between w-full max-w-7xl mb-14">
        <div>
            <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
               bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
               leading-tight pb-2">
                Stocks
            </h1>
            <p class="mt-2 text-lg text-gray-700 leading-relaxed">
                Manage and track your available stocks efficiently.
            </p>
        </div>
    </div>

    <!-- Stocks Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 w-full max-w-7xl">
        @foreach ($stocks as $stock)
            <!-- Stock Card (clickable to show page) -->
            <a href="{{ route('stocks.show', $stock->id) }}" 
               class="group relative rounded-2xl transition transform duration-500 hover:-translate-y-2 cursor-pointer">
                
                <!-- gradient border wrapper -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>
                
                <!-- inner white box -->
                <div class="relative bg-white rounded-2xl shadow-md group-hover:shadow-2xl p-6 sm:p-8 flex flex-col items-center text-center transition duration-500">
                    <x-dynamic-component 
                        :component="'heroicon-o-' . (optional($stock->stockable)->icon ?? 'cube')" 
                        class="w-12 h-12 {{ optional($stock->stockable)->color ?? 'text-gray-500' }} mb-3 transition-transform duration-500 group-hover:scale-110" />
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ optional($stock->stockable)->name ?? $stock->name }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Quantity: {{ $stock->quantity }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
