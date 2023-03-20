<?php


namespace App\Http\Controllers;

use App\Models\Picture;
use App\Requests\UploadImagesRequest;

class PictureController extends Controller
{
    public function upload(UploadImagesRequest $request)
    {
       if ($request->file() !== null) {
            $picture = new Picture();

            $picture->path = '/' . $request->file('files')->store('/images', ['disk' => 'file_uploads']);

            $picture->save();
        }
        return $picture->id;
    }

    public function delete($pictureId)
    {
        Picture::findOrFail($pictureId)->delete();
    }
}
