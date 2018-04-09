<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function show(User $user)
    {
        $test = ['name'=>'冉'];
        return view('users.show',compact('user','test'));
    }
}
