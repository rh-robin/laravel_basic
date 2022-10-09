<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends Controller
{
    public function indexAbout(){
        $about = About::first();
        return view('admin.about.index',compact('about'));
    }

    public function updateAbout(Request $request, $id){
        $validateData = $request->validate([
            "title" => "required|min:3",
            "long_desc" => "required"
        ],[
            "long_desc.required" => "Long description field is required"
        ]);
        $update = About::findOrFail($id)->update([
            "title" => $request->title,
            "short_desc" => $request->short_desc,
            "long_desc" => $request->long_desc,
        ]);
        if($update){
            return redirect()->route("index.about")->with("success","Data updated successfully");
        }else{
            return redirect()->route("index.about")->with("fail","Data failed to update");
        };
    }
}
