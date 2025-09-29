<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name', 'asc')->get();
        return view('services.services', compact('services'));
    }

    public function create()
    {
        return view('services.create'); // form para mag-add ng service
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'icon' => 'nullable|string|max:255',
        ]);

        $url = Str::slug($request->name);

        $colors = [
            'text-pink-500', 'text-purple-500', 'text-blue-500', 'text-green-500',
            'text-amber-500', 'text-fuchsia-500', 'text-sky-500', 'text-orange-500',
            'text-rose-500', 'text-cyan-500', 'text-red-500', 'text-indigo-500',
            'text-lime-500', 'text-violet-500', 'text-blue-400', 'text-pink-500'
        ];
        $color = $colors[array_rand($colors)];

        // Create Service
        $service = Service::create([
            'name'  => $request->name,
            'icon'  => $request->icon,
            'url'   => $url,
        ]);

        // ✅ Create corresponding Stock entry (default quantity 0)
        $service->stock()->create([
            'quantity' => 0,
        ]);

        return redirect()->route('services.services')->with('success', 'Service added!');
    }

    public function destroy(Service $service)
    {
        // Delete stock entry first (if exists)
        if ($service->stock) {
            $service->stock->delete();
        }

        $service->delete();
        return redirect()->route('services.services')->with('success', 'Service successfully deleted!');
    }

    public function show($url)
    {
        $service = Service::where('url', $url)->firstOrFail(); // fetch by slug
        return view('services.show', compact('service'));
    }
}
