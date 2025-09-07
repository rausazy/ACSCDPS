@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center py-16">

    <!-- Header -->
    <div class="text-center mb-14">
        <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent 
           bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 
           leading-tight pb-2">
            Welcome to Cinlei Automated Costing
        </h1>
        <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
            We provide <span class="font-semibold text-purple-600">top-quality products</span> and 
            <span class="font-semibold text-pink-500">professional services</span> 
            designed to help your business grow and succeed.
        </p>
    </div>

    <!-- Stats Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mb-16">
        <!-- Total Cost -->
        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center space-x-6">
                <div class="p-5 rounded-full bg-purple-100 text-purple-600">
                    <x-heroicon-o-currency-dollar class="w-12 h-12" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Total Cost</h2>
                    <p class="text-4xl font-extrabold text-gray-900">₱120,000</p>
                </div>
            </div>
        </div>

        <!-- Products Available -->
        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center space-x-6">
                <div class="p-5 rounded-full bg-blue-100 text-blue-600">
                    <x-heroicon-o-archive-box class="w-12 h-12" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Products Available</h2>
                    <p class="text-4xl font-extrabold text-gray-900">320</p>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center space-x-6">
                <div class="p-5 rounded-full bg-green-100 text-green-600">
                    <x-heroicon-o-chart-bar class="w-12 h-12" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Total Revenue</h2>
                    <p class="text-4xl font-extrabold text-gray-900">₱450,000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">📊 Monthly Analytics</h2>
        <div class="h-80 flex items-center justify-center text-gray-500 italic">
            Analytics chart will be displayed here once data is available.
        </div>
    </div>
</div>
@endsection
