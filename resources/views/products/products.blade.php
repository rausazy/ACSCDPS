@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16 px-4 sm:px-6 lg:px-8">

    <!-- Success Banner -->
    @if(session('success'))
        <div id="success-banner" class="mb-6 w-full max-w-7xl px-4 transition-opacity duration-500 opacity-0">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="text-left mb-14 w-full flex justify-between items-center">
        <div>
            <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
               bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
               leading-tight pb-2">
                Our Products
            </h1>
            <p class="mt-4 text-lg text-gray-700 max-w-2xl leading-relaxed">
                Discover our wide range of customizable products.
            </p>
        </div>
        <!-- Open Modal Button -->
        <button id="open-modal" 
            class="ml-4 rounded-lg bg-purple-600 text-white px-4 py-2 font-semibold hover:bg-purple-700 transition">
            + Add Product
        </button>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 w-full max-w-7xl">
        @foreach ($products as $product)
        <div class="relative group">
            <!-- Delete Button -->
            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                  class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                @csrf
                @method('DELETE')
                <button type="button"
                        class="delete-btn bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition"
                        data-name="{{ $product->name }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </form>

            <a href="{{ url('/products/' . $product->url) }}" 
               class="group relative rounded-2xl transition transform duration-500 hover:-translate-y-2 block">
                
                <!-- gradient border wrapper -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>
                
                <!-- inner white box -->
                <div class="relative bg-white rounded-2xl shadow-md group-hover:shadow-2xl p-6 sm:p-8 flex flex-col items-center text-center transition duration-500">
                    <x-dynamic-component :component="'heroicon-o-' . $product->icon" 
                        class="w-12 h-12 {{ $product->color }} mb-3 transition-transform duration-500 group-hover:scale-110" />
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ $product->name }}
                    </h2>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Product Modal -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300">
        <h2 class="text-2xl font-bold mb-4">Add Product</h2>

        {{-- Error Banner (Duplicate name, etc.) --}}
        @if ($errors->any())
            <div id="error-banner" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative transition-opacity duration-500">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="add-product-form" action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Product Name</label>
                <input type="text" name="name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Icon</label>

                @php
                $icons = [
                    'shopping-bag' => 'Shopping Bag',
                    'link' => 'Link',
                    'identification' => 'Identification',
                    'cube' => 'Cube',
                    'key' => 'Key',
                    'credit-card' => 'Credit Card',
                    'envelope' => 'Envelope',
                    'circle-stack' => 'Circle Stack',
                    'user' => 'User',
                    'photo' => 'Photo',
                    'truck' => 'Truck',
                    'square-2-stack' => 'Stack',
                    'paper-clip' => 'Paper Clip',
                    'book-open' => 'Book Open',
                    'computer-desktop' => 'Computer',
                    'briefcase' => 'Briefcase',
                ];
                asort($icons);
                @endphp

                <select name="icon" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    @foreach($icons as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" id="cancel-modal"
                    class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-700 transition">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300">
        <h2 class="text-xl font-bold mb-4">Delete Product</h2>
        <p class="mb-4" id="delete-product-name">Are you sure you want to delete this product?</p>
        <div class="flex justify-end space-x-2">
            <button type="button" id="cancel-delete" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">Cancel</button>
            <button type="button" id="confirm-delete" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition">Delete</button>
        </div>
    </div>
</div>

<script>
    // ----- ERROR BANNER AUTO-HIDE -----
    const errorBanner = document.getElementById('error-banner');
    if (errorBanner) {
        setTimeout(() => {
            errorBanner.classList.add('opacity-0');
            setTimeout(() => errorBanner.remove(), 500);
        }, 2000);
    }

    // ----- BANNERS FADE-IN/OUT -----
    ['success-banner','delete-banner'].forEach(id => {
        const banner = document.getElementById(id);
        if(banner){
            banner.classList.add('opacity-0');
            setTimeout(() => banner.classList.remove('opacity-0'), 10);
            setTimeout(() => {
                banner.classList.add('opacity-0');
                setTimeout(() => banner.remove(), 500);
            }, 2000);
        }
    });

    // ----- ADD PRODUCT MODAL -----
    const openModalBtn = document.getElementById('open-modal');
    const modal = document.getElementById('modal');
    const cancelModalBtn = document.getElementById('cancel-modal');
    const addProductForm = document.getElementById('add-product-form');
    const modalContent = modal.querySelector('div');

    function openModal() {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100', 'opacity-0');
        setTimeout(() => modalContent.classList.remove('opacity-0'), 10);
    }

    function closeModal() {
        modalContent.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }, 300);
    }

    openModalBtn.addEventListener('click', openModal);
    cancelModalBtn.addEventListener('click', closeModal);
    addProductForm.addEventListener('submit', () => closeModal());

    // Auto open modal if there are errors
    @if ($errors->any())
        openModal();
    @endif

    // ----- DELETE MODAL -----
    const deleteModal = document.getElementById('delete-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    let deleteForm;

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            deleteForm = btn.closest('form');
            const productName = btn.dataset.name;
            document.getElementById('delete-product-name').textContent = `Are you sure you want to delete "${productName}"?`;

            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            const content = deleteModal.querySelector('div');
            content.classList.remove('scale-95');
            content.classList.add('scale-100', 'opacity-0');
            setTimeout(() => content.classList.remove('opacity-0'), 10);
        });
    });

    cancelDeleteBtn.addEventListener('click', () => {
        const content = deleteModal.querySelector('div');
        content.classList.add('opacity-0');
        setTimeout(() => {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
        }, 300);
    });

    confirmDeleteBtn.addEventListener('click', () => {
        if(deleteForm) deleteForm.submit();
    });
</script>
@endsection
