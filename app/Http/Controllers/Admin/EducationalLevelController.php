<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EducationalLevel;

class EducationalLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EducationalLevels = EducationalLevel::orderBy('id','DESC')->get();
        return view('admin.educational-level.index', compact('EducationalLevels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.educational-level.create');
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
        ]);
        $data                   = new EducationalLevel;
        $data->name             = $request->title;
        $data->save();
        return redirect()->route('admin.educational_level.index')->with('message', 'Educational Level added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $EducationalLevel = EducationalLevel::find($id);
        return view('admin.educational-level.edit', compact('EducationalLevel'));
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
        ]);
        
        $EducationalLevel                 =   EducationalLevel::findOrFail($id);
        $EducationalLevel->name           =   $request->title;
        $EducationalLevel->status         =   $request->status;
        $EducationalLevel->save();
        return redirect()->route('admin.educational_level.index')->with('message', 'Educational Level updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EducationalLevel::where('id','=',$id)->delete();
        return redirect()->back()->with('message', 'Educational Level deleted successfully');
    }
}
