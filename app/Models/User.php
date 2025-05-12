<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    const ADMIN_ROLE_ID = 1; //administrator
    const USER_ROLE_ID = 2; //user

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    # Use this method to get all the posts of a user
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    /**
     * Use this method to get all the followers of the user
     */
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id'); // the id of the user being followed
    }

    /**
     * Users table
     * 1   John Smith
     * 2   Tim Watson
     * 3   Mark Twain
     * 4   Jane Doe
     * 5   Hack Finn
     * 
     * 
     * Follows table
     * 
     * follower_id              following_id
     *    1                          2
     *    1                          3
     *    3                          2
     *    5                          2
     *    1                          4
     */

     /**
      * Use this method to get all the user the user is following
      */
      public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
      }

      //Check if the Auth user already following the user
      public function is_followed(){
        return $this->followers()->where('follower_id',Auth::user()->id)->exists();
        //This function will return True or False
        //Auth::user()->id --- the logged in user
        //$this->follwers()--- get all the followers
        //where ('follow_id',Auth::user()->id->exists)---check if the id of the log
      }
}

