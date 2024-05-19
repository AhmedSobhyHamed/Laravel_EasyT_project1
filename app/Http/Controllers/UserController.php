<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for athenticate user.
     */
    public function login()
    {
        // Auth::logout();
        //go to login
        return view('user.login')
        ->with('title','LogIn')
        ->with('pageicon','')
        ->with('pageDescription','')
        ->with('pageKeywords','')
        ->with('pageOGimg','')
        ->with('pageStyle',url('storage/css/login.css'))
        ->with('pageScript','');
    }

    /**
     * Show the form for athenticate user.
     */
    public function signup()
    {
        //go to login
        return view('user.signup')
        ->with('title','Sign Up')
        ->with('pageicon','')
        ->with('pageDescription','')
        ->with('pageKeywords','')
        ->with('pageOGimg','')
        ->with('pageStyle',url('storage/css/signup.css'))
        ->with('pageScript','');
    }

    /**
     * authnticate user.
     */
    public function authenticate(Request $req)
    {
        //authinticate user and go to home
        $user = User::where(['email'=>$req->em,])->first();
        if(!isset($user)) {
            return redirect(route('loginRoute'));
        }
        else {
            Auth::login($user);
            return redirect(route('blogRoute'));
        }
    }

    /**
     * show all users user.
     */
    public function index()
    {
        //get all user and preview frindes you may know page
        // if new then git 20 random , if have friends then git friend of friends first
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //go to signup
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //create user and og to home
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //go to  users profile
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //go to edit profile page
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //update the user and go to profile
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //delete ehe user and go to login
    }
}
