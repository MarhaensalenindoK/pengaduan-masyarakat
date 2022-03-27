<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Service\Database\MasyarakatService;
use App\Service\Database\PengaduanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('masyarakat.dashboard');
    }

    public function createPengaduan(Request $request)
    {
        $DBpengaduan = new PengaduanService;
        $DBmasyarakat = new MasyarakatService;

        $masyarakat = $DBmasyarakat->index(['nik' => $request->nik, 'with_pengaduan' => true])['data'];

        if (count($masyarakat) === 0) {
            $masyarakat = $DBmasyarakat->create([
                'name'=> $request->name,
                'nik'=> $request->nik,
                'username'=> $request->username,
                'password'=> $request->password,
                'telp'=> $request->telp,
            ]);
        }

        $payloadPengaduan = [
            'nik' => $request->nik,
            'content' => $request->content,
            'status' => 'todo',
        ];

        if ($request->file('image') !== null) {
            $uploadImage = Storage::disk('public')->put('photo_laporan', $request->file('image'));

            $payloadPengaduan['photo'] = $uploadImage;
        }

        $pengaduan = $DBpengaduan->create($payloadPengaduan);

        if ($pengaduan['id']) {
            $dataPengaduan = $DBmasyarakat->index([
                'nik' => $request->nik,
                'with_pengaduan' => true,
            ])['data'][0];

            return redirect('masyarakat/dashboard')
            ->with('message', 'Berhasil mengirim laporan!')
            ->with('dataPengaduan', $dataPengaduan);
        }

        return redirect('masyarakat/dashboard')
        ->with('message', 'Gagal mengirim laporan!');
    }
}
