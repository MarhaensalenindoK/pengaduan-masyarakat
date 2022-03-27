<?php

namespace App\Http\Controllers;

use App\Service\Database\UserService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function check(Request $request){
        if (! Auth::check() && $request->is('login')) {
            return view('authentication.login');
        } elseif (! Auth::check()) {
            return redirect('home');
        }

        $role = strval(Auth::user()->role);

        $route = strtolower($role) . '/dashboard';
        return redirect($route);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(($credentials + ['status' => true]))){
            $user = Auth::user();

            return redirect( strtolower($user->role) . '/dashboard');
        }

        return redirect('login')->with('error', true);
    }

    public function logout(){
        Auth::logout();

        return redirect('/login');
    }

    public function resetPassword(Request $request) {
        $DBuser = new UserService;

        $userId = $request->user_id;
        $password = $request->password;

        $payload = [
            'password' => $password,
        ];

        $DBuser->update($userId, $payload);

        return redirect( strtolower(Auth::user()->role) . '/dashboard');
    }

    public function registerView() {

        return view('authentication.registeration');
    }

    public function registration(Request $request) {
        $DBUser = new UserService;
        $faker = Factory::create();
        $username = strtolower($request->username . $faker->numerify('####'));
        $password = $request->password;
        $confrim = $request->confirm_password;
        if ($password !== $confrim) {
            return redirect('register')
            ->with('message', 'Konfirmasi password anda !');
        }
        $create = $DBUser->create([
            'name' => $request->name,
            'username' => $username,
            'password' => $request->password,
            'telp' => $request->telp,
            'nik' => $request->nik,
            'role' => $request->role,
            'status' => 1
        ]);

        if ($create['id']) {
            return redirect('login')->with('success', 'Berhasil membuat akun ' . $request->name . ' !, mohon catat username anda berikut ini ' . $username . ' !');
        }

        return redirect('register')->with('message', 'Gagal membuat akun ' . $request->name . ' !');
    }
}
