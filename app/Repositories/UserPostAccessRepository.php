<?php

namespace App\Repositories;


use App\Models\UserPostAccess;
use App\Repositories\Interfaces\UserPostAccessRepositoryInterface;

class UserPostAccessRepository implements UserPostAccessRepositoryInterface
{
    public function create( array $data): UserPostAccess
    {
       return  UserPostAccess::create($data);
    }
}
