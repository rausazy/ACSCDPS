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

       <!-- Add Stocks Button -->
       <button class="flex items-center justify-center gap-2 px-10 py-3 
               rounded-xl bg-white border-1 border-black 
               text-gray-900 font-bold shadow-md 
               hover:bg-purple-100 hover:shadow-lg 
               transition transform hover:-translate-y-1 hover:scale-105
               mt-4 mr-4">
            <!-- Plus Sign as Text -->
            <span class="text-lg font-bold">+</span>
            <span class="text-sm">Add Stocks</span>
        </button>

    </div>

    <!-- Stocks Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 w-full max-w-7xl">

        @php
            $stocks = [
                ['name' => 'Shirts', 'icon' => 'shopping-bag', 'color' => 'text-pink-500'],
                ['name' => 'ID Lace', 'icon' => 'link', 'color' => 'text-purple-500'],
                ['name' => 'IDs', 'icon' => 'identification', 'color' => 'text-blue-500'],
                ['name' => 'Magnets', 'icon' => 'cube', 'color' => 'text-green-500'],
                ['name' => 'Keychains', 'icon' => 'key', 'color' => 'text-amber-500'],
                ['name' => 'Business Cards', 'icon' => 'credit-card', 'color' => 'text-fuchsia-500'],
                ['name' => 'Invitations', 'icon' => 'envelope', 'color' => 'text-sky-500'],
                ['name' => 'Button Pins', 'icon' => 'circle-stack', 'color' => 'text-orange-500'],
                ['name' => 'Caricature Standee', 'icon' => 'user', 'color' => 'text-rose-500'],
                ['name' => 'Tarpaulin', 'icon' => 'photo', 'color' => 'text-cyan-500'],
                ['name' => 'Car Stickers / Decals', 'icon' => 'truck', 'color' => 'text-red-500'],
                ['name' => 'Waterproof Stickers', 'icon' => 'square-2-stack', 'color' => 'text-indigo-500'],
                ['name' => 'Carabiner', 'icon' => 'paper-clip', 'color' => 'text-lime-500'],
                ['name' => 'Ring Bind Notebooks', 'icon' => 'book-open', 'color' => 'text-violet-500'],
                ['name' => 'Personalized Mouse Pad', 'icon' => 'computer-desktop', 'color' => 'text-blue-400'],
                ['name' => 'Personalized Tote Bag', 'icon' => 'briefcase', 'color' => 'text-pink-500'],
            ];
        @endphp

        @foreach ($stocks as $stock)
            <!-- Clickable Stock Box (frontend only) -->
            <a href="javascript:void(0)" class="group relative rounded-2xl transition transform duration-500 hover:-translate-y-2 cursor-pointer">
                
                <!-- gradient border wrapper -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>
                
                <!-- inner white box -->
                <div class="relative bg-white rounded-2xl shadow-md group-hover:shadow-2xl p-6 sm:p-8 flex flex-col items-center text-center transition duration-500">
                    <x-dynamic-component :component="'heroicon-o-' . $stock['icon']" 
                        class="w-12 h-12 {{ $stock['color'] }} mb-3 transition-transform duration-500 group-hover:scale-110" />
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ $stock['name'] }}
                    </h2>
                </div>
            </a>
        @endforeach

    </div>
</div>
@endsection
