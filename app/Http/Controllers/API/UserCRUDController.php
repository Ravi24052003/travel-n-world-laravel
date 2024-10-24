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
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
   
        $res = new StoreUserResource($user);
   
        return response()->json(["status"=>true, "message"=>"User created successfully", "user"=>$res], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = new UserResource($user);

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        
        // Check if the current user is authorized to update this user
        if (Auth::id() != $user->id && Auth::user()->role == "user" ) {
            return response()->json(['error' => 'You are not authorized to update this user\'s data.'], 403);
        }


        // Validate and sanitize input data
        $data = $request->validated();


        // Handle password update
        // if (isset($data['old_password']) && Hash::check($data['old_password'], $user->password)) {


            if (!empty($data['password'])) {
                $user->password = $data['password']; // Hash the new password
            }


        // }
        
        // elseif (isset($data['old_password'])) {
        //     return response()->json(['error' => 'The provided old password is incorrect.'], 400);
        // }

        // Handle profile image update
        if ($request->hasFile('image')) {
            if (!empty($user->profile_image)) {
                $oldImagePath = public_path()."/storage"."/$user->profile_image";
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $newImagePath = $image->store('profile_images', 'public');
            $data['profile_image'] = $newImagePath;
        }

        // Remove the profile_image key if it was not provided in the request
        Arr::forget($data, 'image');

        // Update user with new data
        $user->update($data);

        return response()->json(['success' => 'User is updated successfully', "updatedUser"=>$user], 200);
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
