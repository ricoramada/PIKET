<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class selesai extends Model
{
    protected $table='selesai';
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable = ['note','id_selesai'];
}
