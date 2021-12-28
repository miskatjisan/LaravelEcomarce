<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteSetting;
use Image;
use App\Models\Seo;



class SiteSettingController extends Controller
{
    
    
    public function Header_SiteSetting(){

    	$setting = SiteSetting::find(1);
    	return view('backend.setting.header_setting_update',compact('setting'));
    }








    public function Header_SiteSetting_update(Request $request){

    	$setting_id = $request->id;
        $old_log = $request->old_logo;
        $old_favi = $request->old_favicon;

        $logo = $request->file('logo');
        $favicon = $request->file('favicon');


    	if ($favicon && $logo) {

            unlink($old_favi);

            $fav_image = $request->file('favicon');
            $favi_name_gen = hexdec(uniqid()).'.'.$fav_image->getClientOriginalExtension();
            Image::make($fav_image)->resize(80,80)->save('upload/logo/'.$favi_name_gen);
            $save_favicon = 'upload/logo/'.$favi_name_gen;


            unlink($old_log);
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(139,36)->save('upload/logo/'.$name_gen);
            $save_url = 'upload/logo/'.$name_gen;
    
        SiteSetting::findOrFail($setting_id)->update([
            'favicon_name_en' => $request->favicon_name_en,
            'favicon_name_others' => $request->favicon_name_others,
            'favicon' => $save_favicon,
            'logo' => $save_url,
            
    
            ]);

	    $notification = array(
			'message' => 'Setting Update with Image Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    	}elseif($favicon){

            unlink($old_favi);

            $fav_image = $request->file('favicon');
            $favi_name_gen = hexdec(uniqid()).'.'.$fav_image->getClientOriginalExtension();
            Image::make($fav_image)->resize(80,80)->save('upload/logo/'.$favi_name_gen);
            $save_favicon = 'upload/logo/'.$favi_name_gen;
    
        SiteSetting::findOrFail($setting_id)->update([
            'favicon_name_en' => $request->favicon_name_en,
		    'favicon_name_others' => $request->favicon_name_others,
            'favicon' => $save_favicon,
    
            ]);
    
            $notification = array(
                'message' => 'Setting Updated with Image Successfully',
                'alert-type' => 'info'
            );
    
            return redirect()->back()->with($notification);



        }elseif($logo){

            unlink($old_log);
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(139,36)->save('upload/logo/'.$name_gen);
            $save_url = 'upload/logo/'.$name_gen;
    
        SiteSetting::findOrFail($setting_id)->update([
            'favicon_name_en' => $request->favicon_name_en,
            'favicon_name_others' => $request->favicon_name_others,
            'logo' => $save_url,
    
            ]);
            

         
    
            $notification = array(
                'message' => 'Setting Updated with Image Successfully',
                'alert-type' => 'info'
            );
    
            return redirect()->back()->with($notification);



        }else{

    	SiteSetting::findOrFail($setting_id)->update([
            'favicon_name_en' => $request->favicon_name_en,
            'favicon_name_others' => $request->favicon_name_others,


    	]);

	    $notification = array(
			'message' => 'Setting Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    	} // end else 
    } // end method 














    public function Footer_SiteSetting(){

    	$setting = SiteSetting::find(1);
    	return view('backend.setting.footer_setting_update',compact('setting'));
    }


    public function Footer_SiteSetting_update(Request $request){

        $setting_id = $request->id;

        SiteSetting::findOrFail($setting_id)->update([

            'company_name_en' => $request->company_name_en,
            'company_name_others' => $request->company_name_others,
            'company_address_en' => $request->company_address_en,
            'company_address_others' => $request->company_address_others,
            'phone_one_en' => $request->phone_one_en,
            'phone_one_others' => $request->phone_one_others,
            'phone_two_en' => $request->phone_two_en,
            'phone_two_others' => $request->phone_two_others,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        


    	]);

	    $notification = array(
			'message' => 'Footer Setting Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }










    ///////////////// Seo section Start ////////////

    public function SeoSetting(){

    	$seo = Seo::find(1);
    	return view('backend.setting.seo_update',compact('seo'));

    }



    public function SeoSettingUpdate(Request $request){

    	$seo_id = $request->id;

    	Seo::findOrFail($seo_id)->update([
		'meta_title' => $request->meta_title,
		'meta_author' => $request->meta_author,
		'meta_keyword' => $request->meta_keyword,
		'meta_description' => $request->meta_description,
		'google_analytics' => $request->google_analytics,		 

    	]);

	    $notification = array(
			'message' => 'Seo Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    } // end mehtod 








}
