<?php

namespace App\Services;
 
use App\Contracts\Dao\AuthDaoInterface;
use App\Contracts\Services\AuthServiceInterface;

class AuthService implements AuthServiceInterface {

    private $AuthDao;

    public function __construct(AuthDaoInterface $AuthDao)
    {
        $this->authDao = $AuthDao;
    }

}


