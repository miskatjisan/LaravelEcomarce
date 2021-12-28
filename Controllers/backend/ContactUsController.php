<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact_Us;
use Carbon\Carbon;
use Auth;

class ContactUsController extends Controller
{
   
    
    public function Store_Contact(Request $request){

        if (Auth::check()) {

            $request->validate([

                'name' => 'required',
                'email' => 'required',
                'title' => 'required',
                'comment' => 'required',
    
            ],[
                'name.required' => 'Input Your Name',
                'email.required' => 'Input email  Address',
                'title.required' => 'Input title  ',
                'comment.required' => 'Input comment  ',
            ]);

            Contact_Us::insert([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'title' => $request->title,
                'comment' => $request->comment,
                'created_at' => Carbon::now(),
    
            ]);

            $notification = array(
                'message' => 'Thanks for Comminication',
                'alert-type' => 'success'
            );
    
            return redirect()->route('dashboard')->with($notification);




        }else{

            $notification = array(
                'message' => 'At First Login Your Account',
                'alert-type' => 'success'
            );
    
            return redirect()->route('login')->with($notification);
        }



    }



    







}
