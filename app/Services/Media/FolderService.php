<?php

namespace App\Services\Media;

class FolderService
{
    public function __construct()
    {

    }

    public function getCurrentFolderPath($request)
    {

    }

    public function getFolderPaths($data)
    {
        $crumbs = '';
        $subFolder = '';
        $currentFolder = '';
        $currentFolderPath = '';

        if (isset($data['folder']) && strlen($data['folder']) > 0) {
            $crumbs = $data['folder'];
            $array = explode('/', $data['folder']);
            if (count($array) > 1) {
                $arrayPop = array_pop($array);
                $arrayPop = $array;
                if (!is_string($arrayPop)) {
                    $subFolder = implode('/', $arrayPop);
                } else {
                    $subFolder = $array;
                }
            }
            $currentFolder = $data['folder'];
            $currentFolderPath = $data['folder'] . '/';
        }

        return [$crumbs, $subFolder, $currentFolder, $currentFolderPath];
    }

    public function getRootFolder()
    {
        return 'test';
    }
}
