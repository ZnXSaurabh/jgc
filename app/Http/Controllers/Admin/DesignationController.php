<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designation=Designation::orderBy('id','DESC')->get();
        return view('admin.designation.index', compact('designation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.designation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:100',
            'description'   => 'max:500',
        ]);

        $data                   =   new Designation;
        $data->name             =   $request->title;
        $data->description      =   $request->description;
        $data->save();
        return redirect()->route('admin.designation.index')->with('message', 'Designation added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_unless(\Gate::allows('designation_show'), 403);

        $designation = Designation::findOrFail($id);
        return view('admin.designation.show', compact('designation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // abort_unless(\Gate::allows('designation_edit'), 403);

        $designation = Designation::find($id);
        return view('admin.designation.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string|max:100',
            'description'   => 'max:500',
        ]);

        $designation                    =   Designation::findOrFail($id);
        $designation->name              =   $request->title;
        $designation->description       =   $request->description;
        $designation->status            =   $request->status;
        $designation->save();
        
        return redirect()->route('admin.designation.index')->with('message', 'Designation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Designation::where('id','=',$id)->delete();
        return redirect()->back()->with('message', 'Designation deleted successfully');
    }
}
