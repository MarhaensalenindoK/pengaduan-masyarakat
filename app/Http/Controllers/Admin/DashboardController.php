<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Database\PengaduanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $DBpengaduan = new PengaduanService;

        $dataPengaduan = collect($DBpengaduan->index()['data']);
        $totalTodo = $dataPengaduan->sum(function ($pengaduan) {
            return $pengaduan['status'] === 'todo';
        });

        $totalInprogress = $dataPengaduan->sum(function ($pengaduan) {
            return $pengaduan['status'] === 'inprogress';
        });

        $totalDone = $dataPengaduan->sum(function ($pengaduan) {
            return $pengaduan['status'] === 'done';
        });

        $pw_matches = false;
        if (Hash::check(Auth::user()->username, Auth::user()->password)){
            $pw_matches = true;
        }

        return view('admin.dashboard')
        ->with('totalTodo', $totalTodo)
        ->with('totalInprogress', $totalInprogress)
        ->with('totalDone', $totalDone)
        ->with('pw_matches', $pw_matches);
    }

    public function getPengaduan()
    {
        $DBpengaduan = new PengaduanService;

        $dataPengaduan = $DBpengaduan->index();

        $collectPengaduan = collect($dataPengaduan['data']);
        $totalTodo = $collectPengaduan->sum(function ($pengaduan) {
            return $pengaduan['status'] === 'todo';
        });

        $totalInprogress = $collectPengaduan->sum(function ($pengaduan) {
            return $pengaduan['status'] === 'inprogress';
        });

        $totalDone = $collectPengaduan->sum(function ($pengaduan) {
            return $pengaduan['status'] === 'done';
        });

        $dataPengaduan['totalTodo'] = $totalTodo;
        $dataPengaduan['totalInprogress'] = $totalInprogress;
        $dataPengaduan['totalDone'] = $totalDone;

        return response()->json($dataPengaduan);
    }

    public function updatePengaduan(Request $request)
    {
        $DBpengaduan = new PengaduanService;

        $payload = [
            'status' => $request->status,
        ];

        $update = $DBpengaduan->update($request->pengaduan_id, $payload);

        return response()->json($update);
    }

    public function adminManagement()
    {
        return view('admin.account_admin_management');
    }
}
