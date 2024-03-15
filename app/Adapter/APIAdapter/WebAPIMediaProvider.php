<?php

namespace App\Adapter\APIAdapter;

use Illuminate\Support\Collection;

class WebAPIMediaProvider
{
    public function __construct(public WebAPI $webAPI)
    {

    }

    /**
     * @return false|Collection
     */
    public function getMediaList($path)
    {
        $medias = $this->webAPI->list($path)['list']['list'];
        if (is_array($medias)) {
            return collect($medias);
        }
        return false;
    }

    public function search($fileName)
    {
        $medias = $this->webAPI->search($fileName)['list'];
        if (is_array($medias)) {
            return collect($medias);
        }
        return false;
    }

    public function uploadMedia($fileName, $content, $path='')
    {
        return $this->webAPI->upload($fileName, $content, $path)['status'];
    }

    public function deleteMedia($fileName, $path = 'test')
    {
        return $this->webAPI->delete($fileName, $path);
    }
}
