<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'nik',
        'username',
        'password',
        'telp',
        'status',
        'created_at',
        'update_at',
    ];

    public function pengaduan() {
        return $this->hasMany(Pengaduan::class, 'nik', 'nik');
    }
}
