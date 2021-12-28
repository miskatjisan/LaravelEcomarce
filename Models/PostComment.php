<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function blogpost(){
        return $this->belongsTo(BlogPost::class,'blog_post_id','id');
    }
 
 
     public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
