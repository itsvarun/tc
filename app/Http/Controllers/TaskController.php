<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    function __construct() {
        $this->middleware('can:update,task')
            ->only([
                'show',
                'update',
                'destroy'
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return $user->tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $task = Task::create($this->validateTask($request));

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
        $status = $task->update($this->validateTask($request));

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

    public function validateTask($request) {
        return $request->validate($this->rules($request));
    }

    public function rules($request) {

        $requiredIf = Rule::requiredIf($request->method() == "POST");

        return [
            'user_id' => [
                $requiredIf,
                'exists:users,id'
            ],
            'category_id' => [
                $requiredIf,
                'exists:categories,id'
            ],
            'name' => [
                $requiredIf,
                'min:3'
            ],
            'order' => [
                $requiredIf,
                'integer'
            ]
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
