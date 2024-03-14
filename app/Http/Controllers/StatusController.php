<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Http\Resources\StatusResource;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StatusRequest::collection(Status::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusRequest $request)
    {
        $input = $request->validated();
        if(Status::where('name', $input['name'])->first()){
            return response()->json([
                'message' => 'Status already exists'
            ], 400);
        }
        $createdStatus = Status::create($input);
        if (!$createdStatus) {
            return response()->json([
                'message' => 'Error in creating status'], 500);
        }
        return response()->json([
            'message' => 'Status created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = Status::find($id);
        if (!$status) {
            return response()->json([
                'message' => 'Status not found'
            ], 404);
        }
        return new StatusResource($status);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $status = Status::find($id);
        if (!$status) {
            return response()->json([
                'message' => 'Status not found'
            ], 404);
        }
        $status->update($input);
        return response()->json([
            'message' => 'Status updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = Status::find($id);
        if (!$status) {
            return response()->json([
                'message' => 'Status not found'
            ], 404);
        }
        $status->delete();
        return response()->json([
            'message' => 'Status deleted successfully'
        ], 200);
    }
}
