<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    public function allBrand(){
        $brands = Brand::latest()->paginate(3);
        return view("admin.brand.index",compact("brands"));
    }

    public function addBrand(Request $request){
        $validateData = $request->validate([
            "brand_name" => "required|unique:brands|min:3",
            "brand_image" => "required|mimes:jpg,jpeg,png"
        ]);

        $brand_image = $request->file('brand_image');
        /* $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = hexdec(uniqid()).'.'.$img_ext;
        $up_location = "image/brand/";
        $imageNameForDb = $up_location.$img_name;
        $brand_image->move($up_location,$img_name); */


        //with intervention package
        $img_name = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('image/brand/'.$img_name);
        
        $imageNameForDb = 'image/brand/'.$img_name;
        Brand::insert([
            "brand_name" => $request->brand_name,
            "brand_image" => $imageNameForDb,
            "created_at" => Carbon::now()
        ]);
        return redirect()->back()->with("success","Brand added successfully");
    }

    public function editBrand($id){
        // eloquent orm
        $brand = Brand::findOrFail($id);

        // query builder
        //$category = DB::table("categories")->where("id",$id)->first();
        return view("admin.brand.edit",compact("brand"));
    }

    public function updateBrand(Request $request, $id){
        $validateData = $request->validate([
            "brand_name" => "required|min:3",
        ]);

        $brand_image = $request->file('brand_image');

        if($brand_image){
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = hexdec(uniqid()).'.'.$img_ext;
            $up_location = "image/brand/";
            $imageNameForDb = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);

            $old_image = $request->old_image;
            unlink($old_image);
            Brand::findOrFail($id)->update([
                "brand_name" => $request->brand_name,
                "brand_image" => $imageNameForDb,
                "created_at" => Carbon::now()
            ]);
            return redirect()->back()->with("success","Brand updated successfully");
        }else{
            Brand::findOrFail($id)->update([
                "brand_name" => $request->brand_name,
                "created_at" => Carbon::now()
            ]);
            return redirect()->back()->with("success","Brand updated successfully");
        }
        
    }

    public function deleteBrand($id){
        $brand = Brand::findOrFail($id);
        $old_image = $brand->brand_image;
        unlink($old_image);

        $brand->delete();
        return redirect()->back()->with('success',"Data deleted successfully");
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','Logout Successfully');
    }
}
