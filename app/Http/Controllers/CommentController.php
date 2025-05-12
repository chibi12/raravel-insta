<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request,$post_id){
        $request->validate([
            'comment_body'.$post_id => 'required|max:150'
        ],
        [
            'comment_body'.$post_id . 'required'=>'You cannot submit an empty comment.',
            'comment_body'.$post_id.'max'=>'The comment must not have more than 150 characters'
        ]
    );
        $this->comment->body = $request->input('comment_body'.$post_id);
        $this->comment->user_id = Auth::user()->id;//the owner of the comment
        $this->comment->post_id = $post_id;
        $this->comment->save();

        return redirect()->route('post.show',$post_id);
    }

    /**
     * function to destroy
     */
    public function destroy($comment_id){
        $this->comment->destroy($comment_id);//DELETE FROM comments WHERE id = $comment_id
        return redirect()->back();
    }
}
