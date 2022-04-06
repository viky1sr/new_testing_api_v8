<?php

namespace App\Repositories;

use App\Repositories\Eloquents\UserRepositoryEloquent;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Cache\CacheManager;

class UserCacheRepository implements UserRepositoryInterface {
    protected $repo;
    protected $cache;

    const TTL = 1; #1day

    public function __construct(
        CacheManager $cache, UserRepositoryEloquent $repo
    ){
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * @return UserRepositoryEloquent
     */
    public function getAll()
    {
        return $this->cache->remember('customers', self::TTL, function () {
            return $this->repo->getAll();
        });
    }

    public function getById($id)
    {
        return $this->repo->getById($id);
    }

    public function create(array $inputs)
    {
        return $this->cache->remember('register', self::TTL, function () use ($inputs) {
            return $this->repo->create($inputs);
        });
    }

    public function update(array $inputs, $id)
    {
        return $this->cache->remember('register.'.$id, self::TTL, function () use ($inputs,$id) {
            $user = $this->repo->find($id);
            $user->update($inputs);
            return $user;
        });

    }

    public function delete($id)
    {
        return $this->cache->remember('customers.'.$id, self::TTL, function () use ($id) {
            return $this->repo->delete($id);
        });
    }
}
