@extends('layouts.app')

@section('content')
@php
    $icons = [
        'document-duplicate' => 'Photocopy',
        'printer' => 'Printing',
        'rectangle-stack' => 'Lamination',
        'document-text' => 'Scan',
        'identification' => 'Rush ID',
    ];
    asort($icons);
@endphp

{{-- styling-only tweaks (same as products look) --}}
<style>
    /* fallback: show action buttons on hover even if group-hover fails in hosting */
    .service-card:hover .action-buttons { opacity: 1 !important; }

    /* smoother card feel */
    .service-card a { will-change: transform; }

    /* nicer buttons look */
    .action-btn-pill{
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
</style>

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
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full max-w-7xl mb-14 gap-4">
        <div class="max-w-2xl mb-6 sm:mb-0 text-center sm:text-left">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
               bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
               leading-tight pb-2">
                Our Services
            </h1>
            <p class="mt-2 sm:mt-4 text-sm sm:text-lg text-gray-700 leading-relaxed">
                We provide fast and reliable services to meet your daily business and personal needs.
            </p>
        </div>

        <!-- Right Side Controls -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 w-full sm:w-auto">

            <!-- Search Bar -->
            <input type="text" id="serviceSearch"
                placeholder="Search services..."
                class="w-full sm:w-72 border border-gray-300 rounded-xl px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-purple-500
                       text-sm sm:text-base shadow-sm">

            <!-- Add Service Button -->
            <button id="open-modal" 
                class="flex items-center justify-center gap-2 px-4 py-2 sm:px-10 sm:py-3 
                       rounded-xl bg-white border-1 border-black 
                       text-gray-900 font-bold shadow-md 
                       hover:bg-purple-100 hover:shadow-lg 
                       transition transform hover:-translate-y-1 hover:scale-105">
                <span class="text-lg sm:text-lg font-bold">+</span>
                <span class="text-xs sm:text-sm">Add Service</span>
            </button>
        </div>
    </div>

    <!-- Services Grid -->
    <div id="servicesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 w-full max-w-7xl">
        @foreach ($services as $service)
        <div class="relative group service-card"
             data-name="{{ strtolower($service->name) }}">

            <!-- Action Buttons (Edit + Delete) - same look as products -->
            <div class="action-buttons absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">

                <!-- Edit Button -->
                <button type="button"
                        class="edit-btn action-btn-pill bg-white/85 text-blue-700 rounded-full p-2 shadow-sm ring-1 ring-black/5
                               hover:bg-white hover:shadow-md hover:ring-blue-200 transition"
                        data-id="{{ $service->id }}"
                        data-name="{{ $service->name }}"
                        data-icon="{{ $service->icon }}"
                        title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.862 4.487l1.651 1.651a2.121 2.121 0 010 3L8.25 19.4l-4 1 1-4L16.862 4.487z" />
                    </svg>
                </button>

                <!-- Delete Form -->
                <form action="{{ route('services.destroy', $service->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="delete-btn action-btn-pill bg-white/85 text-red-600 rounded-full p-2 shadow-sm ring-1 ring-black/5
                                   hover:bg-white hover:shadow-md hover:ring-red-200 transition"
                            data-name="{{ $service->name }}"
                            title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>

            </div>

            <a href="{{ route('services.show', $service->url) }}" 
               class="group relative rounded-2xl block transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                
                <!-- gradient border wrapper (SUBTLE, no blur) -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500
                            opacity-0 group-hover:opacity-20 transition duration-300"></div>
                
                <!-- inner white box -->
                <div class="relative bg-white rounded-2xl shadow-md p-4 sm:p-6 flex flex-col items-center text-center transition duration-300">
                    <x-dynamic-component 
                        :component="'heroicon-o-' . $service->icon"
                        class="w-10 h-10 sm:w-12 sm:h-12 stroke-current {{ $service->color }} mb-3
                               transition-transform duration-300 group-hover:scale-105" />
                    
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">
                        {{ $service->name }}
                    </h2>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- No Results Message -->
    <div id="noServiceResults" class="hidden mt-10 text-gray-500 text-lg">
        No services found.
    </div>

</div>

<!-- Add Service Modal -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6 transform scale-95 transition-transform duration-300">
        <h2 class="text-2xl font-bold mb-4">Add Service</h2>

        {{-- Error Banner --}}
        @if ($errors->any())
            <div id="error-banner" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative transition-opacity duration-500">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="add-service-form" action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Service Name</label>
                <input type="text" name="name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Icon</label>
                <select name="icon" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
                    @foreach($icons as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                <button type="button" id="cancel-modal"
                    class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto text-sm sm:text-base">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-700 transition w-full sm:w-auto text-sm sm:text-base">
                    Add Service
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Service Modal -->
<div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6 transform scale-95 transition-transform duration-300">
        <h2 class="text-2xl font-bold mb-4">Edit Service</h2>

        <form id="edit-service-form" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Service Name</label>
                <input type="text" id="edit-name" name="name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Icon</label>
                <select id="edit-icon" name="icon"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm sm:text-base">
                    @foreach($icons as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                <button type="button" id="cancel-edit"
                    class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto text-sm sm:text-base">
                    Cancel
                </button>
                <button type="submit"
                style="background:#2563eb !important;color:#fff !important;border:2 !important;
                        padding:8px 16px;border-radius:6px;display:inline-block;font-weight:600;">
                Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs sm:max-w-md p-4 sm:p-6 transform scale-95 transition-transform duration-300">
        <h2 class="text-xl font-bold mb-4">Delete Service</h2>
        <p class="mb-4 text-sm sm:text-base" id="delete-service-name">Are you sure you want to delete this service?</p>
        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
            <button type="button" id="cancel-delete" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition w-full sm:w-auto text-sm sm:text-base">Cancel</button>
            <button type="button" id="confirm-delete" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition w-full sm:w-auto text-sm sm:text-base">Delete</button>
        </div>
    </div>
</div>

<script>
    // ===== HELPERS: LOCK/UNLOCK BACKGROUND (MOBILE CLICK/SCROLL) =====
    function lockBody() {
        document.body.classList.add('overflow-hidden', 'touch-none');
    }

    function unlockBody() {
        document.body.classList.remove('overflow-hidden', 'touch-none');
    }

    // ----- ERROR BANNER AUTO-HIDE -----
    const errorBanner = document.getElementById('error-banner');
    if (errorBanner) {
        setTimeout(() => {
            errorBanner.classList.add('opacity-0');
            setTimeout(() => errorBanner.remove(), 500);
        }, 2000);
    }

    // ----- SUCCESS BANNER FADE-IN/OUT -----
    ['success-banner'].forEach(id => {
        const banner = document.getElementById(id);
        if (banner) {
            banner.classList.add('opacity-0');
            setTimeout(() => banner.classList.remove('opacity-0'), 10);
            setTimeout(() => {
                banner.classList.add('opacity-0');
                setTimeout(() => banner.remove(), 500);
            }, 2000);
        }
    });

    // ----- ADD SERVICE MODAL -----
    const openModalBtn = document.getElementById('open-modal');
    const modal = document.getElementById('modal');
    const cancelModalBtn = document.getElementById('cancel-modal');
    const addServiceForm = document.getElementById('add-service-form');
    const modalContent = modal.querySelector('div');

    function openModal() {
        lockBody();

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

            unlockBody();
        }, 300);
    }

    openModalBtn.addEventListener('click', openModal);
    cancelModalBtn.addEventListener('click', closeModal);
    addServiceForm.addEventListener('submit', () => closeModal());
    modalContent.addEventListener('click', (e) => e.stopPropagation());

    @if ($errors->any())
        openModal();
    @endif

    // ----- EDIT SERVICE MODAL -----
    const editModal = document.getElementById('edit-modal');
    const editModalContent = editModal.querySelector('div');
    const cancelEditBtn = document.getElementById('cancel-edit');
    const editForm = document.getElementById('edit-service-form');
    const editName = document.getElementById('edit-name');
    const editIcon = document.getElementById('edit-icon');

    function openEditModal(service) {
        lockBody();

        editForm.action = `{{ url('/services') }}/${service.id}`;
        editName.value = service.name || '';
        editIcon.value = service.icon || '';

        editModal.classList.remove('opacity-0', 'pointer-events-none');
        editModalContent.classList.remove('scale-95');
        editModalContent.classList.add('scale-100', 'opacity-0');
        setTimeout(() => editModalContent.classList.remove('opacity-0'), 10);
    }

    function closeEditModal() {
        editModalContent.classList.add('opacity-0');
        setTimeout(() => {
            editModal.classList.add('opacity-0', 'pointer-events-none');
            editModalContent.classList.remove('scale-100');
            editModalContent.classList.add('scale-95');

            unlockBody();
        }, 300);
    }

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openEditModal({
                id: btn.dataset.id,
                name: btn.dataset.name,
                icon: btn.dataset.icon
            });
        });
    });

    cancelEditBtn.addEventListener('click', closeEditModal);

    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) closeEditModal();
    });

    editModalContent.addEventListener('click', (e) => e.stopPropagation());

    // ----- DELETE MODAL -----
    const deleteModal = document.getElementById('delete-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const deleteModalContent = deleteModal.querySelector('div');
    let deleteForm;

    function openDeleteModal(serviceName, form) {
        lockBody();
        deleteForm = form;

        document.getElementById('delete-service-name').textContent = `Are you sure you want to delete "${serviceName}"?`;

        deleteModal.classList.remove('opacity-0', 'pointer-events-none');
        deleteModalContent.classList.remove('scale-95');
        deleteModalContent.classList.add('scale-100', 'opacity-0');
        setTimeout(() => deleteModalContent.classList.remove('opacity-0'), 10);
    }

    function closeDeleteModal() {
        deleteModalContent.classList.add('opacity-0');
        setTimeout(() => {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteModalContent.classList.remove('scale-100');
            deleteModalContent.classList.add('scale-95');

            unlockBody();
        }, 300);
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const form = btn.closest('form');
            const serviceName = btn.dataset.name;
            openDeleteModal(serviceName, form);
        });
    });

    cancelDeleteBtn.addEventListener('click', closeDeleteModal);

    confirmDeleteBtn.addEventListener('click', () => {
        if (deleteForm) deleteForm.submit();
    });

    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) closeDeleteModal();
    });

    deleteModalContent.addEventListener('click', (e) => e.stopPropagation());

    // ----- SERVICE SEARCH -----
    const serviceSearch = document.getElementById('serviceSearch');
    const serviceCards = document.querySelectorAll('.service-card');
    const noServiceResults = document.getElementById('noServiceResults');

    if (serviceSearch) {
        serviceSearch.addEventListener('input', () => {
            const term = serviceSearch.value.toLowerCase();
            let visibleCount = 0;

            serviceCards.forEach(card => {
                const name = card.dataset.name;

                if (name.includes(term)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noServiceResults.classList.remove('hidden');
            } else {
                noServiceResults.classList.add('hidden');
            }
        });
    }
</script>

@endsection
