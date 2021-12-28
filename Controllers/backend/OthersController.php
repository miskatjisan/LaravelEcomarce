<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FAQ;
use DB;
use App\Models\Contact_Us;
use App\Models\Map;
use App\Models\About;
use Carbon\Carbon;
use Auth;


class OthersController extends Controller
{
   
    


    public function Manage_FAQ(){

        $faq = FAQ::latest()->get();



        return view('backend.FAQ.manage_faq',compact('faq'));
    }

    public function Add_FAQ(){

        return view('backend.FAQ.add_faq');
    }


    public function Store_FAQ(Request $request){

        $request->validate([

            'question_en' => 'required',
            'question_others' => 'required',
            'answer_en' => 'required',
            'answer_others' => 'required',

        ],[
            'question_en.required' => 'Input Question English Name',
            'question_others.required' => 'Input Question Others Name',
            'answer_en.required' => 'Input answer English Name',
            'answer_others.required' => 'Input answer Others Name',
            
        ]);


        FAQ::insert([
 
            'question_en' => $request->question_en,
            'question_others' => $request->question_others,
            'answer_en' => $request->answer_en,
            'answer_others' => $request->answer_others,

        ]);


        $notification = array(
            'message' => 'FAQ Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);




    }


        public function Edit_FAQ($id){


            $faq = FAQ::findOrFail($id);

            return view('backend.FAQ.edit_faq',compact('faq'));


            
        }
    

        public function Update_FAQ(Request $request){


            $faq_id = $request->id;

            $request->validate([

                'question_en' => 'required',
                'question_others' => 'required',
                'answer_en' => 'required',
                'answer_others' => 'required',
    
            ],[
                'question_en.required' => 'Input Question English Name',
                'question_others.required' => 'Input Question Others Name',
                'answer_en.required' => 'Input answer English Name',
                'answer_others.required' => 'Input answer Others Name',
                
            ]);
    
    
                FAQ::findOrFail($faq_id)->update([
     
                'question_en' => $request->question_en,
                'question_others' => $request->question_others,
                'answer_en' => $request->answer_en,
                'answer_others' => $request->answer_others,
    
            ]);
    
    
            $notification = array(
                'message' => 'FAQ Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('manage-faq')->with($notification);



        }


        public function Delete_FAQ($id){

            $faq = FAQ::FindOrFail($id)->delete();;

            $notification = array(
                'message' => 'FAQ Delete Successfully',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);

        }


        public function Contact(){

            $contact = Contact_Us::with('user')->latest()->get();

            return view('backend.contact_us.contact_us',compact('contact'));
        }


        public function Contact_view(){

            $contact = Contact_Us::with('user')->first();

            return view('backend.contact_us.contact_us_view',compact('contact'));

        }


        public function Contact_Delete($id){

            Contact_Us::FindOrFail($id)->delete();

            $notification = array(
                'message' => 'Contact  Delete Successfully',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);

        }


        public function Map_Manage(){

            $map = Map::find(1);

            return view('backend.map.map_view',compact('map'));
        }

        public function Map_Update(Request $request){

            $old_id = $request->old_id;

            $data = array();

            $data['map_link'] = $request->map_link;

            Map::FindOrFail($old_id)->update($data);

            $notification = array(
                'message' => 'Map  Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);


        }






        public function About_Manage(){

           $about = About::find(1);

            return view('backend.about.about_view',compact('about'));
        }



        public function About_Update(Request $request){


            $old_id = $request->old_id;

            $data = array();

            $data['about_en'] = $request->about_en;
            $data['about_others'] = $request->about_others;


            About::FindOrFail($old_id)->update($data);

            $notification = array(
                'message' => 'About  Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);



        }










}
