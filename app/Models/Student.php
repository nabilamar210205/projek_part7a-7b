<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'nim',
        'nama',
        'prodi',
        'tanggal_lahir',
        'email',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}
