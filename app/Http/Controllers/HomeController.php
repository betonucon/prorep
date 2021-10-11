<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request){
        if(Auth::user()['role_id']==4){
            $menu='Dashboard';
            $cost=Auth::user()['costcenter_id'];
            return view('welcome_user',compact('menu','cost'));
        }
        if(Auth::user()['role_id']==1){
            $menu='Dashboard';
            $cost=2;
            return view('welcome_utama',compact('menu','cost'));
        }else{
            $menu='Dashboard';
            $cost=Auth::user()['costcenter_id'];
            return view('welcome',compact('menu','cost'));
        }
        
    }
}
