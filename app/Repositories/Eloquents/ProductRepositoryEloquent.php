<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

Class ProductRepositoryEloquent implements  ProductRepositoryInterface{
    private $model;

    public function __construct(Product $model) {
        $this->model = $model;
    }

    /*
     * Get All data from Model Product
     * */
    public function getAll(){
        return $this->model->paginate(15);
    }

    /*
    * Get data by {$id} Product from Model Product
    * */
    public function getById($id){
        return $this->model->find($id);
    }

    /*
    * Create new data for Model Product
    * */
    public function create(array $inputs){
        return $this->model->create($inputs);
    }

    /*
    * Update data by {$id} from Model Product
    * */
    public function update(array $inputs, $id){
        $Product = $this->model->find($id);
        $Product->update($inputs);

        return $Product;
    }

    /*
    * Delete data by {$id} from Model Product
    * */
    public function delete($id){
        return $this->model->destroy($id);
    }
}
