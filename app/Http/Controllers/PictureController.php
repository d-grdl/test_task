<?php


namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function upload(Request $request)
    {
        dd($request->file());
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
