<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\User

class Category extends Model
{
    public function categoryPosts(){
      return $this->hasMany(CategoryPost::class);
    }

}
