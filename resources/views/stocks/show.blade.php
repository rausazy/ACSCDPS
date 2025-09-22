@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Back link -->
    <div class="w-full max-w-7xl mb-6">
        <a href="{{ route('stocks.stocks') }}" 
           class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Stocks
        </a>
    </div>

    <!-- Header -->
    <div class="w-full max-w-7xl text-center mb-6">
        <div class="flex justify-center items-center space-x-4">
            @php
                $iconName = $stock->stockable ? 'heroicon-o-' . $stock->stockable->icon : 'heroicon-o-cube';
                $iconColor = $stock->stockable?->color ?? 'text-gray-500';
            @endphp
            <x-dynamic-component :component="$iconName" class="w-12 h-12 {{ $iconColor }}" />

            <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
                bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
                leading-tight pb-2">
                {{ $stock->name ?? optional($stock->stockable)->name ?? 'Unknown Item' }}
            </h1>
        </div>
    </div>

    <!-- Buttons -->
    <div class="w-full max-w-7xl flex justify-end mb-14 space-x-3">
        <button onclick="document.getElementById('addRawModal').classList.remove('hidden')" 
            class="flex items-center justify-center gap-2 px-6 py-2 
                   rounded-xl bg-gray-500 text-white font-bold shadow-md 
                   hover:bg-gray-600 hover:shadow-lg 
                   transition transform hover:-translate-y-1 hover:scale-105">
            + Add Raw Material
        </button>
    </div>

    <!-- Raw Materials List -->
    <div class="w-full max-w-7xl">
        <h2 class="text-2xl font-bold mb-4">Raw Materials</h2>

        @if($stock->rawMaterials->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($stock->rawMaterials as $raw)
                    <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $raw->name }}</h3>
                        <p class="text-sm text-gray-500">Quantity: {{ $raw->quantity }}</p>
                        <p class="text-sm text-gray-500">Price: ₱{{ number_format($raw->price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No raw materials added yet.</p>
        @endif
    </div>

    <!-- Add Raw Material Modal -->
    <div id="addRawModal" 
         class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-4">Add Raw Material</h2>

            <!-- Session Success Banner -->
            @if(session('success'))
                <div id="successBanner" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('raw-materials.store', $stock->id) }}">
                @csrf
                <!-- stock_id hidden -->
                <input type="hidden" name="stock_id" value="{{ $stock->id }}">

                <!-- Raw Material Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base">
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" required min="0"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base">
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required min="0"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base">
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('addRawModal').classList.add('hidden')" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600 transition w-full sm:w-auto">
                        Add Raw Material
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
