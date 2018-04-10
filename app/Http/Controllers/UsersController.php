<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功！');
    }

    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    //
    public function show(User $user)
    {
        $this->authorize('update',$user);
        $test = ['name'=>'测试'];
        return view('users.show',compact('user','test'));
    }
}
