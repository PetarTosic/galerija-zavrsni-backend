<?php

namespace App\Service;

use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;


class GalleryService
{

    public function showGalleries(Request $request)
    {
        $name = $request->input('name');

        $query = Gallery::query();

        if ($name) {
            $query->searchByName($name);
        }

        $galleries = $query->with('user')->orderBy('created_at', 'DESC')->paginate(10);

        return $galleries;
    }


    public function postGallery(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255|string',
            'description' => 'max:1000',
            'urls' => 'required|array',
            'user_id' => 'required|exists:users,id',
        ]);

        $gallery = new Gallery();

        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->urls = json_encode($request->urls);
        $gallery->user_id = $request->user_id;

        $gallery->save();

        return $gallery;
    }

    public function showGallery($id)
    {
        $gallery = Gallery::with('user', 'comments')->find($id);
        return $gallery;
    }

    public function storeComm(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $comment = new Comment();
        $comment->description = $request->description;
        $comment->user_id = $request->user_id;
        $comment->gallery_id = $request->gallery_id;
        $comment->save();

        return $comment;
    }

    public function removeComm($id)
    {
        Comment::destroy($id);
    }

    public function editGallery(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:2|max:255|string',
            'description' => 'max:1000',
            'urls' => 'required',
        ]);

        $gallery = Gallery::find($id);

        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->urls = $request->urls;
        $gallery->save();

        return $gallery;
    }

    public function deleteGallery($id)
    {
        Gallery::destroy($id);
    }
}
