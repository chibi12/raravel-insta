<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    private $post;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post,User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();

        // $all_posts = $this->post->latest()->get();
        return view('users.home')
            ->with('home_posts',$home_posts)
            ->with('suggested_users',$suggested_users);
    }

    /**
     * Get the posts of the users that the AUTH USER (logged in user)is following
     *
     */
    public function getHomePosts(){
        $all_posts = $this->post->latest()->get(); //SELECT*FROM posts ORDER BY created_at;
        $home_posts = [];

        foreach($all_posts as $post){
            if($post->user->is_followed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
            }
        }

        return $home_posts; //this is an array that contains the posts of all the users that the logged-in user followed
    }

    private function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->is_followed()){
                $suggested_users[] = $user;
            }
        }
        return array_slice($suggested_users,0,5);
        /**
         * array_slice(x,y,z)
         * array_slice(name_of_array,starting_index,how_many_to _display)
         */
    }

    public function search(Request $request){
        $user = $this->user->where('name','like','%'. $request->search.'%')->get();
        return view('users.search')->with('users',$users)->with('search',$request->search);
    }
}
