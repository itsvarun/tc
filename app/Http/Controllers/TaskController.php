<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::create($this->validate($request));

        return $this->response($task, 'Task created', 'Error creating task', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $status = $task->update($this->validate($request));

        return $this->response($status, 'Task updated', 'Error updating task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $status = $task->delete();

        return $this->response($status, 'Task deleted', 'Error deleting task');
    }

    public function validate($request) {
        return $request->validate($this->rules());
    }

    public function rules() {
        return [
            'user_id' => 'bail|required|exists:users,id',
            'category_id' => 'bail|required|exists:categories,id'
            'name' => 'bail|required',
            'order' => 'required|integer'
        ];
    }

    public function response($status, $successMessage, $failureMessage, $sendData = false) {

        $response = [
            'status' => (bool) $status,
            'message' => $status ? $successMessage : $failureMessage
        ];

        if ($sendData) {
            $response['data'] = $status;
        }

        return $response;

    }
}
