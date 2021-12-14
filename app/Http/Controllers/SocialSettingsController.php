<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialSetting;

class SocialSettingsController extends Controller
{
    public function index(){
        $social = SocialSetting::find(1);
        return view('admin.settings.social',compact('social'));
    }
    
    public function update(Request $request, $id)
    {
        $social = SocialSetting::findOrFail($id);
        $this->validateData($request);
        $input = $request->all();
        $social->update($input);
        return redirect('/social_settings')->with('status','Settings has been updated successfully');
    }

    // Validate Data
    protected function validateData(Request $request)
    {

        return $request->validate([
            'facebook'=>'required',
            'twitter'=>'required',
            'instagram' => 'required',
            'linkedin'=> 'required'
        ]);
    }
}
