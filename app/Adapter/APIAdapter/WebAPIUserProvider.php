<?php

namespace App\Adapter\APIAdapter;

class WebAPIUserProvider
{
    protected $api;

    public function __construct(WebAPI $api)
    {
        $this->api = $api;
    }
}
