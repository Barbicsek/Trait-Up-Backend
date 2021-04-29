<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StudyController extends Controller
{
    public function addEducation(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $school = $request->query->get('school');
            $degree = $request->query->get('degree');
            $faculty = $request->query->get('faculty');
            $level = $request->query->get('level');
            $from = $request->query->get('from');
            $to = $request->query->get('to');
            Study::create(
                ['user_id' => $userId, 'school' => $school,
                    'degree' => $degree, 'type' => $faculty,
                    'level' => $level, 'from' => $from, 'to' => $to]
            );
            return response()->json([
                'message' => 'Education successfully added!',
                'study' => Study::where('user_id', '=', $userId)->get()],
                Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateEducation(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $eduId = $request->query->get('eduId');
            $school = $request->query->get('school');
            $degree = $request->query->get('degree');
            $faculty = $request->query->get('faculty');
            $level = $request->query->get('level');
            $from = $request->query->get('from');
            $to = $request->query->get('to');
            Study::where('id', '=', $eduId)
                ->where('user_id', '=', $userId)->update(
                    ['user_id' => $userId, 'school' => $school,
                        'degree' => $degree, 'type' => $faculty,
                        'level' => $level, 'from' => $from, 'to' => $to]);
            return response()->json([
                'message' => 'Job successfully updated!',
                'study' => Study::where('user_id', '=', $userId)->get()],
                Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteStudy(Request $request)
    {
        try {
            $eduId = $request->query->get('eduId');
            $userId = auth()->user()->id;
            Study::where('user_id', '=', $userId)
                ->where('id', '=', $eduId)
                ->delete();
            return response()->json([
                'message' => 'Education successfully removed!',
                'jobId' => Study::where('user_id', '=', $userId)
                    ->where('id', '=', $eduId)->get()],
                Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }
}
