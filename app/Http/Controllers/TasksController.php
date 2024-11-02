<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Traits\HttpResponses;

class TasksController extends Controller
{

    public function index()
    {
        $task = Task::get();
        return TaskResource::collection($task); //brings all tasks for any user

        //here brings the tasks for user that login

        // return TaskResource::collection(
        //     Task::where('user_id', Auth::user()->id)->get()
        // );

    }


    public function create() {} //dont use this method in API

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $request->validated($request->all());
        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : new TaskResource($task);
    }


    public function edit(string $id) //we dont need in API
    {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //$request->validated($request->all()); retry in this because give some problem
        $task->update($request->all());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) :  $task->delete();
    }

    private function isNotAuthorized($task)
    {
        if (Auth::user()->id !== $task->user_id) {
            return response()->json([
                'message' => 'you are not Authorized to do this request'
            ], 403);
        }
    }
}
