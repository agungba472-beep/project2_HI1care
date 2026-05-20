<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faskes extends Model
{
    use HasFactory;

    protected $table = 'faskes';

    protected $fillable = [
        'nama',
        'alamat',
        'kontak',
        'tipe',
        'layanan',
    ];
}
