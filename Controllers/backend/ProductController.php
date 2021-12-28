<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubSubCategory;
use App\Models\Product;
use App\Models\MultiImg;
use DB;
use Carbon\Carbon;
use Image;



class ProductController extends Controller
{
   
    

    public function Product_Manage(){


         $product =  Product::latest()->get();

        return view('backend.products.products_manage',compact('product'));
    }

    public function Product_Add(){
        
        $brands = Brand::latest()->get();
        $category = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $sub_subcategory = SubSubCategory::latest()->get();

        return view('backend.products.products_add',compact('brands','category','subcategories','sub_subcategory',));
    }



    public function Product_Store(Request $request){



        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917,1000)->save('upload/products/thambnail/'.$name_gen);

        $save_url = 'upload/products/thambnail/'.$name_gen;




        $product_id_multi =  Product::insertGetId([

            'brand_id' => $request->brand_id,
            'Category_id' => $request->Category_id,
            'subcategory_id' => $request->subcategory_id,
            'sub_subcategory_id' => $request->sub_subcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_name_others' => $request->product_name_others,
            'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en)),
            'product_slug_others' => str_replace(' ', '-', $request->product_name_others),
            'product_code_en' => $request->product_code_en,
            'product_code_others' => $request->product_code_others,
            'product_qty_en' => $request->product_qty_en,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_others' => $request->product_tags_others,
            'product_size_en' => $request->product_size_en,
            'product_size_others' => $request->product_size_others,
            'product_color_en' => $request->product_color_en,
            'product_color_others' => $request->product_color_others,
            'selling_price_en' => $request->selling_price_en,
            'selling_price_others' => $request->selling_price_others,
            'discount_price_en' => $request->discount_price_en,
            'discount_price_others' => $request->discount_price_others,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_others' => $request->short_descp_others,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_others' => $request->long_descp_others,
            'new_product' => $request->new_product,
            'featured' => $request->featured,
            'beat_seller' => $request->beat_seller,
            'new_arrivals' => $request->new_arrivals,
            'special_deals' => $request->special_deals,
            'special_offer' => $request->special_offer,
            'hot_deal' => $request->hot_deal,
            'status' => 1,
            'product_thambnail' => $save_url,
            'created_at' => Carbon::now(),

            
        ]);


        ///////// Multiple Image Upload Start

        $multi_image = $request->file('multi_img');

