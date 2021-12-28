<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use DB;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    

    public function User_Logout(){

        Auth::logout();


        return Redirect()->route('login');
    }


    public function User_Profile(){

        $id = Auth::user()->id;

        $user = User::find($id);

        return view('frontend.user.user_profile',compact('user'));
    }

    public function User_Profile_Store(Request $request){

        $data = User::find(Auth::user()->id);

        $birthday = $request->birthday;

        if( $birthday ){

        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['gender'] = $request->gender;
        $data['birthday'] = $request->birthday;
        $data['email'] = $request->email;

        $data->save();

        $notification = array(
            'message' => 'Profile Update Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('dashboard')->with($notification);



        }else{

            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            $data['address'] = $request->address;
            $data['gender'] = $request->gender;
            $data['email'] = $request->email;
    
            $data->save();
    
            $notification = array(
                'message' => 'Profile Update Successfully',
                'alert-type' => 'success'
            );
    
    
            return redirect()->route('dashboard')->with($notification);

        }

       


    }

    public function View_password(){

        $id = Auth::user()->id;

        $user = User::find($id);

        return view('frontend.user.user_password',compact('user'));


    }

    public function User_Password_Store(Request $request){

        $validateData = $request->validate([

            'old_password' => 'required',
            'password' => 'required|confirmed'

        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->old_password,$hashedPassword)){

            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::logout();

            $notification = array(
                'message' => 'Password Change Successfully',
                'alert-type' => 'success'
            );
    

            return redirect()->route('user.logout')->with($notification);
        }else{

            $notification = array(
                'message' => 'Current Password Not Match',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }

    }







    public function User_Photo(){

        $id = Auth::user()->id;

        $user = User::find($id);

        return view('frontend.user.user_photo',compact('user'));


    }



    public function User_photoe_Store(Request $request){

        $id = Auth::user()->id;

        $user = User::find($id);

        $old_img = $request->old_img;


        if($user->profile_photo_path == NULL){
            
            $image = $request->file('profile_photo_path');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/users_images/'.$name_gen);
    
            $save_url = 'upload/users_images/'.$name_gen;
    
            $data = User::find(Auth::user()->id);

            $data['profile_photo_path'] = $save_url;

            $data->save();

            $notification = array(
                'message' => 'Photo Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('dashboard')->with($notification);


        }elseif($user->profile_photo_path != NULL){

            unlink($old_img);
            $image = $request->file('profile_photo_path');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/users_images/'.$name_gen);
    
            $save_url = 'upload/users_images/'.$name_gen;
    
            $data = User::find(Auth::user()->id);

            $data['profile_photo_path'] = $save_url;

            $data->save();

            $notification = array(
                'message' => 'Photo Update Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('dashboard')->with($notification);

        }else{

            $notification = array(
                'message' => 'Photo Update Unsuccessfully',
                'alert-type' => 'error'
            );
    
            return redirect()->route('dashboard')->with($notification);
        }

        



    }












}
