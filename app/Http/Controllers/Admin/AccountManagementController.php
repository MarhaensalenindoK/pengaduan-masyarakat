<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Database\UserService;
use Faker\Factory;
use Illuminate\Http\Request;

class AccountManagementController extends Controller
{
    public function index()
    {
        return view('admin.account_management');
    }

    public function getUser()
    {
        $DBuser = new UserService;

        $users = $DBuser->index();

        return response()->json($users);
    }

    public function createAccount(Request $request)
    {
        $DBUser = new UserService;
        $faker = Factory::create();
        $username = strtolower($request->username . $faker->numerify('####'));
        $create = $DBUser->create([
            'name' => $request->name,
            'telp' => $request->telp,
            'username' => $username,
            'password' => $username,
            'role' => $request->role,
            'status' => 1
        ]);

        return response()->json($create);
    }

    public function updateAccount(Request $request)
    {
        $DBuser = new UserService;

        $payload = [
            'name' => $request->name,
            'telp' => $request->telp,
            'username' => $request->username,
            'role' => $request->role,
            'status' => $request->status === 'true' ? true : false,
        ];

        $update = $DBuser->update($request->user_id, $payload);

        return response()->json($update);
    }

    public function resetPassword(Request $request)
    {
        $DBuser = new UserService;
        $user = $DBuser->detail($request->user_id);

        $payload = [
            'password' => $user['username'],
        ];

        $update = $DBuser->update($request->user_id, $payload);

        return response()->json($update);
    }

    public function deleteAccount(Request $request)
    {
        $DBuser = new UserService;

        $delete = $DBuser->destroy($request->user_id);

        return response()->json($delete);
    }
}
