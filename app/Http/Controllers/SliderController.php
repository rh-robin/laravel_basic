<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Image;


class SliderController extends Controller
{
    public function allSlider(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.index',compact('sliders'));
    }

    public function createSlider(){
        return view('admin.slider.create');
    }
    public function storeSlider(Request $request){
        $validateData = $request->validate([
            "image" => "required|mimes:jpg,jpeg,png"
        ]);

        $slider_image = $request->file('image');
        /* $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = hexdec(uniqid()).'.'.$img_ext;
        $up_location = "image/slider/";
        $imageNameForDb = $up_location.$img_name;
        $brand_image->move($up_location,$img_name); */


        //with intervention package
        $img_name = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920,1080)->save('image/slider/'.$img_name);
        
        $imageNameForDb = 'image/slider/'.$img_name;
        Slider::insert([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $imageNameForDb,
            "button_link" => $request->button_link,
            "created_at" => Carbon::now()
        ]);
        return redirect()->back()->with("success","Slider added successfully");
    }
}
