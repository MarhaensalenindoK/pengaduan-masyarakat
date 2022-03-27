<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Database\MasyarakatService;
use Faker\Factory;
use Illuminate\Http\Request;

class MasyarakatManagementController extends Controller
{
    public function index()
    {
        return view('admin.masyarakat_management');
    }

    public function getMasyarakat()
    {
        $DBmasyarakat = new MasyarakatService;

        $masyarakat = $DBmasyarakat->index();

        return response()->json($masyarakat);
    }

    public function createMasyarakat(Request $request)
    {
        $DBmasyarakat = new MasyarakatService;
        $faker = Factory::create();
        $username = strtolower($request->username . $faker->numerify('####'));
        $create = $DBmasyarakat->create([
            'name' => $request->name,
            'nik' => $request->nik,
            'username' => $username,
            'password' => $username,
            'telp' => $request->telp,
            'status' => 1
        ]);

        return response()->json($create);
    }

    public function updateMasyarakat(Request $request)
    {
        $DBmasyarakat = new MasyarakatService;

        $payload = [
            'name' => $request->name,
            'username' => $request->username,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'status' => $request->status === 'true' ? true : false,
        ];

        $update = $DBmasyarakat->update($request->user_id, $payload);

        return response()->json($update);
    }

    public function deleteMasyarakat(Request $request)
    {
        $DBmasyarakat = new MasyarakatService;

        $delete = $DBmasyarakat->destroy($request->user_id);

        return response()->json($delete);
    }

    public function resetPassword(Request $request)
    {
        $DBmasyarakat = new MasyarakatService;
        $user = $DBmasyarakat->detail($request->user_id);

        $payload = [
            'password' => $user['username'],
        ];

        $update = $DBmasyarakat->update($request->user_id, $payload);

        return response()->json($update);
    }
}
