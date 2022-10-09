<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /* public function __construct()
    {
        $this->middleware("auth");
    } */

    public function allCat(){
        //query builder
        /* $categories = DB::table("categories")
                      ->join("users","categories.user_id","users.id")
                      ->select("categories.*","users.name")
                      ->latest()
                      ->paginate(3); */

        //eloquent orm
        $categories = Category::latest()->paginate(3);
        $trashCats = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index',compact("categories","trashCats"));
    }

    public function addCat(Request $request){
        $validateData = $request->validate([
            "category_name" => "required|unique:categories|max:255"
        ]);

        // eloquent orm
        /* Category::insert([
            "category_name" => $request->category_name,
            "user_id" => Auth::user()->id,
            "created_at" => Carbon::now()
        ]); */
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        // query builder
        /* $data = array();
        $data["category_name"] = $request->category_name;
        $data["user_id"] = Auth::user()->id;
        $data["created_at"] = Carbon::now();
        DB::table("categories")->insert($data); */

        return redirect()->back()->with("success","Data inserted successfully");
    }

    public function editCat($id){
        // eloquent orm
        $category = Category::findOrFail($id);

        // query builder
        //$category = DB::table("categories")->where("id",$id)->first();
        return view("admin.category.edit",compact("category"));
    }

    public function updateCat(Request $request,$id){
        $update = Category::findOrFail($id)->update([
            "category_name" => $request->category_name,
            "user_id" => Auth::user()->id
        ]);
        if($update){
            return redirect()->route("all.category")->with("success","Data updated successfully");
        }else{
            return redirect()->route("all.category")->with("fail","Data failed to update");
        };
    }
    public function softDelete($id){
        Category::findOrFail($id)->delete();
        return redirect()->back()->with("success","Data added to trash successfully");
    }

    public function restoreCat($id){
        Category::withTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with("success","Data restored successfully");
    }
    public function deleteCat($id){
        Category::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with("success","Data deleted successfully");
    }
}
