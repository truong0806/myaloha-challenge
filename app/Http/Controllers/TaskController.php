<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\StatusResource;
use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use DateTime;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::all();
        if ($statuses->isEmpty()) {
            return response()->json([
                'message' => 'No statuses found'
            ], 404);
        }
       
        
        $data = $statuses->map(function ($status) {
            
            return [
                'id' => $status->id,
                'title' => $status->name,
                'tasks' => $status->tasks->map(function ($task) {
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $task->deadline);
                    $formattedDate = $date->format('d-m-Y');
                    return [
                        'statusId' => $task->status_id,
                        'id' => $task->id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'deadline' => $formattedDate
                        
                    ];
                }),
            ];
        });

        return response()->json($data, 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $findStatus = Status::find($input['status']);
        $findUser = User::find($input['created_by']);
        $deadline = \DateTime::createFromFormat('d-m-Y', $input['deadline']);
        if(!$deadline){
            return response()->json([
                'message' => 'Invalid date format'
            ], 400);
        }
        if($deadline < new \DateTime()){
            return response()->json([
                'message' => 'Deadline cannot be in the past'
            ], 400);
        }
        if(!$findUser){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        if($findStatus){
            $createTask = Task::create([
                'title' => $input['title'],
                'description' => $input['description'],
                'deadline' => $deadline,
                'created_by' => $findUser->id,
                'status_id' => $findStatus->id
            ]);
            if (!$createTask) {
                return response()->json([
                    'message' => 'Error in creating task'], 500);
            }
            return response()->json([
                'message' => 'Task created successfully'
            ], 201);
        }else{
            $createStatus = Status::create([
                'name' => $input['status']
            ]);
            if (!$createStatus) {
                return response()->json([
                    'message' => 'Error in creating status'], 500);
            }
            $createTask = Task::create([
                'title' => $input['title'],
                'description' => $input['description'],
                'deadline' => $deadline,
                'created_by' => $findUser->id,
                'status_id' => $createStatus->id
            ]);
            if (!$createTask) {
                return response()->json([
                    'message' => 'Error in creating task'], 500);
            }
            return response()->json([
                'message' => 'Task created successfully'
            ], 201);
        }
        
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
        
        return new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function updateStatus(Request $request, string $id)
    {
        $input = $request->all();
        $findStatus = Status::where('id', $input['status'])->first();
        $task = Task::find($id)->first();
        if(!$findStatus){
            return response()->json([
                'message' => 'Status not found'
            ], 404);
        }
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
        $task->status_id = $input['status'];
        $task->save();
        return response()->json([
            'message' => 'Task status updated successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $findStatus = Status::where('id', $input['status'])->first();
        $task = Task::find($id);
       if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
       
        if(isset($input['deadline'])){
            $deadline = \DateTime::createFromFormat('d-m-Y', $input['deadline']);
            if($deadline < new \DateTime()){
                return response()->json([
                    'code' => '400',
                    'message' => 'Deadline cannot be in the past'
                ], 400);
            }
            $task->deadline = $deadline;
            
        }
        if(isset($input['title'])){
            $task->title = $input['title'];
        }
        if(isset($input['description'])){
            $task->description = $input['description'];
        }
        
        $task->save();
        return response()->json([
            'message' => 'Task updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
        $deleted = $task->delete();
        if (!$deleted) {
            return response()->json([
                'message' => 'Error in deleting task'], 500);
        }
        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }
}
