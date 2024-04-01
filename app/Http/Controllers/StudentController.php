<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $students = Student::all();

        $data = [
          'status' => 200,
          'students' => $students
        ];

        return response()->json($data, 200);
    }

    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $data = [
            'status' => 422,
            'message' => $validator->messages()
        ];

        if($validator->fails()) {
            return response()->json($data, 422);
        }
        else {
            $student = new Student();

            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;

            $student->save();

            $data = [
                'status' => 200,
                'message' => "Data uploaded successfully"
            ];

            return response()->json($data, 200);
        }
    }
}
