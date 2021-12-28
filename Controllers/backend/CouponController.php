<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Product;
use DB;

class CouponController extends Controller
{
    
    
    public function CouponView(){

        $products = Product::orderBy('id','DESC')->get();
    	$coupons = Coupon::orderBy('id','DESC')->get();
    	return view('backend.coupon.view_coupon',compact('coupons','products'));

    }



    public function CouponStore(Request $request){

    	$request->validate([
    		'coupon_name' => 'required',
    		'coupon_discount' => 'required',
    		'coupon_validity' => 'required',

    	]);



        if($request->product_all == 0 ){

            Coupon::insert([
                'coupon_name' => strtoupper($request->coupon_name),
                'coupon_discount' => $request->coupon_discount, 
                'product_code' => $request->product_code,
                'product_all' => $request->NULL,
                'coupon_validity' => $request->coupon_validity,
                'created_at' => Carbon::now(),
        
                ]);
        
                $notification = array(
                    'message' => 'Coupon Inserted Successfully',
                    'alert-type' => 'success'
                );
        
                return redirect()->back()->with($notification);

        }elseif( $request->product_code == 0 ){


            Coupon::insert([
                'coupon_name' => strtoupper($request->coupon_name),
                'coupon_discount' => $request->coupon_discount, 
                'product_all' => $request->product_all,
                'coupon_validity' => $request->coupon_validity,
                'created_at' => Carbon::now(),
        
                ]);
        
                $notification = array(
                    'message' => 'Coupon Inserted Successfully',
                    'alert-type' => 'success'
                );
        
                return redirect()->back()->with($notification);

        }else{

            $notification = array(
                'message' => 'Coupon Inserted UnSuccessfully',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);


        }

	

    } // end method








    public function CouponEdit($id){
        $products = Product::orderBy('id','DESC')->get();
        $coupons = Coupon::findOrFail($id);
           return view('backend.coupon.edit_coupon',compact('coupons','products'));
       }
   
   
       public function CouponUpdate(Request $request, $id){


        if($request->product_all == 0 ){

            Coupon::findOrFail($id)->update([
                'coupon_name' => strtoupper($request->coupon_name),
                'coupon_discount' => $request->coupon_discount, 
                'product_code' => $request->product_code,
                'coupon_validity' => $request->coupon_validity,
                'created_at' => Carbon::now(),
        
                ]);
        
                $notification = array(
                    'message' => 'Coupon Updated Successfully',
                    'alert-type' => 'info'
                );
        
                return redirect()->route('manage-coupon')->with($notification);


        }elseif($request->product_code == 0 ){

            Coupon::findOrFail($id)->update([
                'coupon_name' => strtoupper($request->coupon_name),
                'coupon_discount' => $request->coupon_discount, 
                'product_all' => $request->product_all,
                'coupon_validity' => $request->coupon_validity,
                'created_at' => Carbon::now(),
        
                ]);
        
                $notification = array(
                    'message' => 'Coupon Updated Successfully',
                    'alert-type' => 'info'
                );
        
                return redirect()->route('manage-coupon')->with($notification);


        }else{




        }
   
         
   
   
       } // end mehtod 
   
   
       public function CouponDelete($id){
   
           Coupon::findOrFail($id)->delete();
           $notification = array(
               'message' => 'Coupon Deleted Successfully',
               'alert-type' => 'info'
           );
   
           return redirect()->back()->with($notification);
   
       }






}
