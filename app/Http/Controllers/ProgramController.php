<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs=Program::all();
        return view('admin.program.index',compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.program.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $program = new Program();
        $program->title=$request->title;
        $program->description=$request->description;
        $program->date=$request->date;
        $program->location=$request->location;


        if ($request->hasFile('thumbnail_img')) {
            $imageName = time().'.'.$request->thumbnail_img->extension();  
     
            $request->thumbnail_img->move(public_path('uploads/programs/'), $imageName);
            $program->thumbnail_img= $imageName;
        }
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
     
            $request->image->move(public_path('uploads/programs/'), $imageName);
            $program->image= $imageName;
        }

        $program->save();
        return redirect()->route('programs.index')->with('message','Program added successfully');
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
        $program=Program::findOrFail($id);
        return view('admin.program.edit',compact('program'));
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
        $program = Program::findOrFail($id);
        $program->title=$request->title;
        $program->description=$request->description;
        $program->date=$request->date;
        $program->location=$request->location;
        if ($image = $request->file('image')) {
            $image_path = public_path('uploads/programs/' . $program->image);
            
            if(file_exists($image_path)){
                unlink($image_path);
            }
                $destinationPath = 'uploads/programs/';
                $profileImage = time() . "." .$image->extension();
                $image->move($destinationPath, $profileImage);
                $program->image = "$profileImage";
            
        }else{
            unset($program->image);
        }

        if ($thumbnail_img = $request->file('thumbnail_img')) {
            $thumb_image_path = public_path('uploads/programs/' . $program->thumbnail_img);
            
            if(file_exists($thumb_image_path)){
                unlink($thumb_image_path);
            }
                $destination = 'uploads/programs/';
                $thumb_img = time() . "." .$thumbnail_img->extension();
                $thumbnail_img->move($destination, $thumb_img);
                $program->thumbnail_img = "$thumb_img";
            
        }else{
            unset($program->thumbnail_img);
        }

        $program->save();
        return redirect()->route('programs.index')->with('message','Program updated successfully');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program=Program::findOrFail($id);
        $image_path = public_path('uploads/programs/' . $program->image);    
            if(file_exists($image_path)){
                unlink($image_path);
            }else{
                
            }
        $program->delete();
        return back()->with('message','Program deleted successfully');
    }
}
