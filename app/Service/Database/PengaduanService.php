<?php

namespace App\Service\Database;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;

class PengaduanService {

    public function index($filter = [])
    {
        $orderBy = $filter['order_by'] ?? 'DESC';
        $per_page = $filter['per_page'] ?? 999;
        $page = $filter['page'] ?? 1;
        $status = $filter['status'] ?? null;
        $nik = $filter['nik'] ?? null;

        $query = Pengaduan::orderBy('created_at', $orderBy);

        if ($status !== null) {
            $status = strtolower($status);
            $query->where('status', $status);
        }

        if ($nik !== null) {
            $query->where('nik', $nik);
        }

        $query->with('masyarakat');

        $pengaduan = $query->paginate($per_page, ['*'], 'page', $page);

        return $pengaduan->toArray();
    }

    public function detail($pengaduanId)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduanId);

        return $pengaduan->toArray();
    }

    public function create($payload)
    {
        $pengaduan = new Pengaduan();
        $pengaduan->id = Uuid::uuid4()->toString();
        $pengaduan = $this->fill($pengaduan, $payload);
        $pengaduan->save();

        return $pengaduan->toArray();
    }

    public function update($pengaduanId, $payload)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduanId);
        $pengaduan = $this->fill($pengaduan, $payload);
        $pengaduan->save();

        return $pengaduan->toArray();
    }

    public function destroy($pengaduanId)
    {
        Pengaduan::findOrFail($pengaduanId)->delete();

        return true;
    }

    private function fill(Pengaduan $pengaduan, array $attributes)
    {

        foreach ($attributes as $key => $value) {
            $pengaduan->$key = $value;
        }

        Validator::make($pengaduan->toArray(), [
            'nik' => 'required',
            'content' => 'required',
            'photo' => 'nullable',
            'status' => ['required', Rule::in(config('constant.pengaduan.status'))],
        ])->validate();

        return $pengaduan;
    }
}
