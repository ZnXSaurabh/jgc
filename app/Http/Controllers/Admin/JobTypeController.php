<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobType;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $job_type=JobType::orderBy('id','DESC')->get();
       return view('admin.job_type.index', compact('job_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.job_type.create');
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
            'job_type'          => 'required|string|max:100',
            'description'       => 'max:255',
        ]);
        $data=new JobType;
        $data->description      = $request->description;
        $data->job_type         = $request->job_type;
        $data->save();
        return redirect()->route('admin.job_type.index')->with('message', 'Job Type added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $job = JobType::findOrFail($id);

        return view('admin.job_type.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // abort_unless(\Gate::allows('job_edit'), 403);
        $job_type = JobType::find($id);
        return view('admin.job_type.edit', compact('job_type'));
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
            'job_type'      => 'required|string|max:100',
            'description'   => 'max:255',
        ]);
        $job_type                = JobType::findOrFail($id);
        $job_type->job_type      = $request->job_type;
        $job_type->description   = $request->description;
        $job_type->status        = $request->status;
        $job_type->save();

        return redirect()->route('admin.job_type.index')->with('message', 'Job Type updated successfully');
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $ids
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        JobType::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Job Type deleted successfully');
    }
}
