<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'anggaran_profil_lembaga';
    protected $primaryKey = "id";
    protected $guarded = [];
}
