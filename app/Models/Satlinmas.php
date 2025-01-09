<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satlinmas extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'anggota_satlinmas';
    protected $primaryKey = "id";
    protected $guarded = [];
}
