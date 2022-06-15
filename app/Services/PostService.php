<?php

namespace App\Services;
 
use App\Models\Post;
use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;

class PostService implements PostServiceInterface {

    private $PostDao;

    public function __construct(PostDaoInterface $PostDao)
    {
        $this->PostDao = $PostDao;
    }

   
}
