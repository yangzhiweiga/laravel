<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view('register/index');
    }

    //注册行为
    public function register()
    {
        $this->validate(request(),[
            'name'=>'required|unique:users,name',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|min:5|max:10|confirmed'
        ]);

        $name = Request('name');
        $email = Request('email');
        $password = bcrypt(Request('password'));
        User::create(compact('name','email','password'));

        return redirect('/login');
    }
}
