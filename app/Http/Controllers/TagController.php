<?php


namespace App\Http\Controllers;

use App\Models\Tag;
use App\Requests\CreateTagRequest;
use App\Requests\UpdateTagRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index()
    {
        return Tag::with('videos')->orderBy('id')->get();
    }

    public function getById(int $tagId)
    {
        return Tag::find($tagId);
    }

    public function store(CreateTagRequest $request)
    {
        Tag::create(['name' => $request->name]);
    }

    public function update(UpdateTagRequest $request, int $tagId)
    {
        $tag = Tag::findOrFail($tagId);

        $tag->name = $request->name;
        $tag->save();

    }

    public function filter(Request $request, int $tagId)
    {
        return Tag::find($tagId)->videos()->with('pictures')->paginate($request->per_page ?? 10);
    }

    public function delete($tagId)
    {
        Tag::findOrFail($tagId)->delete();
    }

}
