<?php

namespace App\Http\Controllers\Test;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Test extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest');
    }

    public function show(User $user)
    {
        dd(captcha_src('flat'));
        $result = $this->authorize('update',$user);
        dd($result);
        dd('yes');
    }

    //
    public function index(Request $request)
    {

        $data = $request->toArray();
        if (Auth::guard()->attempt($data,true)) {
            return '登录成功';
        }else{
            return '登录失败';
        }

        var_dump(str_contains('冉凯 冉博哲 冉闵 a 冉未凡',['fsdaf','asdfasda','dasdasd']));
        $array = [
            [
                'A',
                'Roman',
                'Taylor',
                'Li',
                'B',
            ],
            [
                'C',
                'PHP',
                'Ruby',
                'JavaScript',
                'A' => [
                    'B',
                    'C',
                    'A'
                ]
            ],
        ];
        var_dump(array_sort_recursive($array));
        $array1 = [
            ['name' => 'Desk'],
            ['name' => 'Chair'],
            ['name' => 'Ahair'],
            ['name' => 'Bhair'],
        ];

        $array = array_values(array_sort($array1, function ($value) {
            return $value['name'];
        }));
        var_dump(array_values(array_sort($array1, function ($value) {
            return $value['name'];
        })));
        $array = ['products' => ['desk' => ['price' => 100]]];

        var_dump(array_set($array, 'products.desk.name', 200),$array);
        $array = ['name'=>'冉凯','array_forget'=>['name' => 'Joe', 'languages' => ['PHP', 'Ruby']],['冉未凡',['冉博哲',['name'=>'冉闵']]]];
        var_dump(array_forget($array,'array_forget.languages.1'),$array);
        var_dump(array_flatten(['name'=>'冉凯',['冉未凡',['冉博哲',['冉闵']]]]));
        var_dump(array_add(['name'=>'desk'],'age','21'));
        var_dump(array_collapse([[1,2,3],[1,2,3],['name'=>'冉凯'],['name'=>'冉未凡']]));
        $result = array_divide(['name'=>'冉凯','age'=>'21']);
        var_dump($result);
        var_dump(array_dot(['foo'=>'foo','bar'=>['bar'=>'bar','c'=>['c'=>'c']]]));
        var_dump(array_first(['冉凯','冉未凡','冉博哲','冉闵'],function($value){
            return $value === '冉';
        },'冉有'));
    }
}
