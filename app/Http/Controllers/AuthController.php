<?php

namespace App\Http\Controllers;

// use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register() {
        return view('pages.admin.auth.register');
    } 
    public function registersubmit(Request $request) {
      $user = new User();
      $user->name     = $request->first_name . ' ' . $request->last_name; // gabung nama
      $user->username = $request->username;
      $user->password = bcrypt($request->password);
      $user->save();
       
      return redirect()->route('admin.login')->with('success', 'akun anda berhasil dibuat!!');
      
  }
     public function login()
    {
        return view('pages.admin.auth.login',);
    }

    public function login_proses(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    if (Auth::guard('web')->attempt([
        'username' => $request->username,
        'password' => $request->password,
    ])) {

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Anda Berhasil Login!!');
    }

    return redirect()->route('admin.login')
        ->with('error', 'Username atau password salah');
}

 public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('message', 'logout');
    }



}
