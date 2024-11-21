<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::with('user')->get(); // Include user relationship
        return response()->json($itineraries, 200);
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
        if ($request->hasFile("destination_thumbnail_file")) {
            $thumbnail_file = $request->file("destination_thumbnail_file");
          
            $thumbnail_filename = time() . '_' . uniqid() . '.' . $thumbnail_file->getClientOriginalExtension();
            $thumbnail_file->move($directory, $thumbnail_filename);
            $data["detination_thumbnail"] = 'itinerary_images/' . $thumbnail_filename;
        }

        // Handle detination_images
        if ($request->hasFile("destination_images_files")) {
            $image_files = $request->file("destination_images_files");
            $images_paths = [];

            foreach ($image_files as $image_file) {
                $image_filename = time() . '_' . uniqid() . '.' . $image_file->getClientOriginalExtension();
                $image_file->move($directory, $image_filename);
                $images_paths[] = 'itinerary_images/' . $image_filename; // adds the value to the next available index in the array.
            }

            $data["detination_images"] = json_encode($images_paths);
        }


        Arr::forget($data, "days_information_string");
        Arr::forget($data, "hotel_details_string");
        Arr::forget($data, "duration_string");
        Arr::forget($data, "selected_destination_string");
        Arr::forget($data, "itinerary_theme_string");

        Arr::forget($data, "destination_thumbnail_file");
        Arr::forget($data, "destination_images_files");

        $itinerary = Itinerary::create($data);

        return response()->json([
            'success' => 'Itinerary created successfully',
            'itinerary' => $itinerary,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $id)
    {
        return response()->json($id, 200);
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
            if (!empty($itinerary->detination_thumbnail)) {
                $oldThumbnailPath = public_path($itinerary->detination_thumbnail);
                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            }

            $thumbnail_file = $request->file("destination_thumbnail_file");
            $thumbnail_filename = time() . '_' . uniqid() . '.' . $thumbnail_file->getClientOriginalExtension();
            $thumbnail_file->move($directory, $thumbnail_filename);
            $data["detination_thumbnail"] = 'itinerary_images/' . $thumbnail_filename;
        }

        // Handle detination_images update
        if ($request->hasFile("destination_images_files")) {
            // Delete old images if they exist
            if (!empty($itinerary->detination_images)) {
                $oldImages = json_decode($itinerary->detination_images, true);
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
                $image_filename = time() . '_' . uniqid() . '.' . $image_file->getClientOriginalExtension();
                $image_file->move($directory, $image_filename);
                $images_paths[] = 'itinerary_images/' . $image_filename;
            }

            $data["detination_images"] = json_encode($images_paths);
        }

            Arr::forget($data, "days_information_string");
            Arr::forget($data, "hotel_details_string");
            Arr::forget($data, "duration_string");
            Arr::forget($data, "selected_destination_string");
            Arr::forget($data, "itinerary_theme_string");
    
            Arr::forget($data, "destination_thumbnail_file");
            Arr::forget($data, "destination_images_files");

        $itinerary->update($data);

        return response()->json([
            'success' => 'Itinerary updated successfully',
            'updatedItinerary' => $itinerary,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $id)
    {
        // Delete thumbnail if it exists
        if (!empty($id->detination_thumbnail)) {
            $thumbnailPath = public_path($id->detination_thumbnail);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        // Delete images if they exist
        if (!empty($id->detination_images)) {
            $images = json_decode($id->detination_images, true);
            foreach ($images as $imagePath) {
                $fullPath = public_path($imagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        $id->delete();

        return response()->json(['success' => 'Itinerary deleted successfully'], 200);
    }
}
