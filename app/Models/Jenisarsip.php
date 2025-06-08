<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenisarsip extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'jenis_arsips';
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
