<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCountryRequest;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;

class LocationController extends Controller
{
    public function index()
    {
       
        
        $locations = Location::orderBy('id','DESC')->get();

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        // abort_unless(\Gate::allows('country_create'), 403);
        
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $location = Location::create($request->all());

        return redirect()->route('admin.locations.index')->with('message', 'Location added successfully');
    }

    public function edit( $id)
    {
        $location = Location::find($id);
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $location           =   Location::findOrFail($id);
        $location->name     =   $request->name;
        $location->save();

        return redirect()->route('admin.locations.index')->with('message', 'Location updated successfully');
    }

    public function show(Country $country)
    {
        return view('admin.locations.show');
    }

    public function destroy($id)
    {
        Location::where('id','=',$id)->delete();
        return redirect()->back()->with('message', 'Location deleted successfully');
    }
}
