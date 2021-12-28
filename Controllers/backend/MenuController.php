<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use DB;
use App\Models\Brand;
use Image;


class MenuController extends Controller
{
    
    
    public function Add_menu(){

        $menu = Category::latest()->where('status',1)->get();

        return view('backend.menu.add_menu',compact('menu'));




    }


    
    public function Store_Menu($id){

        Category::where('id',$id)->update(['status' => 2]);

    	$notification = array(
            'message' => 'Menu Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        return view('backend.menu.add_menu');




    }

    

    public function Manage_Menu(){

        $menu = Category::latest()->where('status',2)->get();

        return view('backend.menu.manage_menu',compact('menu'));




    }


    public function Delete_Menu($id){

        Category::where('id',$id)->update(['status' => 1]);

    	$notification = array(
            'message' => 'Menu Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        return view('backend.menu.add_menu');




    }

    



    public function Show_Brand(){

        $brand = Brand::where('status',null)->latest()->get();

        return view('backend.show_by_brand.show_by_brand',compact('brand'));
    }






    public function Store_Show_Brand($id){

        $brand = Brand::sum('status');

        if($brand < 2){


            Brand::where('id',$id)->update(['status' => 1]);

    	$notification = array(
            'message' => 'Show Product By Brand Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        }else{

            $notification = array(
                'message' => 'Maximun Add 2 Items',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
    
        }
       
        




    }// end Method





    public function Manage_Show_Brand(){


        $brand = Brand::where('status',1)->latest()->get();

        return view('backend.show_by_brand.manage_by_brand',compact('brand'));




    }





    public function Remove_show_brand($id){

        Brand::where('id',$id)->update(['status' => NULL ]);


            $notification = array(
                'message' => 'Remove Show Products By Brand Successfully',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
    
    }// end Method




    public function Show_category(){

        $category = Category::where('show_product',null)->latest()->get();

        return view('backend.show_by_category.show_by_category',compact('category'));
    }




    public function Store_Show_Category($id){

        $category = Category::sum('show_product');

        if($category < 2){


            Category::where('id',$id)->update(['show_product' => 1]);

            $notification = array(
                'message' => 'Show Product By Category Successfully',
                'alert-type' => 'success'
            );

        return redirect()->back()->with($notification);


        }else{

            $notification = array(
                'message' => 'Maximun Add 2 Items',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
    

        }
       
        




    }// end Method




    public function Manage_Show_Category(){

        $category = Category::where('show_product',1)->latest()->get();

        return view('backend.show_by_category.manage_by_category',compact('category'));
    }





    public function Remove_show_Category($id){

        Category::where('id',$id)->update(['show_product' => NULL ]);


            $notification = array(
                'message' => 'Remove Show Products By Category Successfully',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
    
    }// end Method




    



    


    
    
}
