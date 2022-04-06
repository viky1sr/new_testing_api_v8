<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminFee;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    private $productService;

    public function __construct(
        ProductServices $productService
    ){
        $this->productService = $productService;
    }

    public function getAll(){
        $result = $this->productService->getAll();
        return response()->json($result,200);
    }

    public function getById($id){
        $result = $this->productService->getById($id);
        return response()->json($result,200);
    }

    public function create(Request $request) {
        $validated =  productValidation($request->all());
        if($validated->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validated->errors()->first()
            ],422);
        } else {
            if($product = $this->productService->create($request->except('_token','submit'))) {
                return response()->json($product,201);
            }
        }
    }

    public function update(Request $request, $id) {
        $validated =  productValidation($request->all());
        if($validated->fails()){
            return response()->json([
                'status' => false,
                'messages' => $validated->errors()->first()
            ],422);
        } else {
            if($this->productService->update($request->except('_token','submit'), $id)) {
                $product = $this->productService->getById($id);
                return response()->json($product,201);
            }
        }
    }

    public function destroy($id) {
        return $this->productService->destroy($id);
    }
}
