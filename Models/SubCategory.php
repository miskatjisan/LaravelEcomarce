<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'Category_id',
        'subcategory_name_en',
        'subcategory_name_others',
        'subcategory_slug_en',
        'subcategory_slug_others',
        
    ];

    public function Re_Category(){


        return $this->belongsTo(Category::class,'Category_id','id');
    }


}
