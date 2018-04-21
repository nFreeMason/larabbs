<?php

namespace App\Http\Controllers;

use App\Handlers\UploadHandler;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Torann\GeoIP\Facades\GeoIP;
use Geocoder\Laravel\Facades\Geocoder;

class UsersController extends Controller
{

    public function __construct()
    {

    }

    public function store()
    {
        dd(123);
    }

    public function update(UserRequest $request, UploadHandler $uploader, User $user)
    {
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            return redirect()->route('root');
        }
        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    public function edit(User $user)
    {
//        dd(\request()->input(),$user);
        try {
            $this->authorize('update', $user);
        } catch (AuthorizationException $e) {
            return redirect()->route('root');
        }
//        dd(false > 0,strtotime('1970-01-01 8:00:00'),$user);
//        dd(GeoIP::getLocation('8.8.8.8'));
//        dd(app('geocoder')->reverse('43.882587','-103.454067')->get());
//        dd(e('<script>alert(1)</script>'),htmlspecialchars_decode('&lt;span&gt;测试@#$%&lt;/span&gt;'),'<script>alert(1)</script>');
//        dd($user->find(2));
        return view('users.edit', compact('user'));
    }

    //
    public function show(User $user)
    {
        $this->authorize('update', $user);
        $test = ['name' => '测试'];
        return view('users.show', compact('user', 'test'));
    }
}
