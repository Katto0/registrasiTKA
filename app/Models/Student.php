<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'nisn',
        'fname',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'nama_orangtua',
        'nomor_orangtua',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
