<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubSubCategory;
use DB;



class SubCategoryController extends Controller
{
    public function SubCategories_view(){

        $category = Category::orderBy('category_name_en','ASC')->get();

        $subcategory = SubCategory::latest()->get();

        return view('backend.sub_category.sub_category_view',compact('subcategory','category'));
    }
    

    public function SubCategory_Store(Request $request){

        $request->validate([

            'Category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_others' => 'required',

        ],[
            'Category_id.required' => 'Select Category Name',
            'subcategory_name_en.required' => 'Input Sub Category English Name',
            'subcategory_name_others.required' => 'Input Sub Category Others Name ',
        ]);

        SubCategory::insert([

            'Category_id' => $request->Category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_others' => $request->subcategory_name_others,
            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_others' => str_replace(' ', '-', $request->subcategory_name_others),

        ]);

        $notification = array(
            'message' => 'Sub Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



    }


    public function SubCategory_Edit($id){

        $category = Category::orderBy('category_name_en','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);

        return view('backend.sub_category.subcategory_edit',compact('subcategory','category'));

    }

    public function SubCategory_Update(Request $request){


        $request->validate([

            'Category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_others' => 'required',

        ],[
            'Category_id.required' => 'Select Category Name',
            'subcategory_name_en.required' => 'Input Sub Category English Name',
            'subcategory_name_others.required' => 'Input Sub Category Others Name ',
        ]);

        $subcategory_id = $request->id;

        SubCategory::FindOrFail($subcategory_id)->update([

            'Category_id' => $request->Category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_others' => $request->subcategory_name_others,
            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_others' => str_replace(' ', '-', $request->subcategory_name_others),

        ]);

        $notification = array(
            'message' => 'Sub Category Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);

    }

    public function SubCategory_Delete($id){

        SubCategory::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Sub Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        
    }





    //  -------------------------------------  Sub Categroy End   -------------------------------








    public function Sub_SubCategories_view(){

        $category = Category::orderBy('category_name_en','ASC')->get();

        $subcategory = SubCategory::orderBy('subcategory_name_en','ASC')->get();

        $sub_subcategory = SubSubCategory::latest()->get();

        return view('backend.sub_sub_category.sub_subcategory_view',compact('category','subcategory','sub_subcategory'));

    }

    // start Sub category show with javascript


    public function Get_SubCategory($Category_id){

        $subcat = SubCategory::where('Category_id',$Category_id)->orderBy('subcategory_name_en','ASC')->get();
        return json_encode($subcat);

    }



// End Sub category show with javascript


   // start Sub Subcategory show with javascript


   public function Get_Sub_SubCategory($subcategory_id){

    $sub_subcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('sub_subcategory_name_en','ASC')->get();
    return json_encode($sub_subcat);

}



// End Sub category show with javascript






    public function Sub_SubCategory_Store(Request $request){

        $request->validate([
    		'Category_id' => 'required',
    		'subcategory_id' => 'required',
    		'sub_subcategory_name_en' => 'required',
    		'sub_subcategory_name_others' => 'required',
    	],[
    		'Category_id.required' => 'Please select Any option',
            'subcategory_id.required' => 'Please select Any option',
    		'sub_subcategory_name_en.required' => 'Input Sub SubCategory English Name',
            'sub_subcategory_name_others.required' => 'Input Sub SubCategory Others Name',
    	]);



        SubSubCategory::insert([
		'Category_id' => $request->Category_id,
		'subcategory_id' => $request->subcategory_id,
		'sub_subcategory_name_en' => $request->sub_subcategory_name_en,
		'sub_subcategory_name_others' => $request->sub_subcategory_name_others,
		'sub_subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->sub_subcategory_name_en)),
		'sub_subcategory_slug_others' => str_replace(' ', '-',$request->sub_subcategory_name_others),


    	]);

	    $notification = array(
			'message' => 'Sub-SubCategory Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);




    }




    public function Sub_SubCategory_Edit($id){

        $category = Category::orderBy('category_name_en','ASC')->get();
    	$subcategory = SubCategory::orderBy('subcategory_name_en','ASC')->get();
    	$subsubcategory = SubSubCategory::findOrFail($id);
    	return view('backend.sub_sub_category.sub_subcategory_edit',compact('category','subcategory','subsubcategory'));


    }



    public function Sub_SubCategory_Update(Request $request){

            $sub_subcategory = $request->id;

            $request->validate([
                'Category_id' => 'required',
                'subcategory_id' => 'required',
                'sub_subcategory_name_en' => 'required',
                'sub_subcategory_name_others' => 'required',
            ],[
                'Category_id.required' => 'Please select Any option',
                'subcategory_id.required' => 'Please select Any option',
                'sub_subcategory_name_en.required' => 'Input Sub SubCategory English Name',
                'sub_subcategory_name_others.required' => 'Input Sub SubCategory Others Name',
            ]);
    
    
    
            SubSubCategory::FindOrFail($sub_subcategory)->update([
            'Category_id' => $request->Category_id,
            'subcategory_id' => $request->subcategory_id,
            'sub_subcategory_name_en' => $request->sub_subcategory_name_en,
            'sub_subcategory_name_others' => $request->sub_subcategory_name_others,
            'sub_subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->sub_subcategory_name_en)),
            'sub_subcategory_slug_others' => str_replace(' ', '-',$request->sub_subcategory_name_others),
    
    
            ]);
    
            $notification = array(
                'message' => 'Sub-SubCategory Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.sub_subcategory')->with($notification);

    }



    public function Sub_SubCategory_Delete($id){

        SubSubCategory::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Sub SubCategory Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }








}
