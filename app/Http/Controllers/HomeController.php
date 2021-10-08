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
        
            return view('welcome_user',compact('menu'));
        }else{
            $menu='Dashboard';
        
            return view('welcome',compact('menu'));
        }
        
    }
}
