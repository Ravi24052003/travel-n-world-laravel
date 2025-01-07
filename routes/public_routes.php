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


// public lead routes starts here 
Route::post('lead-phone-email', [PublicController::class, 'storeLeadPhoneEmail']);

Route::post('lead-query-for-customize-itinerary', [PublicController::class, 'storeLeadQueryForCustomizeItinerary']);

Route::post('general-lead', [PublicController::class, 'storeGeneralLead']);

// public leads routes ends here 
Route::get('public-blog-categories', [PublicController::class, 'getAllBlogCategories']);

// sharma work
Route::get('sitemap.xml', [PublicController::class, 'generateSitemap']);
// sharma work