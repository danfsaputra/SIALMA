<?php

namespace App\Models;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $connection = 'mysql_data';

    protected $table = 'satpol_pelanggar';
    protected $primaryKey = "plg_id";
    protected $guarded = [];

    public $timestamps = false;

    public function refmodul()
    {
      return $this->belongsTo(Refmodul::class, 'plg_ref_modul', 'ref_id');
    }
}
