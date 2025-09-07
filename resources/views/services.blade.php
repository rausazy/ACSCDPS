@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-800">Our Services</h1>
        <p class="mt-4 text-gray-600">We offer a wide range of printing and digital services tailored to your needs.</p>

        {{-- Sample service cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800">Digital Printing</h2>
                <p class="text-gray-600 mt-2">High-quality digital prints for flyers, posters, and more.</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800">Customized Items</h2>
                <p class="text-gray-600 mt-2">Personalized mugs, shirts, and giveaways.</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800">Graphic Design</h2>
                <p class="text-gray-600 mt-2">Professional layouts and designs for your business needs.</p>
            </div>
        </div>
    </div>
@endsection
