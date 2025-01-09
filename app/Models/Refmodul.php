<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refmodul extends Model
{
    use HasFactory;

    protected $connection = 'mysql_data';

    protected $table = 'ref_modul';
    protected $primaryKey = "ref_id";
    protected $guarded = [];

    public $timestamps = false;
}
