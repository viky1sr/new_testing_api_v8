<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class AuthApiController extends Controller
{
    public function logout( Request $request ) {
        $token = $request->header( 'Authorization' );
        try {
            JWTAuth::parseToken()->invalidate( $token );

            return response()->json( [
                'status'   => false,
                'message' => trans( 'auth.logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.missing' )
            ], 500 );
        }
    }

    public function login(Request $request)
    {
        $credential = $request->only('email','password');
        try {
            if (!$access_token = JWTAuth::attempt($credential)) {
                return response()->json([
                    'status' => false,
                    'messages' => 'Password dan email tidak sama.',
                ],422);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'false',
                'messages' => 'could_not_create_token'
            ], 500);
        }

        if($access_token) {
            $user = \Auth::user();
            $role = \DB::table('model_has_roles')->where('model_id',$user->id)
                ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
                ->select('name')
                ->first();
            $exp = JWTAuth::setToken($access_token)->getPayload()->get('exp');
        }

        return response()->json(compact('access_token','exp','user','role'),200);
    }
}
