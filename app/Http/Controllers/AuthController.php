<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
  $user = User::where('username', $request->username)->first();

  if ($user && Hash::check($request->password, $user->password)) {
      Auth::login($user); // ini login manual pakai model
      $request->session()->regenerate();
    
      return redirect()->route('dashboard')->with('success', 'Anda Berhasil Login!!');
  } else {
      return redirect()->route('admin.login')->with('error', 'Email atau password anda salah');
  }
}
 public function logout() {
      Auth::logout();
      return redirect()->route('admin.login');
  }

}
