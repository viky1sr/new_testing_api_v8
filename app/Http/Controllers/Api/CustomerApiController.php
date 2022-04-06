<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserServices;
use Illuminate\Http\Request;
use JWTAuth;

class CustomerApiController extends Controller
{
    private $userService;

    public function __construct(
        UserServices $userService
    ){
        $this->userService = $userService;
    }

    public function getAll(){
        $res = $this->userService->getAll();
        return response()->json($res,200);
    }

    public function getById($id){
        $res = $this->userService->getById($id);
        return response()->json($res,200);
    }

    public function register(Request $request){
        $validated = userValidation($request->all());
        if($validated->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validated->errors()->first()
            ],422);
        } else {
            if($user = $this->userService->create($request->except('_token','submit'))) {
                $token = JWTAuth::fromUser($user);
                return response()->json(compact('user','token'),201);
            }
        }
    }

    public function update(Request $request, $id) {
        $validated = userValidation($request->all());
        if($validated->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validated->errors()->first()
            ],422);
        } else {
            if($this->userService->update($request->except('_token','submit'), $id )) {
                $user = $this->userService->getById($id);
                $token = JWTAuth::fromUser($user);
                return response()->json(compact('user','token'),201);
            }
        }
    }

    public function destroy($id){
        $user = $this->userService->destroy($id);
        return response()->json([
            'status' => true,
            'messages' => 'Success delete user'
        ],201);
    }
}
