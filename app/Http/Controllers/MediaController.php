<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteMediaRequest;
use App\Services\Media\FolderService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use App\Services\Media\MediaService;
use App\Http\Requests\StoreMediaRequest;

class MediaController extends Controller
{
    public function indexVue(MediaRequest $request, MediaService $mediaService, FolderService $folderService): View
    {
        $user = $request->user();

        $medias = $mediaService->getMedias($request->validated());

        return view('pages.media', [
            'user' => $user,
            'medias' => $medias
        ]);
    }

    public function index(MediaRequest $request, MediaService $mediaService, FolderService $folderService): View
    {
        $user = $request->user();

        $data = $request->validated();
        [$crumbs, $subFolder, $currentFolder, $currentFolderPath] = $folderService->getFolderPaths($data);
        $medias = $mediaService->getMedias($data, $currentFolder);

        return view('pages.media', [
            'user' => $user,
            'medias' => $medias,
            'crumbs' => $crumbs,
            'subFolder' => $subFolder,
            'currentFolder' => $currentFolder,
            'currentFolderPath' => $currentFolderPath,
        ]);
    }

    public function store(StoreMediaRequest $request, MediaService $mediaService, FolderService $folderService)
    {
        [$crumbs, $subFolder, $currentFolder, $currentFolderPath] = $folderService->getFolderPaths($request->validated());

        $mediaService->storeMedia($request, $currentFolder);

        return redirect()->back();
    }

    public function destroy(DeleteMediaRequest $request,MediaService $mediaService)
    {
        $data = $request->validated();

        $mediaService->deleteMedia($data['fileName'], $data['folder']);

        return redirect()->back();
    }
}