        foreach($multi_image as $image){
            
            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(917,1000)->save('upload/products/multi-images/'.$make_name);
    
            $upload_img = 'upload/products/multi-images/'.$make_name;

            MultiImg::insert([
                'product_id' => $product_id_multi,
                'photo_name' => $upload_img,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



    }




    public function Product_Edit($id){

        $multiImgs = MultiImg::where('product_id',$id)->get();
        $brands = Brand::latest()->get();
        $category = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $sub_subcategory = SubSubCategory::latest()->get();
        $products = Product::FindOrFail($id);

        return view('backend.products.products_edit',compact('products','brands','category','subcategories','sub_subcategory','multiImgs'));

    }



    public function Product_Update(Request $request){

        $product_id = $request->id;
        $old_img = $request->old_image;

        if($request->file('product_thambnail')){
            unlink($old_img);
            $image = $request->file('product_thambnail');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(917,1000)->save('upload/products/thambnail/'.$name_gen);
    
            $save_url = 'upload/products/thambnail/'.$name_gen;


            $product_id_multi =  Product::FindOrFail($product_id)->update([

                'brand_id' => $request->brand_id,
                'Category_id' => $request->Category_id,
                'subcategory_id' => $request->subcategory_id,
                'sub_subcategory_id' => $request->sub_subcategory_id,
                'product_name_en' => $request->product_name_en,
                'product_name_others' => $request->product_name_others,
                'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en)),
                'product_slug_others' => str_replace(' ', '-', $request->product_name_others),
                'product_code_en' => $request->product_code_en,
                'product_code_others' => $request->product_code_others,
                'product_qty_en' => $request->product_qty_en,
                'product_tags_en' => $request->product_tags_en,
                'product_tags_others' => $request->product_tags_others,
                'product_size_en' => $request->product_size_en,
                'product_size_others' => $request->product_size_others,
                'product_color_en' => $request->product_color_en,
                'product_color_others' => $request->product_color_others,
                'selling_price_en' => $request->selling_price_en,
                'selling_price_others' => $request->selling_price_others,
                'discount_price_en' => $request->discount_price_en,
                'discount_price_others' => $request->discount_price_others,
                'short_descp_en' => $request->short_descp_en,
                'short_descp_others' => $request->short_descp_others,
                'long_descp_en' => $request->long_descp_en,
                'long_descp_others' => $request->long_descp_others,
                'new_product' => $request->new_product,
                'featured' => $request->featured,
                'beat_seller' => $request->beat_seller,
                'new_arrivals' => $request->new_arrivals,
                'special_deals' => $request->special_deals,
                'special_offer' => $request->special_offer,
                'hot_deal' => $request->hot_deal,
                'status' => 1,
                'product_thambnail' => $save_url,
                'created_at' => Carbon::now(),
    
                
            ]);
            $notification = array(
                'message' => 'Product Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.product')->with($notification);


        }else{

            $product_id_multi =  Product::FindOrFail($product_id)->update([

                'brand_id' => $request->brand_id,
                'Category_id' => $request->Category_id,
                'subcategory_id' => $request->subcategory_id,
                'sub_subcategory_id' => $request->sub_subcategory_id,
                'product_name_en' => $request->product_name_en,
                'product_name_others' => $request->product_name_others,
                'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en)),
                'product_slug_others' => str_replace(' ', '-', $request->product_name_others),
                'product_code_en' => $request->product_code_en,
                'product_code_others' => $request->product_code_others,
                'product_qty_en' => $request->product_qty_en,
                'product_tags_en' => $request->product_tags_en,
                'product_tags_others' => $request->product_tags_others,
                'product_size_en' => $request->product_size_en,
                'product_size_others' => $request->product_size_others,
                'product_color_en' => $request->product_color_en,
                'product_color_others' => $request->product_color_others,
                'selling_price_en' => $request->selling_price_en,
                'selling_price_others' => $request->selling_price_others,
                'discount_price_en' => $request->discount_price_en,
                'discount_price_others' => $request->discount_price_others,
                'short_descp_en' => $request->short_descp_en,
                'short_descp_others' => $request->short_descp_others,
                'long_descp_en' => $request->long_descp_en,
                'long_descp_others' => $request->long_descp_others,
                'new_product' => $request->new_product,
                'featured' => $request->featured,
                'beat_seller' => $request->beat_seller,
                'new_arrivals' => $request->new_arrivals,
                'special_deals' => $request->special_deals,
                'special_offer' => $request->special_offer,
                'hot_deal' => $request->hot_deal,
                'status' => 1,
                'created_at' => Carbon::now(),
    
                
            ]);
            $notification = array(
                'message' => 'Product Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.product')->with($notification);

        }



    }




    public function Product_MultiImage(Request $request){
		$imgs = $request->multi_img;

		foreach ($imgs as $id => $img) {
	    $imgDel = MultiImg::findOrFail($id);
	    unlink($imgDel->photo_name);

    	$make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
    	Image::make($img)->resize(917,1000)->save('upload/products/multi-images/'.$make_name);
    	$uploadPath = 'upload/products/multi-images/'.$make_name;

    	MultiImg::where('id',$id)->update([
    		'photo_name' => $uploadPath,
    		'updated_at' => Carbon::now(),

    	]);

	 } // end foreach

       $notification = array(
			'message' => 'Product Multi Image Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

	} // end mehtod 



            //// Multi Image Delete ////
            public function MultiImageDelete($id){
                $oldimg = MultiImg::findOrFail($id);
                unlink($oldimg->photo_name);
                MultiImg::findOrFail($id)->delete();

                $notification = array(
                'message' => 'Product multi Image Deleted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

            } // end method 




            public function ProductDelete($id){
                $product = Product::findOrFail($id);
                unlink($product->product_thambnail);
                Product::findOrFail($id)->delete();
       
                $images = MultiImg::where('product_id',$id)->get();
                foreach ($images as $img) {
                    unlink($img->photo_name);
                    MultiImg::where('product_id',$id)->delete();
                }
       
                $notification = array(
                   'message' => 'Product Deleted Successfully',
                   'alert-type' => 'success'
               );
       
               return redirect()->back()->with($notification);
       
            }// end method 





            public function ProductInactive($id){
                Product::findOrFail($id)->update(['status' => 0]);
                $notification = array(
                   'message' => 'Product Inactive',
                   'alert-type' => 'success'
               );
       
               return redirect()->back()->with($notification);
            }
       
       
         public function ProductActive($id){
             Product::findOrFail($id)->update(['status' => 1]);
                $notification = array(
                   'message' => 'Product Active',
                   'alert-type' => 'success'
               );
       
               return redirect()->back()->with($notification);
       
            }




            public function Product_view($id){

                $multiImgs = MultiImg::where('product_id',$id)->get();
                $products = Product::with('category','brand','subcategory','sub_subcategory')->FindOrFail($id);
        
                return view('backend.products.products_view',compact('products','multiImgs'));




            }





              // product Stock 
            public function ProductStock(){

                $products = Product::latest()->get();
                return view('backend.products.product_stock',compact('products'));
            }









}
