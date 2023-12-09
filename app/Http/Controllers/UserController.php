<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return view('login');
    }

    public function ProsesLogin(Request $request): RedirectResponse{
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credencil = $request->only('email', 'password');
        dd(Auth::attempt($credencil));
        
        if(Auth::attempt($credencil)){
            $user = Auth::user();
            if($user->role != '' || $user->role != null){
                return redirect()->intended('dashboard');
            }
            return redirect()->intended('dashboard');
        }
        return redirect('/');
    }

    public function dashboard(){
        return view('master_layout.dashbord');
    }

    public function logout(Request $request){
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}