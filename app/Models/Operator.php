<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_operator',
        'no_whatsapp',
        'email_sekolah',
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
