<?php

namespace App\Repositories;

use App\Repositories\Eloquents\ProductRepositoryEloquent;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Cache\CacheManager;

class ProductCacheRepository implements ProductRepositoryInterface {
    protected $repo;
    protected $cache;

    const TTL = 1; #1 minutes

    public function __construct(
        CacheManager $cache, ProductRepositoryEloquent $repo
    ){
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * @return ProductRepositoryEloquent
     */
    public function getAll()
    {
        return $this->cache->remember('products', self::TTL, function () {
            return $this->repo->getAll();
        });
    }

    public function getById($id)
    {
        return $this->cache->remember('products.'.$id, self::TTL, function () use ($id) {
            return $this->repo->getById($id);
        });
    }

    public function create(array $inputs)
    {
        return $this->cache->remember('products', self::TTL, function () use ($inputs) {
            return $this->repo->create($inputs);
        });
    }

    public function update(array $inputs, $id)
    {
        return $this->cache->remember('products.'.$id, self::TTL, function () use ($inputs,$id) {
            $user = $this->repo->find($id);
            $user->update($inputs);

            return $user;
        });
    }

    public function delete($id)
    {
        return $this->cache->remember('products.'.$id, self::TTL, function () use ($id) {
            return $this->repo->delete($id);
        });
    }
}
