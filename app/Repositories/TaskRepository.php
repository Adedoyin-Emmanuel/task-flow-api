<?php

namespace App\Repositories;

use App\Models\Task;
use Exception;

class TaskRepository
{
    /**
     * Create a new task.
     *
     * @param array $data
     * @return \App\Models\Task
     * @throws \Exception
     */
    public function createTask(array $data)
    {
        if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
            throw new Exception('End date must be after start date.');
        }

        $task = Task::create([
            "name" => $data["name"],
            "description" => $data["description"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
            "project_id" => $data["project_id"],
            "assignee" => $data["assignee"],
            "status" => $data["status"] ?? 'pending',
        ]);

        return $task;
    }


    public function getAllTasks(){
        return Task::all();
    }

    /**
     * Find a task by ID.
     *
     * @param string $id
     * @return \App\Models\Project|null
     */
    public function getTaskById(string $id): ?Task
    {
        return Task::find($id);
    }


     public function updateTask(string $id, array $data)
    {
        $task = Task::findOrFail($id);

        $task->update($data);

        return $task;
    }


    public function deleteTask(string $id){
        return Task::destroy($id);
    }


    public function getTasksByProjectId($projectId)
    {
        return Task::where('project_id', $projectId)->get();
    }
}
