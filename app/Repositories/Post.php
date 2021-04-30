<?php

namespace App\Repositories;

use App\Models\Post as Model;
use Laravel5Helpers\Repositories\Search;

class Post extends Search
{

    protected function getModel()
    {
        return new Model;
    }

    public function getByPageSize($size)
    {
        return $this->getModel()->orderBy('created_at', 'DESC')->paginate($size);
    }

    public function search($query)
    {
        return $this->getModel()->where('title', 'like', '%' . $query . '%')->orWhere('body', 'like', '%' . $query . '%')->paginate(2);
    }

    public function getById($id)
    {
        return $this->getModel()->where('id', $id)->first();
    }
}
