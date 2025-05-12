<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(5);//5 users per page 
        //SELECT * FROM users ORDER BY created_at
        //The withTrashed() will include the soft deleted users in the query results.
        //all_users = $this->user->all()

        return view('admin.users.index')
        ->with('all_users',$all_users);
    }

    /**
     * Note: the user will not totally removed because we have applied softdelete in the modal.
     */
    public function deactivate($user_id){
        $this->user->destroy($user_id);
        return redirect()->back();
    }

    /**
     * This function activate the use
     */
    public function activate($user_id){
        $this->user->onlyTrashed()->findOrFail($user_id)->restore();
        return redirect()->back();
        #This query (with the lp of  only trashed() function) is going to search
        #for the softDeleted users($user_id)  in the "deleted_at" column and restore it.
    }
}
