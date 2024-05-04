<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProjectController extends Controller
{
    public function addProject(Request $request){
        // validation
        $request->validate([
            "title" => "required",
            "description" => "required",
        ]);

        $student_id = auth()->user()->id;

        $project = new Project();
        $project->student_id = $student_id;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->duration = isset($request->duration) ? $request->duration : "";
        $project->save();

        // send response
        return response()->json([
            "status" => true,
            "message" => "Project created successfully"
        ]);
        
    }
    public function getProjectList(){
        $student_id = auth()->user()->id;

        $projects = Project::where("student_id", $student_id)->get();
        if(!empty($projects)){
            return response()->json([
                "status" => true,
                "message" => "Projects found",
                "data" => $projects
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "No Project found",
        ]);
        
    }
    public function getSingleProject($project_id){
        $student_id = auth()->user()->id;
        if(Project::where([
            "id" => $project_id,
            "student_id" => $student_id
        ])->exists()){

            $details = Project::where([
                "id" => $project_id,
                "student_id" => $student_id
            ])->first();

            return response()->json([
                "status" => true,
                "message" => "Project found",
                "data" => $details
            ],200);
        }else{

            return response()->json([
                "status" => false,
                "message" => "No project found"
            ]);
        }
    }
    public function deleteProject($project_id){
        $student_id = auth()->user()->id;
        if(Project::where([
            "id" => $project_id,
            "student_id" => $student_id
        ])->exists()){

            $project = Project::where([
                "id" => $project_id,
                "student_id" => $student_id
            ])->first();
            $project->delete();
            return response()->json([
                "status" => true,
                "message" => "Project found",
            ],204);
        }else{

            return response()->json([
                "status" => false,
                "message" => "No project found"
            ]);
        }
        
    }

    public function deleteMyProjects(){
        $student_id = auth()->user()->id;
        if(Project::where([
            "student_id" => $student_id
        ])->exists()){

            $projects = Project::where([
                "student_id" => $student_id
            ])->get();
            $projects->delete();
            return response()->json([
                "status" => true,
                "message" => "All Projects deleted ",
            ],204);
        }else{

            return response()->json([
                "status" => false,
                "message" => "No project found"
            ]);
        }
        
    }
}
