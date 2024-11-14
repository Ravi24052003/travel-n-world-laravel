<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResponse;
use App\Models\Company;
use App\Models\User;
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

            $directory = public_path('company_images');

            $filename = time() . '.' . $image_file->getClientOriginalExtension();

         $image_path = $image_file->move($directory, $filename);

         $data["company_logo"] = 'company_images/'.$filename;
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
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->validated();
        $data["services_offered"] = json_decode($data["services_offered_string"]);
    
        if ($request->hasFile('company_image')) {
            // Delete the old image if it exists
            if (!empty($company->company_logo)) {
                $oldImagePath = public_path($company->company_logo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            // Handle new image upload
            $image_file = $request->file('company_image');
            $directory = public_path('company_images');
            $filename = time() . '.' . $image_file->getClientOriginalExtension();
            
            $image_path = $image_file->move($directory, $filename);
            $data["company_logo"] = 'company_images/' . $filename;
        }
    
        Arr::forget($data, "services_offered_string");
        Arr::forget($data, 'company_image');
    
        // Update the company name in the related user record, if provided
        if ($request->has('company_name')) {
            $companyName = $request->input('company_name');
            $data['company_name'] = $companyName; 
            $company->user()->update(['company_name' => $companyName]);
        }
    
        $company->update($data);
    
        return response()->json([
            'success' => 'Company is updated successfully',
            "updatedCompany" => new CompanyResponse($company)
        ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
