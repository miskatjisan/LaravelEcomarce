<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminProfileController extends Controller
{
    
    public function Admin_Profile(){

        $adminData = DB::table('admins')->find(1);

        return view('admin.admin_profile.admin_profile_view',compact('adminData'));

    }

    
    public function Admin_Username(){

        $adminData = DB::table('admins')->find(1);

        return view('admin.admin_profile.admin_username',compact('adminData'));


    }

    public function Admin_Photo(){
        
        $adminData = DB::table('admins')->find(1);

        return view('admin.admin_profile.admin_photo',compact('adminData'));


    }

    public function Admin_Password(){
        
        $adminData = DB::table('admins')->find(1);

        return view('admin.admin_profile.admin_password',compact('adminData'));


    }

    public function Change_Username(Request $request){

        $data = array();

        $data['name'] = $request->name;
        $data['email'] = $request->email;

        $update = Admin::find(1)->update($data);

        return redirect()->route('admin.profile');

    }

    

    public function Change_Photo(Request $request){




        $data = array();
        $data['profile_photo_path'] = $request->file('profile_photo_path');
      
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/admin_images'.$data->profile_photo_path));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_photo_path'] = $filename;

       $update = DB::table('admins')->update($data);

       return redirect()->route('admin.profile');

    }


    public function Change_Password(Request $request){

        $validateData = $request->validate([

            'old_password' => 'required',
            'password' => 'required|confirmed'

        ]);

        $hashedPassword = Admin::find(1)->password;

        if(Hash::check($request->old_password,$hashedPassword)){

            $admin = Admin::find(1);
            $admin->password = Hash::make($request->password);
            $admin->save();

            Auth::logout();
            return redirect()->route('admin.logout');
        }else{

            return redirect()->back();
        }

        


    }





    public function AllUsers(){
		$users = User::latest()->get();
		return view('backend.user.all_user',compact('users'));
	}







}
