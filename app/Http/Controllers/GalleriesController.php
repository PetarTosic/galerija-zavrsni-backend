<?php

namespace App\Http\Controllers;

use App\Service\GalleryService;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{

    public GalleryService $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $galleries = $this->galleryService->showGalleries($request);

        return $galleries;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gallery = $this->galleryService->postGallery($request);

        return $gallery;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = $this->galleryService->showGallery($id);

        return $gallery;
    }

    public function postComment(Request $request)
    {
        $gallery = $this->galleryService->storeComm($request);

        return $gallery;
    }

    public function destroyComment($id)
    {
        $gallery = $this->galleryService->removeComm($id);

        return $gallery;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = $this->galleryService->editGallery($request, $id);

        return $gallery;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = $this->galleryService->deleteGallery($id);

        return $gallery;
    }
}
