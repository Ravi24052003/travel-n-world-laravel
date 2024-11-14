<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicCompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getCompanies(){
        
        $companies = Company::all();

        $resourceResponse = PublicCompanyResource::collection($companies);

        return response()->json($resourceResponse, 200);
    }
}
