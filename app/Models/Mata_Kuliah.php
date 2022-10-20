<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mata_Kuliah extends Model
{
    use HasFactory;

    public $table = "mata_kuliahs";

    protected $fillable = [
        'nama_mata_kuliah', 'sks', 'semester'
    ];
    protected $primaryKey = 'id_mata_kuliah';
}
