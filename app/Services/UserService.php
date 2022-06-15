<?php

namespace App\Services;
 
use App\Models\User;
use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\UserServiceInterface;

class UserService implements UserServiceInterface {

    private $userDao;

    public function __construct(UserDaoInterface $UserDao)
    {
        $this->userDao = $UserDao;
    }

}
