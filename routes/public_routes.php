<?php

use App\Http\Controllers\API\PublicController;
use Illuminate\Support\Facades\Route;

// Publicly available API routes
Route::get('public-companies', [PublicController::class, 'getCompanies']);

Route::get('public-itineraries/{destination}', [PublicController::class, 'getItineraries']);

Route::get('public-itinerary/{id}', [PublicController::class, 'getParticularItinerary']);

Route::get('public-blogs', [PublicController::class, 'getAllBlogs']);

Route::get('public-blog/{id}', [PublicController::class, 'getParticularBlog']);

Route::get('public-recent-blogs', [PublicController::class, 'getRecentBlogs']);

Route::get('public-verified-travel-agents', [PublicController::class, 'getAllVerifiedTravelAgents']);