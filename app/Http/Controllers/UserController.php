<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(){
        return view('register');
    }

    public function registerProcess(Request $request){
            $data = $request->validate([
                'name' => 'required',
                'username' => 'required | unique:users',
                'email' => 'required | email | unique:users',
                'password' => 'required'
            ]);

            User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            return redirect('/');
    }

    public function login(){
        return view('login');
    }

    public function loginProcess(Request $request){
        $data = $request->validate([
            'email' => 'email | required',
            'password' => 'required',
        ]);

        // $email = User::where('email', $data)->first();

        // if (!$email) return back();

        // $cek = Hash::check($request->password, $email->password);

        // if (!$cek) return back();

        // $request->session()->put('id', $email);

        $data = $request->only(['email','password']);
        if(Auth::attempt($data)){
            return redirect('/home');
        }else{
            return redirect('/');
        }


        return redirect('/home');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}


