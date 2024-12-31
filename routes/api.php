<?php

use App\Http\Controllers\API\AuthController;
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

    Route::post('logout', [AuthController::class, "logout"]);
});

require __DIR__.'/public_routes.php';


// Route::get('/storage-link', function(){
//     Artisan::call('storage:link');

//     return response("symbolic link created successfully");
// });


// Route::get("/unlink", function(){
//     $publicStorageLink = public_path('storage');

//     if (File::exists($publicStorageLink) && File::isDirectory($publicStorageLink)) {
//         rmdir($publicStorageLink);
//         return response("symbolic link removed successfully");
//     } else {
//         return response("Symbolic link does not exists");
//     }
// });



// Route::get('/migrate', function(){
//     Artisan::call('migrate', ['--force' => true]);

//     return response("Database migrations completed successfully");
// });


// Route::get('/migrate-seed', function(){
//     Artisan::call('migrate:fresh', [
//         '--force' => true,
//         '--seed' => true,
//     ]);

//     return response("Database has been refreshed and seeded.");
// });

// Route::get('users/{id}', function ($id) {
 
// });
