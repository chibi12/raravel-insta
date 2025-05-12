<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;//represents the post table
use App\Models\Category;// represents the categories table

class PostController extends Controller
{
    private $post; //represents the post table
    private $category; //represents the categories table

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }
    /**
     * Method to open the create post
     */

    public function create(){
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories',$all_categories);
    }
    /**
     * Method to create the post
     */

     public function store(Request $request){
        /**
         * Validate the data first
         */
        $request->validate([
            'category'=>'required|array|between:1,3',
            'description'=>'required|min:1|max:1000',
            'image'=>'required|mimes:jpg,jpeg,png,gif|max:1048'

        ]);
        #Save the post
        $this->post->user_id =Auth::user()->id; //the User who is currently logged-in
        $this->post->image = 'data:image/'. $request->image->extension().';base64,'.
        base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;

        //cat.jpg  -->data:image/jpeg;base64,password
        $this->post->save();//post 1

        #Save the categories to the category_post table

        //   category[1,2,3] Travel,Food and Lifestyle
        foreach($request->category as $category_id){
            $category_post[]=['category_id'=>$category_id];
            //$caegory_post[1,2,3]
        }
        $this->post->categoryPost()->createMany($category_post);

        #Back to homepage
        return redirect()->route('index');

     }

     //gets specific post details
     public function show($post_id){
        $post = $this->post->findOrFail($post_id);
        return view('users.posts.show')->with('post',$post);
     }

     //search for the post to edit/update
     public function edit($post_id){
        $post = $this->post->findOrFail($post_id);
        # If the Auth user is NOT THE OWNER of the post,then that user is not
        # Allowed to edit/update the post, then redirect the user to homepage
        if(Auth::user()->id !=$post->user->id){
            return redirect()->route('index');
        }
        # Get all category from the categories table
        $all_categories = $this->category->all();

        # Get all the category IDs of this post.Save it in an array
        $selected_categories = [];
        foreach($post->categoryPost as $category_post){
            $selected_categories[]=$category_post->category_id;
        }
        return view('users.posts.edit')
        ->with('post',$post)
        ->with('all_categories',$all_categories)
        ->with('selected_categories',$selected_categories);
     }

     # Method that perform the actual updating the post details
     public function update(Request $request, $post_id){
        #1. Validate the data first
        $request->validate([
            'category' => 'required|array|between:1,3 ',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Update the post
        $post = $this->post->findOrFail($post_id);
        $post->description = $request->description;

        # Check if there is new image uploaded
        if($request->image){
            $post->image = 'data:image /'.$request->image->extension().';base64'.base64_encode(file_get_contents($request->image));
        }
        $post->save();

        # Delete all records from category_post related to this post
        $post->categoryPost()->delete();
        //we use the relationship Post::categoryPost() to select the records related to the post
        //Equivalent: "DELETE FROM category_post WHERE id = $post_id"
        
        # 4. Save the new selected categories to the category_post table
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id'=> $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        # 5. Redirect to show post page to confirm the update
        return redirect()->route('post.show', $post->id);
     }

     /**
      * Function that deletes the post
      */
      public function destroy($post_id){
        // $this->post->findOrFail($post_id)->forceDelete();//DELETE FROM posts WHERE id=$post_id
        $this->post->findOrFail($post_id)->forceDelete();
        return redirect()->route('index');//homepage
      }

}
