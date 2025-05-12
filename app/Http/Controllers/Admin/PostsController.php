<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->post = $post;

    }
    public function index(){
        $all_posts = $this->post->withTrashed()->latest()->paginate(5);
        return view('admin.posts.index')
        ->with('all_posts',$all_posts);
    }

    /**
     * Method to hide the post
     */
    public function hide($post_id){
        $this->post->destroy($post_id);
        return redirect()->back();
    }

    public function unhide($post_id){
        $this->post->onlyTrashed()->findOrFail($post_id)->restore();
        return redirect()->back();
    }
}
