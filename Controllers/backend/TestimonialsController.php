<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;
use Image;

class TestimonialsController extends Controller
{
     
   


    public function Testimonials_Manage(){

        $testimonial = Testimonial::latest()->get();

        return view('backend.testimonials.testimonials_view',compact('testimonial'));
    }




    public function Testimonials_Add(){

    
        return view('backend.testimonials.testimonials_add');
    }


    public function Testimonials_Store(Request $request){

        $request->validate([

            'testimonial_name_en' => 'required',
            'testimonial_name_others' => 'required',
            'testimonial_des_en' => 'required',
            'testimonial_des_others' => 'required',
            'testimonial_image' => 'required',
            'testimonial_position_en' => 'required',
            'testimonial_position_others' => 'required',

            

        ],[
            'testimonial_name_en.required' => 'Input Testimonial English Name',
            'testimonial_name_others.required' => 'Input Testimonial Others Name',
            'testimonial_des_en.required' => 'Input Testimonial English Name',
            'testimonial_des_others.required' => 'Input Testimonial Others Name',
            'testimonial_image.required' => 'Input Image ',
            'testimonial_position_en.required' => 'Input Testimonial English Name',
            'testimonial_position_others.required' => 'Input Testimonial Others Name',
            
        ]);


        $image = $request->file('testimonial_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/testimonial/'.$name_gen);

        $save_url = 'upload/testimonial/'.$name_gen;


        Testimonial::insert([

            'testimonial_name_en' => $request->testimonial_name_en,
            'testimonial_name_others' => $request->testimonial_name_others, 
            'testimonial_des_en' => $request->testimonial_des_en,
            'testimonial_des_others' => $request->testimonial_des_others, 
            'testimonial_position_en' => $request->testimonial_position_en,
            'testimonial_position_others' => $request->testimonial_position_others,            
            'testimonial_image' => $save_url,

        ]);

        $notification = array(
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('testimonials.view')->with($notification);



    }



    public function Testimonials_Edit($id){


        $testimonial = Testimonial::FindOrFail($id);


        return view('backend.testimonials.testimonials_edit',compact('testimonial'));



    }

    public function Testimonials_Update(Request $request){

        $old_id = $request->old_id;
        $old_img = $request->old_img;

        


        if($request->file('testimonial_image')){

            $request->validate([

                'testimonial_name_en' => 'required',
                'testimonial_name_others' => 'required',
                'testimonial_des_en' => 'required',
                'testimonial_des_others' => 'required',
                'testimonial_image' => 'required',
                'testimonial_position_en' => 'required',
                'testimonial_position_others' => 'required',
    
                
    
            ],[
                'testimonial_name_en.required' => 'Input Testimonial English Name',
                'testimonial_name_others.required' => 'Input Testimonial Others Name',
                'testimonial_des_en.required' => 'Input Testimonial English Name',
                'testimonial_des_others.required' => 'Input Testimonial Others Name',
                'testimonial_image.required' => 'Input Image ',
                'testimonial_position_en.required' => 'Input Testimonial English Name',
                'testimonial_position_others.required' => 'Input Testimonial Others Name',
                
            ]);


            @unlink($old_img);

          $image = $request->file('testimonial_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/testimonial/'.$name_gen);

        $save_url = 'upload/testimonial/'.$name_gen;


        Testimonial::FindOrFail($old_id)->update([

            'testimonial_name_en' => $request->testimonial_name_en,
            'testimonial_name_others' => $request->testimonial_name_others, 
            'testimonial_des_en' => $request->testimonial_des_en,
            'testimonial_des_others' => $request->testimonial_des_others, 
            'testimonial_position_en' => $request->testimonial_position_en,
            'testimonial_position_others' => $request->testimonial_position_others,            
            'testimonial_image' => $save_url,

        ]);

        $notification = array(
            'message' => 'Testimonial Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('testimonials.view')->with($notification);


        }else{

            $request->validate([

                'testimonial_name_en' => 'required',
                'testimonial_name_others' => 'required',
                'testimonial_des_en' => 'required',
                'testimonial_des_others' => 'required',
                
                'testimonial_position_en' => 'required',
                'testimonial_position_others' => 'required',
    
                
    
            ],[
                'testimonial_name_en.required' => 'Input Testimonial English Name',
                'testimonial_name_others.required' => 'Input Testimonial Others Name',
                'testimonial_des_en.required' => 'Input Testimonial English Name',
                'testimonial_des_others.required' => 'Input Testimonial Others Name',
                'testimonial_position_en.required' => 'Input Testimonial English Name',
                'testimonial_position_others.required' => 'Input Testimonial Others Name',
                
            ]);

            Testimonial::FindOrFail($old_id)->update([

                'testimonial_name_en' => $request->testimonial_name_en,
                'testimonial_name_others' => $request->testimonial_name_others, 
                'testimonial_des_en' => $request->testimonial_des_en,
                'testimonial_des_others' => $request->testimonial_des_others, 
                'testimonial_position_en' => $request->testimonial_position_en,
                'testimonial_position_others' => $request->testimonial_position_others,            
                
    
            ]);
    
            $notification = array(
                'message' => 'Testimonial Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('testimonials.view')->with($notification);



        }


    }


    public function Testimonials_Delete($id){

        Testimonial::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Testimonial Delete Successfully',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);

    }






}
