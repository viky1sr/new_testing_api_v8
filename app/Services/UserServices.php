<?php

namespace App\Services;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserServices {
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }


    public function getAll(){
        return $this->userRepository->getAll();
    }

    public function getById($id) {
        return $this->userRepository->getById($id);
    }

    public function create(array $inputs){
        $inputs['password'] = \Hash::make($inputs['password']);
        $user = $this->userRepository->create($inputs);
        $user->assignRole('customer');
        return $user;
    }

    public function update(array $inputs, $id) {
        $user = $this->getById($id);
        $user['name'] = $inputs['name'];
        $user['email'] = $inputs['email'];

        return $user->save();
    }

    public function destroy($id) {
        return $this->userRepository->delete($id);
    }

}
