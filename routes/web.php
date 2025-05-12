<?php

/**
 * Routes related to regular user
 */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

/**
 * Routes related to Admin user
 */
Use App\Http\Controllers\Admin\UsersController;
Use App\Http\Controllers\Admin\PostsController;
Use App\Http\Controllers\Admin\CategoriesController;


Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/',[HomeController::class,'index'])->name('index');
    Route::get('/people',[HomeController::class,'search'])->name('search');

#posts routes
    Route::get('/post/create',[PostController::class,'create'])->name('post.create');
    Route::post('/post/store',[PostController::class,'store'])->name('post.store');
    Route::get('/post/{post_id}/show',[PostController::class,'show'])->name('post.show');
    Route::get('/post/{post_id}/edit',[PostController::class,'edit'])->name('post.edit');
    Route::patch('/post/{post_id}/update',[PostController::class,'update'])->name('post.update');
    Route::delete('/post/{post_id}/destroy',[PostController::class,'destroy'])->name('post.destroy');

#comments routes
    Route::post('/comment/{post_id}/store',[CommentController::class,'store'])->name('comment.store');
    Route::delete('/comment/{comment_id}/destroy',[CommentController::class,'destroy'])->name('comment.destroy');

#User profile
    Route::get('/profile/{user_id}/show',[ProfileController::class,'show'])->name('profile.show');
    Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile/update',[ProfileController::class,'update'])->name('profile.update');
    Route::get('/profile/{user_id}/followers',[ProfileController::class,'followers'])->name('profile.followers');
    Route::get('/profile/{user_id}/following',[ProfileController::class,'following'])->name('profile.following');

#Likes
    Route::post('/like/{post_id}/store',[LikeController::class,'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy',[LikeController::class,'destroy'])->name('like.destroy');

#Follow/Unfollow
    Route::post('/follow/{user_id}/store',[FollowController::class,'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy',[FollowController::class,'destroy'])->name('follow.destroy');

/**
     * Admin
     */
    Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware'=>'admin.'], function(){
        # Users
        Route::get('/users', [UsersController::class, 'index'])->name('users'); //admin.users
        Route::delete('/users/{user_id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{user_id}/activate',[UsersController::class, 'activate'])->name('users.activate');

        #Posts
        Route::get('/posts',[PostsController::class,'index'])->name('posts');
        Route::delete('/posts/{post_id}/hide',[PostController::class,'hide'])->name('posts.hide');
        Route::patch('/posts/{post_id}/unhide',[PostController::class,'unhide'])->name('posts.unhide');
        
        # Categories
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories/store',[CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('categories/{id}/update',[CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy',[CategoriesController::class, 'destroy'])->name('categories.destroy');
    });

});


