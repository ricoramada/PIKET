<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\selesai;

class controlselesai extends Controller
{
  public function selesai(Request $req)
  {
    $save=selesai::create([
      'note'=>$req->note,
      'id_selesai'=>$req->id_selesai
    ]);
    return response()->json(['Selesai'=>$save]);
  }
  public function tampil(Request $req)
  {
    $data=DB::table('siswa')->join('users','siswa.id','=','users.id_user')
    ->join('selesai','users.id','=','selesai.id_selesai')
    ->where('selesai.tanggal',$req->tanggal)
    ->get();
    $datas=[];
    foreach ($data as $k) {
      $datas[]=array(
        'nama'=>$k->nama,
        'note'=>$k->note,
        'Tanggal'=>$k->tanggal
      );
    }
    return response()->json(['Telah Menyelesaikan'=>$datas]);
  }
}
