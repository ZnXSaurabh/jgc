<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::orderBy('id','DESC')->get();
        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.department.create');
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
        $data                   = new Department;
        $data->name             = $request->title;
        $data->description      = $request->description;
        $data->save();
        return redirect()->route('admin.department.index')->with('message', 'Department added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_unless(\Gate::allows('job_show'), 403);

        // if ($job->employer_id != auth()->id()) {
        //     abort(404);
        // }
        $department = Department::findOrFail($id);
        return view('admin.department.show', compact('department'));
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
        $department = Department::find($id);
        return view('admin.department.edit', compact('department'));
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
        
        $department                 =   Department::findOrFail($id);
        $department->name           =   $request->title;
        $department->description    =   $request->description;
        $department->status         =   $request->status;
        $department->save();
        return redirect()->route('admin.department.index')->with('message', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::where('id','=',$id)->delete();
        return redirect()->back()->with('message', 'Department deleted successfully');
    }
}