<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'kasus';
    protected $primaryKey = "id";
    protected $guarded = [];
}
