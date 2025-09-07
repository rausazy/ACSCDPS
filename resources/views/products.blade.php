@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-800">Our Products</h1>
        <p class="mt-4 text-gray-600">Here you can browse all our available products.</p>

        {{-- Sample product cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800">Product 1</h2>
                <p class="text-gray-600 mt-2">Description of product 1.</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800">Product 2</h2>
                <p class="text-gray-600 mt-2">Description of product 2.</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800">Product 3</h2>
                <p class="text-gray-600 mt-2">Description of product 3.</p>
            </div>
        </div>
    </div>
@endsection
