<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level'),
            'id_user'=>$request->get('id_user'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
    public function tampil()
    {
      $data=DB::table('siswa')->join('users','siswa.id','=','users.id_user')->get();
      $datas=$data->where('id', '<=','5');
      $aray=[];
      foreach ($datas as $k) {
        $aray[]=array(
          'id'=>$k->id,
          'nama'=>$k->nama,
          'telp'=>$k->telp
        );
      }
      $datas2=$data->where('id', '>=','5');
      $aray1=[];
      foreach ($datas2 as $k) {
        $aray1[]=array(
          'id'=>$k->id,
          'nama'=>$k->nama,
          'telp'=>$k->telp
        );
      }
      $datas3=$data->where('id','<=','3');
      $aray2=[];
      foreach ($datas3 as $k) {
        $aray2[]=array(
          'id'=>$k->id,
          'nama'=>$k->nama,
          'telp'=>$k->telp
        );
      }
      $datas4=$data->where('id','==','4');
      $aray3=[];
      foreach ($datas4 as $k) {
        $aray3[]=array(
          'id'=>$k->id,
          'nama'=>$k->nama,
          'telp'=>$k->telp
        );
      }
      $datas5=$data->where('id','<=','4');
      $aray4=[];
      foreach ($datas5 as $k) {
        $aray4[]=array(
          'id'=>$k->id,
          'nama'=>$k->nama,
          'telp'=>$k->telp
        );
      }
      return response()->json(['Senin'=>$aray, 'Selasa'=>$aray1,'Rabu'=>$aray2,'Kamis'=>$aray3,'Jumat'=>$aray4]);
    }
}
