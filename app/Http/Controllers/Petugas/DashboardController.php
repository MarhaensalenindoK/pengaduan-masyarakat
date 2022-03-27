<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Service\Database\PengaduanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('petugas.dashboard')
        ->with('totalTodo', $totalTodo)
        ->with('totalInprogress', $totalInprogress)
        ->with('totalDone', $totalDone)
        ->with('pw_matches', $pw_matches);
    }
}
