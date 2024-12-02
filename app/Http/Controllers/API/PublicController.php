<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\PublicCompanyResource;
use App\Models\Company;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getCompanies(){
        
        $companies = Company::all();

        $resourceResponse = PublicCompanyResource::collection($companies);

        return response()->json($resourceResponse, 200);
    }


    public function getParticularItinerary($id){
       $itinerary = Itinerary::findOrFail($id);
        
        return response()->json(new ItineraryResource($itinerary), 200);
    }

    public function getItineraries($destination){

   // Convert the destination to the required format (lowercase or exact match based on your needs)
   // Assuming you want "Delhi" or any case-insensitive match
        
   // Query the itineraries based on the selected_destination field
   $itineraries = Itinerary::whereJsonContains('selected_destination->value', $destination)
                     ->where('itinerary_visibility', 'public')
                    ->whereHas('user', function ($query) {
                    // Add conditions for the user's authorization and visibility
                    $query->where('is_authorised', true)
                    ->where('is_publicly_present', true);
                    })
                    ->get();

   // Return the itineraries as a response (you can modify this as per your response format)
   return response()->json(ItineraryResource::collection($itineraries), 200);
    }

}