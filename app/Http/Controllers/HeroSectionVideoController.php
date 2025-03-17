<?php

namespace App\Http\Controllers;

use App\Models\HeroSectionVideo;
use App\Http\Requests\StoreHeroSectionVideoRequest;
use App\Http\Resources\HeroSectionVideoResource;
use Illuminate\Http\Request;

class HeroSectionVideoController extends Controller
{
    // Get all hero section videos
    public function index()
    {
        $videos = HeroSectionVideo::all();
        return HeroSectionVideoResource::collection($videos);
    }

    // Get a single hero section video by ID
    public function show($id)
    {
        $video = HeroSectionVideo::findOrFail($id);
        return new HeroSectionVideoResource($video);
    }

    // Create a new hero section video
    public function store(StoreHeroSectionVideoRequest $request)
    {
        $video = HeroSectionVideo::create($request->validated());
        return new HeroSectionVideoResource($video);
    }

    // Update an existing hero section video
    public function update(StoreHeroSectionVideoRequest $request, $id)
    {
        $video = HeroSectionVideo::findOrFail($id);
        $video->update($request->validated());
        return new HeroSectionVideoResource($video);
    }

    // Delete a hero section video
    public function destroy($id)
    {
        $video = HeroSectionVideo::findOrFail($id);
        $video->delete();
        return response()->json(['message' => 'Hero section video deleted']);
    }
}
