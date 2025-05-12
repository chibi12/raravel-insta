<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Use this method to get the info of the owner of the comments
     */
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
}
