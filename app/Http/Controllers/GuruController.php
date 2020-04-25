<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GuruPiketModel;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="guru"){
            $jeniscuci=DB::table('guru_piket')
            ->where('guru_piket.id',$id)
            ->get();
            return response()->json($jeniscuci);
        }else{
            return response()->json(['status'=>'anda bukan guru']);
        }
    }
    public function store(Request $req)
    {
        // if(Auth::user()->level=="guru"){
        $validator=Validator::make($req->all(),
        [
            'nama_guru'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $string = str_random(4);
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1, 9)
        . mt_rand(1, 9)
        . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        $simpan=GuruPiketModel::create([
            'id'=>$string,
            'nama_guru'=>$req->nama_guru,
            'telp'=>$req->telp,
            'alamat'=>$req->alamat,
        ]);
        $status=1;
        $code=$string;
        $message="Data Guru Piket Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message','code'));
        }else {
          return Response()->json(['status'=>0]);
        }
      // }
      // else {
      //     return response()->json(['status'=>'anda bukan guru']);
      // }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="guru"){
        $validator=Validator::make($request->all(),
            [
                'nama_guru'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
                'id_users'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=GuruPiketModel::where('id',$id)->update([
            'nama_guru'=>$req->nama_guru,
            'telp'=>$req->telp,
            'alamat'=>$req->alamat,
            'id_users'=>$req->id_users
        ]);
        $status=1;
        $message="Data Guru Piket Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan guru']);
    }
}
    public function destroy($id){
        if(Auth::user()->level=="guru"){
        $hapus=GuruPiketModel::where('id',$id)->delete();
        $status=1;
        $message="Data Guru Piket Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan guru']);
        }
    }

    public function tampil(){
        if(Auth::user()->level=="guru"){
            $datas = GuruPiketModel::get();
            $count = $datas->count();
            $guru = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $guru[] = array(
                    'id' => $dt_jc->id,
                    'nama_guru' => $dt_jc->nama_guru,
                    'alamat' => $dt_jc->alamat,
                    'telp'=>$dt_jc->telp
                );
            }
            return Response()->json(compact('count','guru'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan guru']);
        }
    }
}
