<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alihmedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'pgsql';

    protected $table = 'alihmedia';
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    protected $keyType = 'string';
    public $incrementing = false;

    // public function Pengelola()
    // {
    //     return $this->hasOne(Alihmedia::class, 'id', 'user_id');
    // }

    // public function Validator()
    // {
    //     return $this->hasOne(Alihmedia::class, 'id', 'validator_id');
    // }
}
