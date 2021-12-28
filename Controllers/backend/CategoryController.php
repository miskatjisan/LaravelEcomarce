<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;




class CategoryController extends Controller
{
    public function Categories_view(){

        $category = Category::latest()->where('status',1)->get();

        return view('backend.category.category_view',compact('category'));
    }


    public function Category_Store(Request $request){

        $request->validate([

            'category_name_en' => 'required',
            'category_name_others' => 'required',
            'category_icon' => 'required',

        ],[
            'category_name_en.required' => 'Input Category English Name',
            'category_name_others.required' => 'Input Category Others Name',
            'category_icon.required' => 'Input Category Icon ',
        ]);

        Category::insert([

            'category_name_en' => $request->category_name_en,
            'category_name_others' => $request->category_name_others,
            'category_icon' => $request->category_icon,
            'status' => $request->status,
            'category_slug_en' => strtolower(str_replace(' ', '-', $request->category_name_en)),
            'category_slug_others' => str_replace(' ', '-', $request->category_name_others),

        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }


    public function Category_Edit($id){

        $category = Category::findOrFail($id);

        return view('backend.category.category_edit',compact('category'));

    }


    public function Category_Update(Request $request){


        $request->validate([

            'category_name_en' => 'required',
            'category_name_others' => 'required',
            'category_icon' => 'required',

        ],[
            'category_name_en.required' => 'Input Category English Name',
            'category_name_others.required' => 'Input Category Others Name',
            'category_icon.required' => 'Input Category Icon ',
        ]);


        $category_id = $request->id;

        Category::findOrFail($category_id)->update([

            'category_name_en' => $request->category_name_en,
            'category_name_others' => $request->category_name_others,
            'category_icon' => $request->category_icon,
            'status' => $request->status,
            'category_slug_en' => strtolower(str_replace(' ', '-', $request->category_name_en)),
            'category_slug_others' => str_replace(' ', '-', $request->category_name_others),

        ]);

        $notification = array(
            'message' => 'Category Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);



    }

    public function Category_Delete($id){

        Category::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }






}
