<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\SubCategory;

class SubSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'Category_id',
        'subcategory_id',
        'sub_subcategory_name_en',
        'sub_subcategory_name_others',
        'sub_subcategory_slug_en',
        'sub_subcategory_slug_others',
        
    ];

    public function Re_Category(){
        return $this->belongsTo(Category::class,'Category_id','id');
    }


    public function Re_SubCategory(){
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

}
