<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($user_id){
        $user = $this->user->findOrFail($user_id);
        return view('users.profile.show')->with('user', $user);
    }

    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    /**
     * Function that does the actual update
     * The data is coming from the form in edit.blade.php
     */
    public function update(Request $request){
        #validate
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,'.Auth::user()->id,
            'avatar' => 'mimes:jpeg,jpg,gif,png|max:1048',
            'introduction' => 'max:100'
        ]);


        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        # Check if there is an uploaded avatar/image
        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        #Save
        $user->save();

        #redirect to profile page
        return redirect()->route('profile.show', Auth::user()->id);
    }
    public function followers($user_id){
        $user = $this->user->findOrFail($user_id);
        return view('users.profile.followers')
        ->with('user',$user);
    }
    public function following($user_id){
        $user = $this->user->findOrFail($user_id);
        return view('users.profile.following')
        ->with('user',$user);
    }
}
