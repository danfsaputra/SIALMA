<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keamanan extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'ref_klas_keamanans';
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
