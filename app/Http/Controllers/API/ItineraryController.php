<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Http\Resources\ItineraryResource;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::all(); // Include user relationship

        $itinerariesResource = ItineraryResource::collection($itineraries);
        return response()->json($itinerariesResource, 200);
    }


    public function userItineraries()
    {
        $itineraries = Itinerary::where("user_id", Auth::id())->get(); // Include user relationship

        $itinerariesResource = ItineraryResource::collection($itineraries);
        return response()->json($itinerariesResource, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItineraryRequest $request)
    {
        $data = $request->validated();

        $data["user_id"] = Auth::id();

        $data["days_information"] = json_decode($data["days_information_string"]);
        $data["hotel_details"] = json_decode($data["hotel_details_string"]);
        $data["duration"] = json_decode($data["duration_string"]);
        $data["selected_destination"] = json_decode($data["selected_destination_string"]);
        $data["itinerary_theme"] = json_decode($data["itinerary_theme_string"]);

        $directory = public_path('itinerary_images');
        // Handle destination_thumbnail
        if ($request->hasFile("destination_thumbnail_file")){
            $thumbnail_file = $request->file("destination_thumbnail_file");
          
            $thumbnail_filename = time() . '_' . uniqid(). Str::random(8) . '.' . $thumbnail_file->getClientOriginalExtension();
            
            $thumbnail_file->move($directory, $thumbnail_filename);
            $data["destination_thumbnail"] = 'itinerary_images/' . $thumbnail_filename;
        }

        // Handle destination_images
        if ($request->hasFile("destination_images_files")){
            $image_files = $request->file("destination_images_files");
            $images_paths = [];

            foreach ($image_files as $image_file) {
                $image_filename = time() . '_' . uniqid() . Str::random(8) . '.' . $image_file->getClientOriginalExtension();
                $image_file->move($directory, $image_filename);
                $images_paths[] = 'itinerary_images/' . $image_filename; // adds the value to the next available index in the array.
            }

            $data["destination_images"] = $images_paths;
        }

        Arr::forget($data, [
            "days_information_string",
            "hotel_details_string",
            "duration_string",
            "selected_destination_string",
            "itinerary_theme_string",
            "destination_thumbnail_file",
            "destination_images_files"
        ]);

        $itinerary = Itinerary::create($data);

        return response()->json([
            'success' => 'Itinerary created successfully',
            'itinerary' => new ItineraryResource($itinerary),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $itinerary)
    {
        return response()->json(new ItineraryResource($itinerary), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItineraryRequest $request, Itinerary $itinerary)
    {
        $data = $request->validated();

        if(!empty($data["days_information_string"])){
            $data["days_information"] = json_decode($data["days_information_string"]);
        }

        if(!empty($data["hotel_details_string"])){
            $data["hotel_details"] = json_decode($data["hotel_details_string"]);
        }

        if(!empty($data["duration_string"])){
            $data["duration"] = json_decode($data["duration_string"]);
        }

        if(!empty($data["selected_destination_string"])){
            $data["selected_destination"] = json_decode($data["selected_destination_string"]);
        }

        if(!empty($data["itinerary_theme_string"])){
            $data["itinerary_theme"] = json_decode($data["itinerary_theme_string"]);
        }
        
       

        $directory = public_path('itinerary_images');
        // Handle destination_thumbnail update
        if ($request->hasFile("destination_thumbnail_file")){
            // Delete the old thumbnail if it exists
            if (!empty($itinerary->destination_thumbnail)) {
                $oldThumbnailPath = public_path($itinerary->destination_thumbnail);
                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            }

            $thumbnail_file = $request->file("destination_thumbnail_file");
            $thumbnail_filename = time() . '_' . uniqid() . Str::random(8) . '.' . $thumbnail_file->getClientOriginalExtension();
            $thumbnail_file->move($directory, $thumbnail_filename);
            $data["destination_thumbnail"] = 'itinerary_images/' . $thumbnail_filename;
        }

        // Handle destination_images update
        if ($request->hasFile("destination_images_files")) {
            // Delete old images if they exist
            if (!empty($itinerary->destination_images)) {
                $oldImages = $itinerary->destination_images;
                foreach ($oldImages as $oldImagePath) {
                    $fullPath = public_path($oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            $image_files = $request->file("destination_images_files");
            $images_paths = [];

            foreach ($image_files as $image_file) {
                $image_filename = time() . '_' . uniqid() . Str::random(8) . '.' . $image_file->getClientOriginalExtension();
                $image_file->move($directory, $image_filename);
                $images_paths[] = 'itinerary_images/' . $image_filename;
            }

            $data["destination_images"] = $images_paths;
        }

        Arr::forget($data, [
        "days_information_string",
        "hotel_details_string",
        "duration_string",
        "selected_destination_string",
        "itinerary_theme_string",
        "destination_thumbnail_file",
        "destination_images_files"
        ]);

        $itinerary->update($data);

        return response()->json([
            'success' => 'Itinerary updated successfully',
            'updatedItinerary' => new ItineraryResource($itinerary),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        // Delete thumbnail if it exists
        if (!empty($itinerary->destination_thumbnail)) {
            $thumbnailPath = public_path($itinerary->destination_thumbnail);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        // Delete images if they exist
        if (!empty($itinerary->destination_images)) {
            $images = $itinerary->destination_images;
            foreach ($images as $imagePath) {
                $fullPath = public_path($imagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        $itinerary->delete();

        return response()->json(['success' => 'Itinerary deleted successfully'], 200);
    }
}
