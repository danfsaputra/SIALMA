<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'klasifikasi_arsips';
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
