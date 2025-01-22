<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogContentImagesController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ItineraryController;
use App\Http\Controllers\API\LeadController;
use App\Http\Controllers\API\PublicController;
use App\Http\Controllers\API\UserCRUDController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::post('login', [AuthController::class, "login"]);
Route::post('signup', [AuthController::class, "signup"]);

Route::middleware("auth:sanctum")->group(function(){

    Route::apiResource("user", UserCRUDController::class);

    Route::apiResource("company", CompanyController::class);

    Route::apiResource("itinerary", ItineraryController::class);

    Route::apiResource("blog", BlogController::class);

    Route::get('user-itineraries', [ItineraryController::class, "userItineraries"]);

    // leads routes starts here 
    Route::get('lead-phone-email', [LeadController::class, "getVerifiedLeadsPhoneEmail"]);

    Route::delete('lead-phone-email/{id}', [LeadController::class, "deleteVerifiedLeadPhoneEmail"]);

    Route::get('lead-query-for-customize-itinerary', [LeadController::class, "getVerifiedLeadsQueryForCustomizeItinerary"]);

    Route::delete('lead-query-for-customize-itinerary/{id}', [LeadController::class, "deleteVerifiedLeadQueryForCustomizeItinerary"]);

    Route::get('general-lead', [LeadController::class, "getGeneralLeads"]);

    Route::delete('general-lead/{id}', [LeadController::class, "deleteGeneralLead"]);

    // lead routes ends here 

    // blog category routes starts here
 Route::get("blog-category", [BlogController::class, "getAllBlogCategories"]);
 Route::post("blog-category", [BlogController::class, "storeBlogCategory"]);
 Route::put("blog-category/{id}", [BlogController::class, "updateBlogCategory"]);
 Route::delete("blog-category/{id}", [BlogController::class, "deleteBlogCategory"]);
    // blog category routes ends here

    // blog content images route starts here 
   Route::apiResource("blogContentImages", BlogContentImagesController::class);
    // blog content images route ends here 

    Route::post('logout', [AuthController::class, "logout"]);
});

require __DIR__.'/server.php';

require __DIR__.'/public_routes.php';