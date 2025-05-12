<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Post extends Model
{
    use SoftDeletes;
    # A post belongs to a user
    # Use this method to get the owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    # Use this method to get the categories under a specific post
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    /**
     * Use this method to get all the comments of the post
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
     * Use this method to get the likes of the post
     */
    public function likes(){
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the post is being liked already by the AUTH USER (the loggged-in user)
     */
    public function isLiked(){ // Is it true that the logged in user like the post already?
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}

