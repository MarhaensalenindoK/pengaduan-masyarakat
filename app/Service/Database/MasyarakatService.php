<?php

namespace App\Service\Database;

use App\Models\Masyarakat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class MasyarakatService {
    public function index($filter = [])
    {
        $orderBy = $filter['order_by'] ?? 'DESC';
        $per_page = $filter['per_page'] ?? 999;
        $page = $filter['page'] ?? 1;
        $name = $filter['name'] ?? null;
        $nik = $filter['nik'] ?? null;
        $status = $filter['status'] ?? null;
        $with_pengaduan = $filter['with_pengaduan'] ?? false;

        $query = Masyarakat::orderBy('created_at', $orderBy);

        if ($name !== null) {
            $query->where('name', $name);
        }

        if ($nik !== null) {
            $query->where('nik', $nik);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($with_pengaduan === true) {
            $query->with('pengaduan');
        }

        $masyarakat = $query->paginate($per_page, ['*'], 'page', $page);

        return $masyarakat->toArray();
    }

    public function detail($masyarakatId)
    {
        $masyarakat = Masyarakat::findOrFail($masyarakatId);

        return $masyarakat->toArray();
    }

    public function create($payload)
    {
        $masyarakat = new Masyarakat();
        $masyarakat->id = Uuid::uuid4()->toString();
        $masyarakat = $this->fill($masyarakat, $payload);
        $masyarakat->password = Hash::make($masyarakat->password);
        $masyarakat->save();

        return $masyarakat->toArray();
    }

    public function update($masyarakatId, $payload)
    {
        $masyarakat = Masyarakat::findOrFail($masyarakatId);
        $masyarakat = $this->fill($masyarakat, $payload);
        $masyarakat->password = Hash::make($masyarakat->password);
        $masyarakat->save();

        return $masyarakat->toArray();
    }

    public function destroy($masyarakatId)
    {
        Masyarakat::findOrFail($masyarakatId)->delete();

        return true;
    }

    private function fill(Masyarakat $masyarakat, array $attributes)
    {

        foreach ($attributes as $key => $value) {
            $masyarakat->$key = $value;
        }

        Validator::make($masyarakat->toArray(), [
            'name' => 'required|string',
            'nik' => 'required',
            'username' => 'required|string',
            'password' => 'required|string',
            'status' => 'required',
            'telp' => 'nullable',
        ])->validate();

        return $masyarakat;
    }
}
