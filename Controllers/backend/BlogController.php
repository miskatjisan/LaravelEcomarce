<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogPostCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Image;


class BlogController extends Controller
{
   
    
    public function BlogCategory(){

    	$blogcategory = BlogPostCategory::latest()->get();
    	return view('backend.blog.category.category_view',compact('blogcategory'));
    }



    public function BlogCategoryStore(Request $request){

        $request->validate([
             'blog_category_name_en' => 'required',
             'blog_category_name_others' => 'required',
 
         ],[
             'blog_category_name_en.required' => 'Input Blog Category English Name',
             'blog_category_name_others.required' => 'Input Blog Category Others Name',
         ]);
 
 
 
     BlogPostCategory::insert([
        'blog_category_name_en' => $request->blog_category_name_en,
         'blog_category_name_others' => $request->blog_category_name_others,
         'blog_category_slug_en' => strtolower(str_replace(' ', '-',$request->blog_category_name_en)),
         'blog_category_slug_others' => str_replace(' ', '-',$request->blog_category_name_others),
         'created_at' => Carbon::now(),
 
 
         ]);
 
         $notification = array(
             'message' => 'Blog Category Inserted Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->back()->with($notification);
 
     } // end method 
 
 
 
     public function BlogCategoryEdit($id){
 
    $blogcategory = BlogPostCategory::findOrFail($id);
         return view('backend.blog.category.category_edit',compact('blogcategory'));
     }
 
 
 
 
 public function BlogCategoryUpdate(Request $request){
 
        $blogcar_id = $request->id;
 
 
     BlogPostCategory::findOrFail($blogcar_id)->update([
         'blog_category_name_en' => $request->blog_category_name_en,
         'blog_category_name_others' => $request->blog_category_name_others,
         'blog_category_slug_en' => strtolower(str_replace(' ', '-',$request->blog_category_name_en)),
         'blog_category_slug_others' => str_replace(' ', '-',$request->blog_category_name_others),
         'created_at' => Carbon::now(),
 
 
         ]);
 
         $notification = array(
             'message' => 'Blog Category Updated Successfully',
             'alert-type' => 'info'
         );
 
         return redirect()->route('blog.category')->with($notification);
 
     } // end method 
















      ///////////////////////////// Blog Post ALL Methods //////////////////


      public function AddBlogPost(){

    $blogcategory = BlogPostCategory::latest()->get();
  	$blogpost = BlogPost::latest()->get();
  	return view('backend.blog.post.post_view',compact('blogpost','blogcategory'));

  }   


  public function ListBlogPost(){
    $blogpost = BlogPost::with('category')->latest()->get();
    return view('backend.blog.post.post_list',compact('blogpost'));
    
}




  public function BlogPostStore(Request $request){

    $request->validate([
          'post_title_en' => 'required',
          'post_title_others' => 'required',
          'post_image' => 'required',
          'post_details_en' => 'required',
          'post_details_others' => 'required',
          'category_id' => 'required',
      ],[
          'post_title_en.required' => 'Input Post Title English Name',
          'post_title_others.required' => 'Input Post Title Others Name',

      ]);

      $image = $request->file('post_image');
      $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
      Image::make($image)->resize(780,433)->save('upload/post/'.$name_gen);
      $save_url = 'upload/post/'.$name_gen;

  BlogPost::insert([
      'category_id' => $request->category_id,
      'post_title_en' => $request->post_title_en,
      'post_title_others' => $request->post_title_others,
      'post_slug_en' => strtolower(str_replace(' ', '-',$request->post_title_en)),
      'post_slug_others' => str_replace(' ', '-',$request->post_title_others),
      'post_image' => $save_url,
      'post_details_en' => $request->post_details_en,
      'post_details_others' => $request->post_details_others,
      'created_at' => Carbon::now(),

      ]);

      $notification = array(
          'message' => 'Blog Post Inserted Successfully',
          'alert-type' => 'success'
      );

      return redirect()->route('list.post')->with($notification);

} // end mehtod 



    public function BlogPostEdit($id){

        $blogpost = BlogPost::FindOrFail($id);
        $blogcategory = BlogPostCategory::latest()->get();

    return view('backend.blog.post.post_edit',compact('blogpost','blogcategory'));

    }


    public function BlogPostUpdate(Request $request){

        $request->validate([
            'post_title_en' => 'required',
            'post_title_others' => 'required',
            'post_details_en' => 'required',
            'post_details_others' => 'required',
            'category_id' => 'required',
        ],[
            'post_title_en.required' => 'Input Post Title English Name',
            'post_title_others.required' => 'Input Post Title Others Name',
  
        ]);


        $old_id = $request->old_id;
        $old_img = $request->old_img;


        if($request->post_image){

        @unlink($old_img);
         $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(780,433)->save('upload/post/'.$name_gen);
        $save_url = 'upload/post/'.$name_gen;

        BlogPost::FindOrFail($old_id)->update([
      'category_id' => $request->category_id,
      'post_title_en' => $request->post_title_en,
      'post_title_others' => $request->post_title_others,
      'post_slug_en' => strtolower(str_replace(' ', '-',$request->post_title_en)),
      'post_slug_others' => str_replace(' ', '-',$request->post_title_others),
      'post_image' => $save_url,
      'post_details_en' => $request->post_details_en,
      'post_details_others' => $request->post_details_others,
      'created_at' => Carbon::now(),

      ]);

      $notification = array(
          'message' => 'Blog Post Update Successfully',
          'alert-type' => 'success'
      );

      return redirect()->route('list.post')->with($notification);



        }else{


            BlogPost::FindOrFail($old_id)->update([
                'category_id' => $request->category_id,
                'post_title_en' => $request->post_title_en,
                'post_title_others' => $request->post_title_others,
                'post_slug_en' => strtolower(str_replace(' ', '-',$request->post_title_en)),
                'post_slug_others' => str_replace(' ', '-',$request->post_title_others),
                'post_details_en' => $request->post_details_en,
                'post_details_others' => $request->post_details_others,
                'created_at' => Carbon::now(),
          
                ]);
          
                $notification = array(
                    'message' => 'Blog Post Update Successfully',
                    'alert-type' => 'success'
                );
          
                return redirect()->route('list.post')->with($notification);



        }






    }






    public function BlogPostDelete($id){

        $blogpost = BlogPost::FindOrFail($id);

        $img = $blogpost->post_image;
        unlink($img);

        BlogPost::FindOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' => 'success'
        );
  
        return redirect()->back()->with($notification);

    }






}
