<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;
use DB;

class BrandController extends Controller
{
    
    public function Brands_view(){

        $brand = Brand::latest()->get();

        return view('backend.brand.brand_view',compact('brand'));

    }

    public function Brands_Store(Request $request){

        $request->validate([

            'brand_name_en' => 'required',
            'brand_name_others' => 'required',
            'brand_image' => 'required',

        ],[
            'brand_name_en.required' => 'Input Brand English Name',
            'brand_name_others.required' => 'Input Brand Others Name',
            'brand_image.required' => 'Select Brand Image ',
        ]);


        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);

        $save_url = 'upload/brand/'.$name_gen;

        Brand::insert([

            'brand_name_en' => $request->brand_name_en,
            'brand_name_others' => $request->brand_name_others,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_others' => str_replace(' ', '-', $request->brand_name_others),
            'brand_image' => $save_url,

        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    public function Brands_Edit($id){

        $brand = Brand::findOrFail($id);

        return view('backend.brand.brand_edit',compact('brand'));

    }

    public function Brands_Update(Request $request ){

        $request->validate([

            'brand_name_en' => 'required',
            'brand_name_others' => 'required',
            

        ],[
            'brand_name_en.required' => 'Input Brand English Name',
            'brand_name_others.required' => 'Input Brand Others Name',
            
        ]);

        $brand_id = $request->id;
        $old_img = $request->old_img;

       if($request->file('brand_image')){
        unlink($old_img);
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);

        $save_url = 'upload/brand/'.$name_gen;

        Brand::findOrFail($brand_id)->update([

            'brand_name_en' => $request->brand_name_en,
            'brand_name_others' => $request->brand_name_others,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_others' => str_replace(' ', '-', $request->brand_name_others),
            'brand_image' => $save_url,

        ]);

        $notification = array(
            'message' => 'Brand Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.brands')->with($notification);

       }else{

        Brand::findOrFail($brand_id)->update([

            'brand_name_en' => $request->brand_name_en,
            'brand_name_others' => $request->brand_name_others,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_others' => str_replace(' ', '-', $request->brand_name_others),
          

        ]);

        
        $notification = array(
            'message' => 'Brand Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.brands')->with($notification);

       }

    }

    public function Brands_Delete($id){

        $brand = Brand::FindOrFail($id);
        $img = $brand->brand_image;
        unlink($img);

        Brand::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    

}
