<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\ShowUserResource;
use App\Http\Resources\SignupResource;
use App\Http\Resources\StoreUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class UserCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $users = UserResource::collection(User::all());

       return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserResource $request)
    {
        $data = $request->validated();

        $user = User::create($data);
   
        $res = new UserResource($user);
   
        return response()->json(["status"=>true, "message"=>"User created successfully", "user"=>$res], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userResource = new UserResource($user);

        return response()->json($userResource, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (Auth::id() != $user->id && Auth::user()->role == "user" ) {
            return response()->json(['error' => 'You are not authorized to update this user\'s data.'], 403);
        }

        $data = $request->validated();

            if (!empty($data['password'])) {
                $user->password = $data['password']; // Hash the new password
            }

        // Handle profile image update
        if ($request->hasFile('user_image')){
            if (!empty($user->your_photo)) {
                $oldImagePath = public_path($user->your_photo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('user_image');
            $directory = public_path('user_images');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            $newImagePath = $image->move($directory, $filename);
            $data['your_photo'] = 'user_images/'.$filename;
        }

        // Remove the profile_image key if it was not provided in the request
        Arr::forget($data, 'user_image');
        
        if ($request->has('company_name')) {
            $companyName = $request->input('company_name');
            $data['company_name'] = $companyName;
            $company = Company::where('user_id', $user->id)->first();
            if ($company) {
                $company->update(['company_name' => $companyName]);
            }
        }
        // Update user with new data
        $user->update($data);

        return response()->json(['success' => 'User is updated successfully', "updatedUser"=> new UserResource($user)], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role != "admin" ) {
            return response()->json(['error' => 'You are not authorized to delete this user'], 403);
        }

        $user->tokens()->delete();

        if (!empty($user->profile_image)) {
            $oldImagePath = public_path()."/storage"."/$user->profile_image";
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $user->delete();

        return response()->json([
        "message"=>"User deleted successfully"
        ], 204);
    }
}
