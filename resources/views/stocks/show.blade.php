@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- ✅ Global Success Banner -->
    @if(session('success'))
        <div id="success-banner" class="mb-6 w-full max-w-7xl transition-opacity duration-500 opacity-100">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif

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

    <!-- ✅ Buttons -->
    <div class="w-full max-w-7xl flex justify-end mb-14 space-x-3">
        <button 
            onclick="document.getElementById('addRawModal').classList.remove('hidden')" 
            class="flex items-center justify-center gap-2 px-4 py-2 sm:px-10 sm:py-3
                   rounded-xl bg-white
                   text-gray-900 font-bold shadow-md
                   hover:bg-purple-100 hover:shadow-lg
                   transition transform hover:-translate-y-1 hover:scale-105">
            <span class="text-lg sm:text-lg font-bold">+</span>
            <span class="text-xs sm:text-sm">Add Raw Material</span>
        </button>
    </div>

    <!-- Overall Stats -->
    @php
        $overallQuantity = $stock->rawMaterials->sum('quantity');
        $overallTotalPrice = $stock->rawMaterials->sum(function($raw) { return $raw->quantity * $raw->price; });
    @endphp
    <div class="w-full max-w-7xl flex justify-between items-center mb-6">
        <p class="text-gray-700 font-medium">Overall Quantity: {{ $overallQuantity }}</p>
        <p class="text-gray-700 font-medium">Overall Total Price: ₱{{ number_format($overallTotalPrice, 2) }}</p>
    </div>

    <!-- Raw Materials List -->
    <div class="w-full max-w-7xl">
        <h2 class="text-2xl font-bold mb-4">Raw Materials</h2>

        @if($stock->rawMaterials->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($stock->rawMaterials as $raw)
                    <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $raw->name }}</h3>
                            <p class="text-sm text-gray-500">Quantity: {{ $raw->quantity }}</p>
                            <p class="text-sm text-gray-500">Price: ₱{{ number_format($raw->price, 2) }}</p>
                            <p class="text-sm text-gray-500 font-semibold">
                                Total: ₱{{ number_format($raw->quantity * $raw->price, 2) }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
<div class="flex justify-end mt-4">
    <button onclick="openEditModal({{ $raw->id }}, '{{ $raw->name }}', {{ $raw->quantity }}, {{ $raw->price }})"
        class="px-3 py-1 rounded-md bg-blue-500 text-white text-sm hover:bg-blue-600 transition mr-2"
        style="background-color: rgb(59 130 246);"> <!-- bg-blue-500 -->
        Edit
    </button>

    <button type="button" 
        onclick="openDeleteModal({{ $raw->id }}, '{{ $raw->name }}')"
        class="px-3 py-1 rounded-md bg-red-500 text-white text-sm hover:bg-red-600 transition"
        style="background-color: rgb(239 68 68);"> <!-- bg-red-500 -->
        Delete
    </button>
</div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No raw materials added yet.</p>
        @endif
    </div>

    <!-- Add Raw Material Modal -->
    <div id="addRawModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-4">Add Raw Material</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('raw-materials.store', $stock->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" min="0"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" min="0"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('addRawModal').classList.add('hidden')" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-700 transition w-full sm:w-auto">
                        Add Raw Material
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Raw Material Modal -->
    <div id="editRawModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Raw Material</h2>
            <form id="editRawForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Quantity</label>
                    <input type="number" id="edit_quantity" name="quantity" min="0" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Price</label>
                    <input type="number" step="0.01" id="edit_price" name="price" min="0" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('editRawModal').classList.add('hidden')" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto">
                        Cancel
                    </button>
                <button type="submit" 
                    class="px-4 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition w-full sm:w-auto"
                    style="background-color: rgb(59 130 246);"> <!-- bg-blue-500 -->
                    Update
                </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteRawModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-6 text-center">
            <h2 class="text-xl font-bold mb-2 text-gray-800">Delete Raw Material</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete <span id="deleteRawName" class="font-semibold"></span>? This action cannot be undone.</p>

            <form id="deleteRawForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="document.getElementById('deleteRawModal').classList.add('hidden')" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 rounded-md bg-red-500 text-white hover:bg-red-600 transition w-full sm:w-auto"
                        style="background-color: rgb(239 68 68); margin-left: 0.5rem;"> <!-- bg-red-500 -->
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Scripts -->
<script>
    // Toggle Sizes
    const hasSizes = document.getElementById('has_sizes');
    const normalFields = document.getElementById('normalFields');
    const sizesSection = document.getElementById('sizesSection');
    const sizesContainer = document.getElementById('sizesContainer');

    hasSizes?.addEventListener('change', () => {
        if(hasSizes.checked){
            normalFields.classList.add('hidden');
            sizesSection.classList.remove('hidden');
        } else {
            normalFields.classList.remove('hidden');
            sizesSection.classList.add('hidden');
        }
    });

    let sizeIndex = 0;
    function addSizeRow(){
        const div = document.createElement('div');
        div.classList.add('flex', 'space-x-2');
        div.innerHTML = `
            <input type="text" name="sizes[${sizeIndex}][name]" placeholder="Size" class="w-1/3 border rounded-md px-2 py-1" required>
            <input type="number" name="sizes[${sizeIndex}][quantity]" placeholder="Quantity" class="w-1/3 border rounded-md px-2 py-1" min="0" required>
            <input type="number" step="0.01" name="sizes[${sizeIndex}][price]" placeholder="Price" class="w-1/3 border rounded-md px-2 py-1" min="0" required>
        `;
        sizesContainer.appendChild(div);
        sizeIndex++;
    }

    // Edit & Delete Modal
    function openEditModal(id, name, quantity, price){
        const modal = document.getElementById('editRawModal');
        modal.classList.remove('hidden');
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_price').value = price;
        document.getElementById('editRawForm').action = `/raw-materials/${id}`;
    }

    function openDeleteModal(id, name){
        const modal = document.getElementById('deleteRawModal');
        modal.classList.remove('hidden');
        document.getElementById('deleteRawName').innerText = name;
        document.getElementById('deleteRawForm').action = `/raw-materials/${id}`;
    }

    // Auto-hide success
    const successBanner = document.getElementById('success-banner');
    if(successBanner){
        setTimeout(()=>{
            successBanner.classList.add('opacity-0');
            setTimeout(()=> successBanner.remove(),500);
        },3000);
    }
</script>
@endsection
