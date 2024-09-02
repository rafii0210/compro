<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_profile',
        'judul',
        'subjudul',
        'descriptions',
        'tanggal_awal',
        'tanggal_awal'
    ];
    protected $table = 'eksperiences';
}
