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
            $created_at = $request->get("created_at");
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
}
