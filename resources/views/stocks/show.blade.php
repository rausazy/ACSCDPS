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
    <div class="w-full max-w-7xl text-center mb-10">
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

    <!-- Add Button -->
    <div class="w-full max-w-7xl flex justify-end mb-10">
    <button 
        onclick="document.getElementById('addRawModal').classList.remove('hidden')" 
        class="flex items-center justify-center gap-2
               px-12 py-4
               min-w-[240px]
               rounded-xl 
               bg-white text-gray-900 font-bold text-sm
               shadow-md
               transition-all duration-300 ease-in-out
               hover:bg-purple-100
               hover:shadow-lg
               hover:-translate-y-1
               hover:scale-105">
        <span class="text-lg font-bold">+</span>
        <span>Add Raw Material</span>
    </button>
</div>

    <!-- =============================== -->
    <!-- ✅ RAW MATERIALS LIST VIEW -->
    <!-- =============================== -->
    <div class="w-full max-w-7xl">
        <h2 class="text-2xl font-bold mb-4">Raw Materials</h2>

        @if($stock->rawMaterials->count())
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,.06);">

                <!-- Header -->
                <div style="display:grid; grid-template-columns: 3fr 1fr 1fr 1fr 1fr; gap:12px; padding:12px 16px; background:#f9fafb; border-bottom:1px solid #e5e7eb; font-size:12px; font-weight:700; color:#6b7280;">
                    <div>Name</div>
                    <div>Qty</div>
                    <div>Price</div>
                    <div>Total</div>
                    <div style="text-align:right;">Actions</div>
                </div>

                <!-- Rows -->
                @foreach($stock->rawMaterials as $raw)
                    <div style="display:grid; grid-template-columns: 3fr 1fr 1fr 1fr 1fr; gap:12px; padding:14px 16px; align-items:center; border-bottom:1px solid #e5e7eb;">

                        <div style="font-size:14px; font-weight:600; color:#1f2937;">
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
                            <button
                                onclick="openEditModal({{ $raw->id }}, '{{ $raw->name }}', {{ $raw->quantity }}, {{ $raw->price }})"
                                style="padding:6px 10px; border-radius:8px; font-size:12px; color:#fff; background:rgb(59 130 246); border:none; cursor:pointer;">
                                Edit
                            </button>

                            <button
                                type="button"
                                onclick="openDeleteModal({{ $raw->id }}, '{{ $raw->name }}')"
                                style="padding:6px 10px; border-radius:8px; font-size:12px; color:#fff; background:rgb(239 68 68); border:none; cursor:pointer;">
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

    <!-- =============================== -->
    <!-- ADD MODAL -->
    <!-- =============================== -->
    <div id="addRawModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4">Add Raw Material</h2>

            <form method="POST" action="{{ route('raw-materials.store', $stock->id) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" min="0"
                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Price</label>
                    <input type="number" step="0.01" name="price" min="0"
                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="document.getElementById('addRawModal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-700">
                        Add Raw Material
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function openEditModal(id, name, quantity, price){
    const modal = document.getElementById('editRawModal');
    if(modal){
        modal.classList.remove('hidden');
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_price').value = price;
        document.getElementById('editRawForm').action = `/raw-materials/${id}`;
    }
}

function openDeleteModal(id, name){
    const modal = document.getElementById('deleteRawModal');
    if(modal){
        modal.classList.remove('hidden');
        document.getElementById('deleteRawName').innerText = name;
        document.getElementById('deleteRawForm').action = `/raw-materials/${id}`;
    }
}
</script>

@endsection