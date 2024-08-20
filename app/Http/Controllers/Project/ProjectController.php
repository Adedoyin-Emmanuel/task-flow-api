<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\DateOrder;
use Exception;

class ProjectController extends Controller
{


    public function create(Request $request)
    {
        try {

          $validatedData = $request->validate([
            "name" => ["required", "string", "max:255"],
            "description" => ["required", "string"],
            "start_date" => ["required", "date"],
            "end_date" => ["required", "date", new DateOrder($request->input('start_date'))],
            "status" => ["required", "string", "in:pending,in progress,completed,overdue"]
         ]);

            // $project = Project::create([
            //     "name" => $validatedData["name"],
            //     "description" => $validatedData["description"],
            //     "start_date" => $validatedData["start_date"],
            //     "end_date" => $validatedData["end_date"],
            //     "status" => $validatedData["status"]
            // ]);

            return response()->json([
                "success" => true,
                "message" => "Project created successfully",
                "data" => null
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);

        }
    }
}
