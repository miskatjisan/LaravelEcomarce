<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubSubCategory;
use App\Models\Product;
use App\Models\MultiImg;
use App\Models\BlogPost;
use App\Models\FAQ;
use App\Models\SiteSetting;
use App\Models\About;


class IndexController extends Controller
{
   
    
    public function Index(){



        $all_category = Category::where('status',1)->orderBy('category_name_en','ASC')->limit(5)->get();
        $new_products = Product::where('status',1)->where('new_product',1)->orderBy('id','DESC')->limit(15)->get();
        $hot_deals = Product::where('status',1)->where('hot_deal',1)->orderBy('id','DESC')->limit(15)->get();
        $special_offers = Product::where('status',1)->where('special_offer',1)->orderBy('id','DESC')->limit(15)->get();
        $special_deals = Product::where('status',1)->where('special_deals',1)->orderBy('id','DESC')->limit(5)->get();
        $featured = Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(15)->get();
        $beat_sellers = Product::where('status',1)->where('beat_seller',1)->orderBy('id','DESC')->limit(15)->get();
        $new_arrivals = Product::where('status',1)->where('new_arrivals',1)->orderBy('id','DESC')->limit(15)->get();
        $blogpost = BlogPost::latest()->get();
        
        return view('frontend.index_home',compact('new_products','all_category','hot_deals','special_offers','special_deals','featured','beat_sellers','new_arrivals','blogpost'));
    }



    public function Product_details($id,$slug){

        $products = Product::findOrFail($id);
        $multiImag = MultiImg::where('product_id',$id)->get();


        $color_en =  $products->product_color_en;
        $product_color_en = explode(',', $color_en);

        $color_others =  $products->product_color_others;
        $product_color_others = explode(',', $color_others);

        $size_en =  $products->product_size_en;
        $product_size_en = explode(',', $size_en);

        $size_others =  $products->product_size_others;
        $product_size_others = explode(',', $size_others);

        
        $cat_id = $products->Category_id;

        $brands = Product::with('brand')->findOrFail($id);

        $related_product = Product::where('status',1)->where('Category_id', $cat_id)->orderBy('id','DESC')->get();


        return view('frontend.products.product_details',compact('products','multiImag','product_color_en','product_color_others','product_size_en','product_size_others','related_product','brands'));
    }


    public function Product_tag_en($tags){

        $products = Product::where('status',1)->where('product_tags_en',$tags)
        ->orderBy('id','DESC')->paginate(20);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $bread_tag_en = Product::where('product_tags_en',$tags)->first();

        return view('frontend.tags.products_tag_en',compact('products','categories','bread_tag_en'));
    }


    public function Product_tag_others($tag){

        $products = Product::where('status',1)->where('product_tags_others',$tag)
        ->orderBy('id','DESC')->paginate(20);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $bread_tag_others = Product::where('product_tags_others',$tag)->first();

        return view('frontend.tags.products_tag_others',compact('products','categories','bread_tag_others'));
    }


    public function Category_Product_show($id,$slug){

        $products = Product::where('status',1)->where('category_id',$id)
        ->orderBy('id','DESC')->paginate(20);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $breadcat = Category::where('id',$id)->first();

        return view('frontend.products.category_view',compact('products','categories','breadcat'));

    }


    public function Sub_subProduct_show($id,$sub_subslug){

        $products = Product::where('status',1)->where('sub_subcategory_id',$id)
        ->orderBy('id','DESC')->paginate(20);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $breadsubsubcat = SubSubCategory::with(['Re_Category','Re_SubCategory'])->where('id',$id)->get();

        return view('frontend.products.sub_subcategory',compact('products','categories','breadsubsubcat'));

    }

    public function Sub_Product_show($id,$sub_subslug){

        $products = Product::where('status',1)->where('subcategory_id',$id)
        ->orderBy('id','DESC')->paginate(20);
        $categories = Category::orderBy('category_name_en','ASC')->get();

        $categories = Category::orderBy('category_name_en','ASC')->get();

        $breadsubcat = SubCategory::with(['Re_Category'])->where('id',$id)->get();

        return view('frontend.products.subcategory',compact('products','categories','breadsubcat'));

    }







        /// Product View With Ajax

        public function ProductViewAjax($id){
            $product = Product::with('category','brand')->findOrFail($id);

            $color = $product->product_color_en;
            $product_color = explode(',', $color);

            $size = $product->product_size_en;
            $product_size = explode(',', $size);

            

            return response()->json(array(
                'product' => $product,
                'color' => $product_color,
                'size' => $product_size,

            ));

        } // end method 


         // Product Seach 
	public function ProductSearch(Request $request){
		$item = $request->search;
        $request->validate(["search" => "required"]);
		// echo "$item";
        $categories = Category::where('show_product',NULL)->orderBy('category_name_en','ASC')->get();
		$products = Product::where('product_name_en','LIKE',"%$item%")->get();
		return view('frontend.products.search',compact('products','categories'));


	}



    ///// Advance Search Options 

	public function SearchProduct(Request $request){

		$request->validate(["search" => "required"]);

		$item = $request->search;		 

		$products = Product::where('product_name_en','LIKE',"%$item%")->select('product_name_en','product_thambnail','selling_price_en','id','product_slug_en')->limit(5)->get();
		return view('frontend.products.search_product',compact('products'));
	} // end method 





    public function View_FAQ(){

        $faq = FAQ::latest()->get();

        return view('frontend.FAQ.view_faq',compact('faq'));
    }


    public function View_Contact(){

        $SiteSetting = SiteSetting::first();

        return view('frontend.contact_us.contact_us',compact('SiteSetting'));
    }


    
    public function About(){

        $about = About::first();

        return view('frontend.about.about_view',compact('about'));
    }








}
