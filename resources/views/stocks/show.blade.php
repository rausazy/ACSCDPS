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

   <!-- ✅ Raw Materials List (HOSTED-SAFE LIST VIEW using inline CSS) -->
<div class="w-full max-w-7xl">
    <h2 class="text-2xl font-bold mb-4">Raw Materials</h2>

    @if($stock->rawMaterials->count())
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; box-shadow:0 6px 16px rgba(0,0,0,.08);">

            <!-- Header -->
            <div style="display:grid; grid-template-columns: 3fr 1fr 1fr 1fr 1.2fr; gap:14px;
                        padding:14px 18px; background:#f9fafb; border-bottom:1px solid #e5e7eb;
                        font-size:12px; font-weight:700; color:#6b7280;">
                <div>Name</div>
                <div>Qty</div>
                <div>Price</div>
                <div>Total</div>
                <div style="text-align:right;">Actions</div>
            </div>

            <!-- Rows -->
            @foreach($stock->rawMaterials as $raw)
                <div style="display:grid; grid-template-columns: 3fr 1fr 1fr 1fr 1.2fr; gap:14px;
                            padding:16px 18px; align-items:center; border-bottom:1px solid #e5e7eb;">

                    <div style="font-size:14px; font-weight:700; color:#111827;">
                        {{ $raw->name }}
                    </div>

                    <div style="font-size:14px; color:#374151;">
                        {{ $raw->quantity }}
                    </div>

                    <div style="font-size:14px; color:#374151;">
                        ₱{{ number_format($raw->price, 2) }}
                    </div>

                    <div style="font-size:14px; font-weight:700; color:#111827;">
                        ₱{{ number_format($raw->quantity * $raw->price, 2) }}
                    </div>

                    <div style="display:flex; justify-content:flex-end; gap:8px; flex-wrap:wrap;">
                        <!-- ✅ SAME onclick / SAME functions (hindi binago) -->
                        <button onclick="openEditModal({{ $raw->id }}, '{{ $raw->name }}', {{ $raw->quantity }}, {{ $raw->price }})"
                            style="padding:7px 12px; border-radius:10px; font-size:12px; font-weight:700;
                                   color:#fff; background:rgb(59 130 246); border:none; cursor:pointer;">
                            Edit
                        </button>

                        <button type="button"
                            onclick="openDeleteModal({{ $raw->id }}, '{{ $raw->name }}')"
                            style="padding:7px 12px; border-radius:10px; font-size:12px; font-weight:700;
                                   color:#fff; background:rgb(239 68 68); border:none; cursor:pointer;">
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

    <!-- ✅ Add Raw Material Modal -->
    <div id="addRawModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6">
            <h2 class="text-2xl font-bold mb-4">Add Raw Material</h2>

            <form method="POST" action="{{ route('raw-materials.store', $stock->id) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <!-- ✅ Checkbox to toggle sizes -->
                <div style="margin-top: 16px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="has_sizes" name="has_sizes" style="height:16px; width:16px; accent-color:#9333ea; cursor:pointer;">
                    <label for="has_sizes" style="color:#374151; font-weight:500; cursor:pointer;">Has Sizes?</label>
                </div>

                <!-- Normal Fields (hidden if sizes enabled) -->
                <div id="normalFields">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Quantity</label>
                        <input type="number" name="quantity" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Price</label>
                        <input type="number" step="0.01" name="price" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <!-- Sizes Section -->
                <div id="sizesSection" class="hidden">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-gray-700 font-medium">Sizes</label>
                        <button type="button" onclick="addSizeRow()" 
                            class="text-sm px-2 py-1 bg-purple-600 text-white rounded-md">
                            + Add Size
                        </button>
                    </div>
                   <div id="sizesContainer" class="space-y-2" 
                        style="margin-top:12px; margin-bottom:12px; display:flex; flex-direction:column; gap:8px;">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('addRawModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-700 transition w-full sm:w-auto">
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
                        style="background-color: rgb(59 130 246);">
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
                        style="background-color: rgb(239 68 68); margin-left: 0.5rem;">
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
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <input type="text" name="sizes[${sizeIndex}][name]" placeholder="Size" 
                    style="flex:1; min-width:80px; max-width:120px; padding:6px 10px; 
                           border:1px solid #d1d5db; border-radius:6px; font-size:14px;" required>

                <input type="number" name="sizes[${sizeIndex}][quantity]" placeholder="Quantity" min="0"
                    style="flex:1; min-width:100px; max-width:120px; padding:6px 10px; 
                           border:1px solid #d1d5db; border-radius:6px; font-size:14px;" required>

                <input type="number" step="0.01" name="sizes[${sizeIndex}][price]" placeholder="Price" min="0"
                    style="flex:1; min-width:100px; max-width:140px; padding:6px 10px; 
                           border:1px solid #d1d5db; border-radius:6px; font-size:14px;" required>
            </div>
        `;
        sizesContainer.appendChild(div);
        sizeIndex++;
    }

    // Edit & Delete Modal (✅ SAME FUNCTIONS - NOT CHANGED)
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