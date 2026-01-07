<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_id',
        'nama_sekolah',
        'npsn_sekolah',
        'jenjang_pendidikan',
        'jumlah_perangkat',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
