<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Resources\CompanyResponse;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();

        $resourceResponse = CompanyResponse::collection($companies);

        return response()->json($resourceResponse, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $data = $request->validated();
        $data["user_id"] = Auth::id();
        $data["services_offered"] = json_decode($data["services_offered_string"]);

        if($request->hasFile("company_image")){
            $image_file = $request->file("company_image");
         $image_path = $image_file->store("company_images", "public");

         $data["company_logo"] = $image_path;
        }

        Arr::forget($data, "services_offered_string");
        Arr::forget($data, "company_image");

        $company = Company::create($data);

        $resouceResponse = new CompanyResponse($company);

        return response()->json($resouceResponse, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
