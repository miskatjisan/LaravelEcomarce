<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogPostCategory;
use App\Models\BlogPost;
use App\Models\PostComment;
use Carbon\Carbon;
use Auth;

class HomeBlogController extends Controller
{
   
    

    public function AddBlogPost(){

    	$blogcategory = BlogPostCategory::latest()->get();
    	$blogpost = BlogPost::latest()->paginate(20);
    	return view('frontend.blog.blog_list',compact('blogpost','blogcategory'));

    }



	public function DetailsBlogPost($id){

        $blogcategory = BlogPostCategory::latest()->get();
    	$blogpost = BlogPost::findOrFail($id);
    	return view('frontend.blog.blog_details',compact('blogpost','blogcategory'));
    }

	public function HomeBlogCatPost($category_id){

    	$blogcategory = BlogPostCategory::latest()->get();
    	$blogpost = BlogPost::where('category_id',$category_id)->orderBy('id','DESC')->paginate(20);
    	return view('frontend.blog.blog_cat_list',compact('blogpost','blogcategory'));

    } // end mehtod 



	public function Post_comment(Request $request){

		$post_id = $request->blog_post_id;

		if(Auth::check()) {

			$request->validate([
				'comment' => 'required',
				
			],[
				'comment.required' => 'At first write your comment',
	  
			]);

			PostComment::insert([
				'blog_post_id' => $post_id,
				'user_id' => Auth::id(),
				'comment' => $request->comment,
				'created_at' => Carbon::now(),
	
			]);
	
			$notification = array(
				'message' => 'Post comment Will Approve By Admin',
				'alert-type' => 'success'
			);
	
			return redirect()->back()->with($notification);



		}else{

			$notification = array(
				'message' => 'At First Login Your Account',
				'alert-type' => 'error'
			);
	
			return redirect()->back()->with($notification);

		}






	}

	



	public function PendingBlog(){

		$review = PostComment::where('status',0)->orderBy('id','DESC')->get();

				return view('backend.blog_post_review.pendding_review',compact('review'));
	}



	public function Review_Blog_Approve($id){


		PostComment::where('id',$id)->update(['status' => 1]);

    	$notification = array(
            'message' => 'Review Approved Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
	}


	public function Publish_blog_Review(){

		$review = PostComment::where('status',1)->orderBy('id','DESC')->get();

		return view('backend.blog_post_review.publish_review',compact('review'));

	}

	public function Delete_blog_Review($id){

		PostComment::findOrFail($id)->delete();
    
		$notification = array(
			'message' => 'Review Delete Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

	}









}
