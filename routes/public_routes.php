<?php



use App\Http\Controllers\API\PublicController;
use Illuminate\Support\Facades\Route;

// Publicly available API routes
Route::get('public-companies', [PublicController::class, 'getCompanies']);

Route::get('public-itineraries/{destination}', [PublicController::class, 'getItineraries']);

Route::get('public-itinerary/{id}', [PublicController::class, 'getParticularItinerary']);