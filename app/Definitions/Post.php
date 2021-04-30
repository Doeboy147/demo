<?php

namespace App\Definitions;

use Laravel5Helpers\Definitions\Definition;

class Post extends Definition
{

    public $user_id;

    public $title;

    public $body;

    public $image;


    public function __construct($data)
    {
        parent::__construct($data);
    }

    protected function setValidators()
    {
        return $this->validators = [
            'title' => 'bail| required',
            'body' => 'bail| required',
            'image' => 'bail| required',
        ];
    }
}
