<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $locations = Location::when($search, function ($query, $search) {
            return $query->where('location_name', 'like', "%{$search}%");
        })->get();

        return view('locations.index', [
            'title' => 'Location',
            'locations' => $locations,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locations.create', [
            'title' => 'Add Location'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:100',
            'max_motorcycle' => 'required|integer|min:0',
            'max_car' => 'required|integer|min:0',
            'max_other' => 'required|integer|min:0',
        ]);

        Location::create($validated);

        return redirect()->route('locations.index')->with('success', 'Location created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        
    }
}
