<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }
    public function listUsers()
    {
        return UserResource::collection(User::all());
    }
    public function infoUser(Request $request)
    {
        // Lấy người dùng từ request
        $user = $request->user();

        if ($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        if(User::where('email', $validated['email'])->first()){
            return response()->json([
                'message' => 'Email already exists'
            ], 400);
        }
        $validated['password'] = Hash::make($validated['password']);
        $created = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => '001'
        ]);
        if (!$created) {
            return response()->json([
                'message' => 'Error in creating user'], 500);
        }
        return response()->json([
            'message' => 'User created', 'data' => ($created)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
    
        if ($user) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    


    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
 
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
 
        return response()->json([
            'message' => 'Delete complete'], 200);
    }
    public function login(LoginRequest $request)
    {
        $input = $request->validated();
        $user = User::where('email', $input['email'])->first();
        if (!$user || !Hash::check($input['password'], $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'message' => 'Login success',
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
