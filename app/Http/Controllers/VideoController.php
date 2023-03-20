<?php


namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Video;
use App\Requests\CreateVideoRequest;
use App\Requests\UpdateVideoRequest;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    public function index(Request $request)
    {
        $videos = Video::with('tags')->with('pictures');

        if ($request->searchQuery) {

            $videos->selectRaw("*, MATCH(title,description) AGAINST ('". $request->searchQuery . "' IN BOOLEAN MODE) AS relevance")
                ->whereRaw("MATCH(title,description) AGAINST ('*". $request->searchQuery . "*' IN BOOLEAN MODE)")
                ->orderBy('relevance');
        }

        return $videos->paginate($request->per_page ?? 10);
    }

    public function getById($videoId)
    {
       return Video::with('tags')->with('pictures')->find($videoId);
    }

    public function store(CreateVideoRequest $request)
    {
        $video = new Video();

        $video->title = $request->title;
        $video->description = $request->description;
        $video->content = $request->embedded_content;

        $video->save();

        $this->setTags($request, $video);
        $this->setPictures($request, $video);

    }

    public function update(UpdateVideoRequest $request, int $videoId)
    {
        $video = Video::findOrFail($videoId);

        $video->title = $request->title;
        $video->description = $request->description;
        $video->content = $request->embedded_content;

        $this->setTags($request, $video);
        $this->setPictures($request, $video);

        $video->save();
    }

    public function delete(int $videoId)
    {
        Video::findOrFail($videoId)->delete();
    }

    public function setTags(UpdateVideoRequest | CreateVideoRequest $request, Video $video)
    {
        if($request->tags !== null) {
            foreach ($request->tags as $tag) {
                if (!in_array($tag, $video->tags()->get()->pluck('id')->toArray())) {
                    $video->tags()->attach($tag);
                }
            }
        }
        if($video->tags()->exists()) {
            foreach ($video->tags()->get() as $tag) {
                if ($request->tags === null || !in_array($tag->id, $request->tags)) {
                    $video->tags()->detach($tag->id);
                }
            }
        }
    }

    public function setPictures(Request $request, Video $video)
    {
        if ($request->images !== null) {
            foreach ($request->images as $image) {
                Picture::find($image)->update(['video_id' => $video->id]);
            }
        }
    }

    public function recentlyUploaded(Request $request)
    {
        return Video::with('pictures')->orderBy('created_at', 'desc')
            ->take($request->per_page)->get();
    }
}
