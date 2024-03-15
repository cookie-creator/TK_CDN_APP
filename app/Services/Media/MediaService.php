<?php

namespace App\Services\Media;

use App\Models\User;
use App\Adapter\APIAdapter\WebAPIMediaProvider;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaService
{
    public function __construct(public WebAPIMediaProvider $webAPIMediaProvider)
    {

    }

    public function getLocalMedias(User $user, $data)
    {
        return $user->getMedia("*");
    }

    public function getMedias($data, $path)
    {
        if (request()->has('search')) {
            return $this->webAPIMediaProvider->search($data['search']);
        }
        return $this->webAPIMediaProvider->getMediaList($path);
    }

    public function cropMedia($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();

            Storage::putFileAs('public/images', $image, $imageName);

            if ($image->getMimeType() == 'image/png') {
                $imageUploaded = imagecreatefrompng(storage_path('app/public/images/'.$imageName));
            } else {
                $imageUploaded = imagecreatefromjpeg(storage_path('app/public/images/'.$imageName));
            }
            $width = imagesx($imageUploaded);
            $height = imagesy($imageUploaded);

            $cropWidth = min($width, 512);
            $cropHeight = min($height, 512);

            $cropX = max(0, ($width - $cropWidth) / 2); // Ensure the crop area does not exceed the image boundaries
            $cropY = max(0, ($height - $cropHeight) / 2);

            $croppedImage = imagecrop($imageUploaded, ['x' => $cropX, 'y' => $cropY, 'width' => $cropWidth, 'height' => $cropHeight]);

            if ($image->getMimeType() == 'image/png') {
                imagepng($croppedImage, storage_path('app/public/images/' . $imageName));
            } else {
                imagejpeg($croppedImage, storage_path('app/public/images/' . $imageName));
            }

            imagedestroy($imageUploaded);
            imagedestroy($croppedImage);

            return $imageName;
        }

        return false;
    }

    public function storeMedia($request, $path='')
    {
        $imageName = $this->cropMedia($request);
        $contents = $this->getCroppedContent($imageName);

        $this->webAPIMediaProvider->uploadMedia($imageName, $contents, $path);
        $this->removeCroped($imageName);
    }

    public function removeCroped($imageName)
    {
        Storage::delete('public/images/' . $imageName);
    }

    public function deleteMedia($webAPIName, $path)
    {
        $this->webAPIMediaProvider->deleteMedia($webAPIName, $path);
    }

    private function getCroppedContent($imageName) {
        return file_get_contents(storage_path('app/public/images/' . $imageName));
    }
}
