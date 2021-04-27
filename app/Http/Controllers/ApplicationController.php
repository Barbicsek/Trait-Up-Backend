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
            Application::insert([  "user_id" => $userId,  "job_id" => $request->get('jobId'), "type" => $request->get("type"), "company" => $request->get('company'), "description" => $request->get('description')]);
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
