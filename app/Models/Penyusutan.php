<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyusutan extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'ref_penyusutan_akhirs';
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
