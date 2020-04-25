<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KelasModel;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;


class KelasController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="guru"){
            $jeniscuci=DB::table('kelas')
            ->where('kelas.id',$id)
            ->get();
            return response()->json($jeniscuci);
        }else{
            return response()->json(['status'=>'anda bukan guru']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="guru"){
        $validator=Validator::make($req->all(),
        [
            'nama_kelas'=>'required',
            'tanggal'=>'required',
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=KelasModel::create([
            'nama_kelas'=>$req->nama_kelas,
            'tanggal'=>$req->tanggal,
        ]);
        $status=1;
        $message="Data Kelas Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan guru']);
      }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="guru"){
        $validator=Validator::make($request->all(),
            [
                'nama_kelas'=>'required',
                'tanggal'=>'required',
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=KelasModel::where('id',$id)->update([
            'nama_kelas'=>$req->nama_kelas,
            'tanggal'=>$req->tanggal,
        ]);
        $status=1;
        $message="Data Kelas Berhasil Diubah";
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
        $hapus=KelasModel::where('id',$id)->delete();
        $status=1;
        $message="Data Kelas Berhasil Dihapus";
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
            $datas = DB::table('kelas')->get();
            $count = $datas->count();
            $kelas = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $kelas[] = array(
                    'id' => $dt_jc->id,
                    'nama_kelas' => $dt_jc->nama_kelas,
                    'tanggal' => $dt_jc->tanggal,
                );
            }
            return Response()->json(compact('count','kelas'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan guru']);
        }
    }
}
