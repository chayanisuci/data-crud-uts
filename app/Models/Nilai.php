<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    public $table = "nilais";
    protected $fillable = ['nama','id_mata_kuliah','id_mahasiswa'];
    protected $primaryKey = 'id_nilai';
}
