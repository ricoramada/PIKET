<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    protected $table = "siswa";
     protected $primaryKey="id";
    public $timestamps=false;
    protected $fillable = ['id','nama', 'nisn', 'alamat','telp'];


}
