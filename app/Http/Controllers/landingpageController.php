<?php

namespace App\Http\Controllers;

use App\Service\Database\ClinicService;
use App\Service\Database\PengaduanService;
use Illuminate\Http\Request;

class landingpageController extends Controller
{
    public function index()
    {
        $DBpengaduan = new PengaduanService;

        $dataPengaduan = $DBpengaduan->index();

        return view('landingpage')
        ->with('dataPengaduan', $dataPengaduan);
    }
}
