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
        <button onclick="document.getElementById('addStockModal').classList.remove('hidden')" 
            class="flex items-center justify-center gap-2 px-6 py-2 
                   rounded-xl bg-gray-500 text-white font-bold shadow-md 
                   hover:bg-gray-600 hover:shadow-lg 
                   transition transform hover:-translate-y-1 hover:scale-105">
            + Add New
        </button>
    </div>

    <!-- Add New Stock Modal -->
    <div id="addStockModal" 
         class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-4">Add New Stock</h2>

            <!-- Session Success Banner -->
            @if(session('success'))
                <div id="successBanner" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('stocks.store') }}">
                @csrf

                <!-- Stock Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base">
                </div>

                <!-- Has Sizes Toggle -->
                <div class="mb-4 flex items-center space-x-2">
                    <input type="checkbox" id="hasSizesToggle" class="h-4 w-4 text-green-600" {{ old('has_sizes') ? 'checked' : '' }}>
                    <label for="hasSizesToggle" class="text-gray-700 font-medium">Has Sizes?</label>
                </div>

                <!-- Sizes Inputs -->
                <div id="sizesContainer" class="hidden mb-4 space-y-3 border border-gray-200 p-3 rounded-md">
                    <p class="text-gray-600 text-sm mb-2">Enter sizes and their quantities:</p>
                    <div id="sizeFields">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="sizes[0][size_name]" placeholder="Size e.g. S, M, L" class="flex-1 border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <input type="number" name="sizes[0][quantity]" placeholder="Quantity" min="0" class="w-24 border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <button type="button" class="text-red-500 font-bold remove-size">&times;</button>
                        </div>
                    </div>
                    <button type="button" id="addSize" class="mt-2 px-3 py-1 bg-gray-200 rounded-md text-sm hover:bg-gray-300">+ Add Size</button>
                </div>

                <!-- Single Quantity -->
                <div id="singleQuantity" class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base">
                </div>

                <!-- Price per Piece -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Price per Piece</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base">
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('addStockModal').classList.add('hidden')" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600 transition w-full sm:w-auto">
                        Add Stock
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    const hasSizesToggle = document.getElementById('hasSizesToggle');
    const sizesContainer = document.getElementById('sizesContainer');
    const singleQuantity = document.getElementById('singleQuantity');

    hasSizesToggle.addEventListener('change', () => {
        sizesContainer.classList.toggle('hidden', !hasSizesToggle.checked);
        singleQuantity.classList.toggle('hidden', hasSizesToggle.checked);
    });

    // Add/remove dynamic size fields
    let sizeIndex = 1;
    document.getElementById('addSize').addEventListener('click', function(){
        const container = document.getElementById('sizeFields');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 mt-1';
        div.innerHTML = `
            <input type="text" name="sizes[${sizeIndex}][size_name]" placeholder="Size e.g. S, M, L" class="flex-1 border border-gray-300 rounded-md px-2 py-1 text-sm">
            <input type="number" name="sizes[${sizeIndex}][quantity]" placeholder="Quantity" min="0" class="w-24 border border-gray-300 rounded-md px-2 py-1 text-sm">
            <button type="button" class="text-red-500 font-bold remove-size">&times;</button>
        `;
        container.appendChild(div);
        sizeIndex++;

        div.querySelector('.remove-size').addEventListener('click', () => div.remove());
    });

    document.querySelectorAll('.remove-size').forEach(btn => {
        btn.addEventListener('click', e => e.target.parentElement.remove());
    });
</script>
@endsection
