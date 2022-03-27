<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nik',
        'content',
        'photo',
        'status',
        'created_at',
        'update_at',
    ];
}
