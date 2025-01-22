<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Validasidata extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'alihmedia';
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    protected $keyType = 'int';
    public $incrementing = true;
}
