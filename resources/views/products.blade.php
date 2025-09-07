@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="text-center mb-14">
        <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
           bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
           leading-tight pb-2">
            Our Products
        </h1>
        <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
            Discover our wide range of customizable products, perfect for gifts, branding, and personal use.
        </p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 w-full max-w-7xl">

        @php
            $products = [
                ['name' => 'Shirts', 'icon' => 'shopping-bag', 'url' => 'shirts', 'color' => 'text-pink-500'],
                ['name' => 'ID Lace', 'icon' => 'link', 'url' => 'id-lace', 'color' => 'text-purple-500'],
                ['name' => 'IDs', 'icon' => 'identification', 'url' => 'ids', 'color' => 'text-blue-500'],
                ['name' => 'Magnets', 'icon' => 'cube', 'url' => 'magnets', 'color' => 'text-green-500'],
                ['name' => 'Keychains', 'icon' => 'key', 'url' => 'keychains', 'color' => 'text-amber-500'],
                ['name' => 'Business Cards', 'icon' => 'credit-card', 'url' => 'business-cards', 'color' => 'text-fuchsia-500'],
                ['name' => 'Invitations', 'icon' => 'envelope', 'url' => 'invitations', 'color' => 'text-sky-500'],
                ['name' => 'Button Pins', 'icon' => 'circle-stack', 'url' => 'button-pins', 'color' => 'text-orange-500'],
                ['name' => 'Caricature Standee', 'icon' => 'user', 'url' => 'caricature-standee', 'color' => 'text-rose-500'],
                ['name' => 'Tarpaulin', 'icon' => 'photo', 'url' => 'tarpaulin', 'color' => 'text-cyan-500'],
                ['name' => 'Car Stickers / Decals', 'icon' => 'truck', 'url' => 'car-stickers', 'color' => 'text-red-500'],
                ['name' => 'Waterproof Stickers', 'icon' => 'square-2-stack', 'url' => 'stickers', 'color' => 'text-indigo-500'],
                ['name' => 'Carabiner', 'icon' => 'paper-clip', 'url' => 'carabiner', 'color' => 'text-lime-500'],
                ['name' => 'Ring Bind Notebooks', 'icon' => 'book-open', 'url' => 'notebooks', 'color' => 'text-violet-500'],
                ['name' => 'Personalized Mouse Pad', 'icon' => 'computer-desktop', 'url' => 'mousepad', 'color' => 'text-blue-400'],
                ['name' => 'Personalized Tote Bag', 'icon' => 'briefcase', 'url' => 'tote-bag', 'color' => 'text-pink-500'],
            ];
        @endphp

        @foreach ($products as $product)
            <a href="{{ url('/products/' . $product['url']) }}" 
               class="group relative rounded-2xl transition transform duration-500 hover:-translate-y-2">
                
                <!-- gradient border wrapper -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>
                
                <!-- inner white box -->
                <div class="relative bg-white rounded-2xl shadow-md group-hover:shadow-2xl p-6 sm:p-8 flex flex-col items-center text-center transition duration-500">
                    <x-dynamic-component :component="'heroicon-o-' . $product['icon']" 
                        class="w-12 h-12 {{ $product['color'] }} mb-3 transition-transform duration-500 group-hover:scale-110" />
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ $product['name'] }}
                    </h2>
                </div>
            </a>
        @endforeach

    </div>
</div>
@endsection
