<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class StudentController extends Controller
{
    public function register(RegisterRequest $request){
        Student::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "phone_no"=>isset($request->phone_no) ? $request->phone_no : "",
        ]);
        return response()->json([
            "status"=>true,
            "message"=>"Student account created successfully"
        ]);
        
    }
    public function login(Request $request){
        // check
        $student = Student::where("email", "=", $request->email)->first();

        if(!empty($student)){

            if(Hash::check($request->password, $student->password)){

                // create a token
                $token = $student->createToken("auth_token")->plainTextToken;

                // send a response
                return response()->json([
                    "status" => true,
                    "message" => "Student logged in successfully",
                    "access_token" => $token
                ],200);
            }else{

                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match"
                ], 404);
            }
        }else{

            return response()->json([
                "status" => false,
                "message" => "Student doesn't exist"
            ], 404);
        }
        
    }
    public function profile(){
        $data=auth()->user();
        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $data
        ]);
        
    }
    public function logout(){
        auth()->user()->tokens->delete();

        return response()->json([
            "status" => true,
            "message" => "Student logged out successfully"
        ],204);
    }
}
