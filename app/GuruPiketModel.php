<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuruPiketModel extends Model
{
    protected $table="guru_piket";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id','nama_guru', 'alamat','telp'
    ];

}
