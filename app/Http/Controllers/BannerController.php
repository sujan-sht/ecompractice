<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new Banner();
        $banner->url=$request->url;
        $banner->status=$request->status;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
     
            $request->image->move(public_path('uploads/banners/'), $imageName);
            $banner->image= $imageName;
        }

        $banner->save();
        return redirect()->route('banners.index')->with('message','Banner added successfully');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit',compact('banner'));
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
        $banner = Banner::findOrFail($id);
        $banner->url=$request->url;
        $banner->status=$request->status;

        if ($image = $request->file('image')) {
            $image_path = public_path('uploads/banners/' . $banner->image);
            
            if(file_exists($image_path)){
                unlink($image_path);
            }
                $destinationPath = 'uploads/banners/';
                $profileImage = date('YmdHis') . "." .$image->getClientOriginalName();
                $image->move($destinationPath, $profileImage);
                $banner->image = "$profileImage";
            
        }else{
            unset($banner->image);
        }
        $banner->save();
        return redirect()->route('banners.index')->with('message','Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $image_path = public_path('uploads/banners/' . $banner->image);    
            if(file_exists($image_path)){
                unlink($image_path);
            }else{
                
            }
        $banner->delete();
        return back()->with('message','Banner deleted successfully');
    }

    public function update_status(Request $request)
    {
        dd('hi');
        $banner = Banner::findOrFail($request->id);
        
        $banner->status = $request->status;
        
        $banner->save();
    
        return response()->json(['message' => 'Status updated successfully.']);
    }
}
