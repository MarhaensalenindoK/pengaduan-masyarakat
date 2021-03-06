<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN = 'ADMIN';
    const PETUGAS = 'PETUGAS';
    const MASYARAKAT = 'MASYARAKAT';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'username',
        'password',
        'telp',
        'role',
        'status',
        'created_at',
        'update_at',
    ];
}
