<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeritaAcara extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'berita_acara';
    protected $primaryKey = "id";
    protected $guarded = ['id'];
}
