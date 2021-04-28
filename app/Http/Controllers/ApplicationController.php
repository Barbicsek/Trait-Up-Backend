<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    function applyForJob(Request $request)
    {
        try{
            $userId = auth()->user()->id;
            $jobId = $request->get('jobId');
            $company = $request->get('company');
            $title = $request->get("title");
            $type = $request->get("type");
            $location= $request->get("location");
            Application::firstOrCreate([ "user_id" => $userId,  "job_id" => $jobId,
                "type" => $type, "company" => $company, "title" => $title,
                "location" => $location
                 ]);
            return response()->json([
                'status_code' => 200,
                'message' => 'Save application'
            ]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'something went wrong'], 400);
        }

    }

    function readUsersApplications()
    {
        try {
            $userId = auth()->user()->id;
            $applications = Application::
                 join('users', 'application.user_id', '=', 'users.id')
                ->where('user_id', $userId)
                ->select('application.*')
                ->get();

            return response()->json([
                'application' => $applications
            ], 200);
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'something went wrong'], 400);
        }
    }
}
