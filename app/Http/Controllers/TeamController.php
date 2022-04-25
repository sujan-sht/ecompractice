<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams=Team::all();
        return view('admin.team.index',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = new Team();
        $team->name=$request->name;
        $team->designation=$request->designation;
        $team->details=$request->details;
        $team->contact=$request->contact;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
     
            $request->image->move(public_path('uploads/teams/'), $imageName);
            $team->image= $imageName;
        }

        $team->save();
        return redirect()->route('teams.index')->with('message','Team added successfully');
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
        $team=Team::findOrFail($id);
        return view('admin.team.edit',compact('team'));
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
        $team = Team::findOrFail($id);
        $team->name=$request->name;
        $team->designation=$request->designation;
        $team->details=$request->details;
        $team->contact=$request->contact;
        if ($image = $request->file('image')) {
            $image_path = public_path('uploads/teams/' . $team->image);
            
            if(file_exists($image_path)){
                unlink($image_path);
            }
                $destinationPath = 'uploads/teams/';
                $profileImage = date('YmdHis') . "." .$image->getClientOriginalName();
                $image->move($destinationPath, $profileImage);
                $team->image = "$profileImage";
            
        }else{
            unset($team->image);
        }

        $team->save();
        return redirect()->route('teams.index')->with('message','Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team=Team::findOrFail($id);
        $image_path = public_path('uploads/teams/' . $team->image);    
            if(file_exists($image_path)){
                unlink($image_path);
            }else{
                
            }
        $team->delete();
        return back()->with('message','Team deleted successfully');
    }
}
