<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneralLeadRequest;
use App\Http\Requests\StoreLeadPhoneEmailRequest;
use App\Http\Requests\StoreLeadQueryForCustomizeItineraryRequest;
use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\GeneralLeadResource;
use App\Http\Resources\ItineraryResource;
use App\Http\Resources\LeadPhoneEmailResource;
use App\Http\Resources\LeadQueryForCustomizedItineraryResource;
use App\Http\Resources\PublicCompanyResource;
use App\Http\Resources\PublicUserResource;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Company;
use App\Models\GeneralLead;
use App\Models\Itinerary;
use App\Models\LeadPhoneEmail;
use App\Models\LeadQueryForCustomizeItinerary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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


public function getAllBlogs(){
    $blogs = Blog::all();
    return response()->json(BlogResource::collection($blogs), 200);
}

public function getParticularBlog(Blog $blog){
    return response()->json(new BlogResource($blog), 200);
}


public function getRecentBlogs(){
    $blogs = Blog::orderBy('created_at', 'desc')->limit(3)->get();
    return response()->json(BlogResource::collection($blogs), 200);
}



public function getAllVerifiedTravelAgents(){
    $users = User::where('is_authorised', true)
                 ->where('is_publicly_present', true)
                 ->where('is_verified', true)
                 ->where('role', 'user')
                 ->get();



    return response()->json(PublicUserResource::collection($users), 200);
}


// lead controllers starts here 
public function storeLeadPhoneEmail(StoreLeadPhoneEmailRequest $request){
    $data = $request->validated();

    $leadPhoneEmail = LeadPhoneEmail::create($data);

    return response()->json([
    'success' => 'You Phone Email Saved Successfully You Will be Contacted Soon',
    'leadPhoneEmailResource' => new LeadPhoneEmailResource($leadPhoneEmail),
    ], 201);
}

public function storeLeadQueryForCustomizeItinerary(StoreLeadQueryForCustomizeItineraryRequest $request){
$data = $request->validated();

$leadQueryForCustomizeItinerary = LeadQueryForCustomizeItinerary::create($data);

return response()->json([
'success' => 'You data For Query Customization Saved Successfully You Will be Contacted Soon',
'leadQueryForCustomizeItineraryResource' => new LeadQueryForCustomizedItineraryResource($leadQueryForCustomizeItinerary)
], 201);
}


public function storeGeneralLead(StoreGeneralLeadRequest $request){
    $data = $request->validated();

    $generalLead = GeneralLead::create($data);

    return response()->json([
    'success'=> 'Your data saved successfully you will contacted soon',
    'generalLeadResource' => new GeneralLeadResource($generalLead)
    ], 201);
}
// lead controllers ends here

//get all blog categories
public function getAllBlogCategories(){
        $categories = BlogCategory::all();

        return response()->json( BlogCategoryResource::collection($categories), 200);
    }

// sharma work
    public function generateSitemap()
    {
        $slugs = Blog::select('blog_slug')->get();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
    
        $fixedUrls = [
            'https://travelnworld.com/',
            'https://travelnworld.com/about',
            'https://travelnworld.com/contact',
            'https://travelnworld.com/blog',
            'https://travelnworld.com/testimonials',
            'https://travelnworld.com/privacyPolicy',
            'https://travelnworld.com/terms',
            'https://travelnworld.com/b2b-signup',
            'https://travelnworld.com/b2b-login'
        ];
    
        foreach ($fixedUrls as $url) {
            $xml .= '<url>';
            $xml .= "<loc>$url</loc>";
            $xml .= "<changefreq>weekly</changefreq>";
            $xml .= "<priority>0.8</priority>";
            $xml .= '</url>';
        }
    
        foreach ($slugs as $slug) {
            $url = "https://travelnworld.com/blog/" . $slug->blog_slug; 
            $xml .= '<url>';
            $xml .= "<loc>$url</loc>";
            $xml .= "<changefreq>weekly</changefreq>";
            $xml .= "<priority>0.7</priority>";
            $xml .= '</url>';
        }
    
        $xml .= '</urlset>';
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
    // sharma work



}