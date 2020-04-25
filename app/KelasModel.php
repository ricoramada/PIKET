<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    protected $table = "guru_piket";
    protected $primaryKey="id";
    public $timestamps=false;

    protected $fillable = ['nama_guru','alamat','telp'];

}
