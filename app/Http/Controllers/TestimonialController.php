<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials=Testimonial::all();
        return view('admin.testimonial.index',compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $testimonial = new Testimonial();
        $testimonial->name=$request->name;
        $testimonial->designation=$request->designation;
        $testimonial->message=$request->message;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
     
            $request->image->move(public_path('uploads/testimonials/'), $imageName);
            $testimonial->image= $imageName;
        }

        $testimonial->save();
        return redirect()->route('testimonials.index')->with('message','Testimonial added successfully');
        

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
        $testimonial=Testimonial::findOrFail($id);
        return view('admin.testimonial.edit',compact('testimonial'));
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
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->name=$request->name;
        $testimonial->designation=$request->designation;
        $testimonial->message=$request->message;

        if ($image = $request->file('image')) {
            $image_path = public_path('uploads/testimonials/' . $testimonial->image);
            
            if(file_exists($image_path)){
                unlink($image_path);
            }
                $destinationPath = 'uploads/testimonials/';
                $profileImage = date('YmdHis') . "." .$image->getClientOriginalName();
                $image->move($destinationPath, $profileImage);
                $testimonial->image = "$profileImage";
            
        }else{
            unset($testimonial->image);
        }
        $testimonial->save();
        return redirect()->route('testimonials.index')->with('message','Testimonial updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial=Testimonial::findOrFail($id);
        $image_path = public_path('uploads/testimonials/' . $testimonial->image);    
            if(file_exists($image_path)){
                unlink($image_path);
            }else{
                
            }
        $testimonial->delete();
        return back()->with('message','Testimonial deleted successfully');
    }
}
