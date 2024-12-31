<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralLeadResource;
use App\Http\Resources\LeadPhoneEmailResource;
use App\Http\Resources\LeadQueryForCustomizedItineraryResource;
use App\Models\GeneralLead;
use App\Models\LeadPhoneEmail;
use App\Models\LeadQueryForCustomizeItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function getVerifiedLeadsPhoneEmail()
    {
        $user = Auth::user();

        $leadsPhoneEmail = $user->leadPhoneEmail;

        return response()->json(LeadPhoneEmailResource::collection($leadsPhoneEmail), 200);
    }

    public function deleteVerifiedLeadPhoneEmail(LeadPhoneEmail $id)
    {

        $id->delete();

        return response()->noContent(); // Automatically returns 204 without body
    }

    public function getVerifiedLeadsQueryForCustomizeItinerary()
    {
        $user = Auth::user();

        $leadsQueryForCustomizeItinerary = $user->leadQueryForCustomizeItinerary;

        return response()->json(LeadQueryForCustomizedItineraryResource::collection($leadsQueryForCustomizeItinerary), 200);
    }

    public function deleteVerifiedLeadQueryForCustomizeItinerary(LeadQueryForCustomizeItinerary $id)
    {

        $id->delete();

        return response()->noContent(); // Automatically returns 204 without body
    }

    public function getGeneralLeads()
    {
        $generalLeads = GeneralLead::all();

        return response()->json(GeneralLeadResource::collection($generalLeads), 200);
    }

    public function deleteGeneralLead(GeneralLead $id)
    {
        $id->delete();

        return response()->noContent(); // Automatically returns 204 without body
    }
}
