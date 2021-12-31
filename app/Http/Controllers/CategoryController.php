<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::first()->paginate();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::where('parent_id',0)->where('status',1)->get();
        return view('admin.category.create',compact('categories'));
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
            'category' => 'required',
            'parent_id' => 'required',
            'status'=>'required',
            'slug'=>'required|unique:categories,slug',
        ]);

        $category=new Category();
        $category->name=$request['category'];
        $category->parent_id=$request['parent_id'];
        $category->status=$request['status'];
        $category->featured=$request['featured'];
        $category->slug=$request['slug'];

        if($image = $request->file('image')){
            $destinationPath = 'category/';
            $catImage = $image->getClientOriginalName();
            $image->move($destinationPath, $catImage);
            $category['image'] = "$catImage";
        }
        // dd($category);
        $category->save();
        return redirect()->route('categories.index')->with('status','Category added successfully');

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
        $categories=Category::where('parent_id',0)->where('status',1)->get();
        $category=Category::findOrFail($id);
        return view('admin.category.edit',compact('category','categories'));
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
            'category' => 'required',
            'parent_id' => 'required',
            'status'=>'required',
            'slug'=>'required|unique:categories,slug,'.$id,
        ]);

        $category= Category::findOrFail($id);
        $category->name=$request['category'];
        $category->parent_id=$request['parent_id'];
        $category->status=$request['status'];
        $category->featured=$request['featured'];
        $category->slug=$request['slug'];

        if ($image = $request->file('image')) {
            $image_path = public_path('category/' . $category->image);
            
            if(file_exists($image_path)){
                unlink($image_path);
            }
                $destinationPath = 'category/';
                $profileImage = date('YmdHis') . "." .$image->getClientOriginalName();
                $image->move($destinationPath, $profileImage);
                $category['image'] = "$profileImage";
            
        }else{
            unset($category['image']);
        }
        // dd($category);
        $category->update();
        return redirect()->route('categories.index')->with('status','Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
