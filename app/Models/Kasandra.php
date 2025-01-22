<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasandra extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'kasandra';
    protected $primaryKey = "id";
    protected $guarded = [];
}
