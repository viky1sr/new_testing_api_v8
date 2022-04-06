<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductServices {
    private $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function getAll(){
        return $this->productRepository->getAll();
    }

    public function getById($id) {
        return $this->productRepository->getById($id);
    }

    public function create(array $inputs) {
        return $this->productRepository->create($inputs);
    }

    public function update(array $inputs,$id) {
        $product = $this->getById($id);
        $product['title'] = $inputs['title'];
        $product['category'] = $inputs['category'];
        $product['deposit'] = $inputs['deposit'];
        $product['price'] = $inputs['price'];

        return $product->save();
    }

    public function destroy($id){
        return $this->productRepository->delete($id);
    }
}
