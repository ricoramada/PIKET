<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiswaModel;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class SiswaController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->role=="guru"){
            $siswa=DB::table('siswa')
            ->where('siswa.id',$id)
            ->get();
            return response()->json($siswa);
        }else{
            return response()->json(['status'=>'anda bukan guru']);
        }
    }
    public function store(Request $req)
    {
        // if(Auth::user()->level=="guru"){
        $validator=Validator::make($req->all(),
        [
            'nama'=>'required',
            'nisn'=>'required',
            'alamat'=>'required',
            'telp'=>'required'
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
        $simpan=SiswaModel::create([
            'id'=>$string,
            'nama'=>$req->nama,
            'nisn'=>$req->nisn,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp
        ]);
        $status=1;
        $code=$string;
        $message="Data Siswa Berhasil Ditambahkan";
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
                'nama'=>'required',
                'nisn'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=SiswaModel::where('id',$id)->update([
            'nama'=>$req->nama,
            'nisn'=>$req->nisn,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        $status=1;
        $message="Data Siswa Berhasil Diubah";
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
        $hapus=SiswaModel::where('id',$id)->delete();
        $status=1;
        $message="Data Siswa Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan admin']);
        }
    }

    public function tampil(){
        if(Auth::user()->level=="guru"){
            $datas = SiswaModel::get();
            $count = $datas->count();
            $siswa = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $siswa[] = array(
                    'id' => $dt_jc->id,
                    'nama' => $dt_jc->nama,
                    'nisn' => $dt_jc->nisn,
                    'alamat' => $dt_jc->alamat,
                    'telp' => $dt_jc->telp,
                );
            }
            return Response()->json(compact('count','siswa'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan guru']);
        }
    }
}
