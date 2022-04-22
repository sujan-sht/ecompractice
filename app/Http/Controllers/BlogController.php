<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug'=>'required|unique:blogs,slug,',
        ]);

        $blog=new Blog();
        $blog->title=$request->title;
        $blog->slug=$request->slug;
        $blog->description=$request->description;
        $blog->status=$request->status;
        

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
     
            $request->image->move(public_path('uploads/blogs/'), $imageName);
            $blog->image= $imageName;
            // $blog->image = $request->image->store('uploads/blogs');
        }

        if($blog->save()){
            return redirect()->route('blogs.index')->with('message','Blog added successfully');
        }
        

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

        $blog=Blog::findOrFail($id);
        return view('admin.blog.edit',compact('blog'));
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
        $validated = $request->validate([
            'title' => 'required',
            'slug'=>'required|unique:blogs,slug,'.$id,
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title=$request->title;
        $blog->slug=$request->slug;
        $blog->description=$request->description;
        $blog->status=$request->status;

        if ($image = $request->file('image')) {
            $image_path = public_path('uploads/blogs/' . $blog->image);
            
            if(file_exists($image_path)){
                unlink($image_path);
            }
                $destinationPath = 'uploads/blogs/';
                $profileImage = date('YmdHis') . "." .$image->getClientOriginalName();
                $image->move($destinationPath, $profileImage);
                $blog->image = "$profileImage";
            
        }else{
            unset($blog->image);
        }
        $blog->save();
        return redirect()->route('blogs.index')->with('message','Blog updated successfully');
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog=Blog::findOrFail($id);
        $image_path = public_path('uploads/blogs/' . $blog->image);    
            if(file_exists($image_path)){
                unlink($image_path);
            }else{
                
            }
        $blog->delete();
        return back()->with('message','Blog deleted successfully');
    }

    public function update_status(Request $request)
    {
        dd('hi');
        $blog = Blog::findOrFail($request->id);
        
        $blog->status = $request->status;
        
        $blog->save();
    
        return response()->json(['message' => 'Status updated successfully.']);
    }
}
