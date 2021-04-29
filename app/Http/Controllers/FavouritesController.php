<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Mail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FavouritesController extends Controller
{
    public function addToFavourites(Request $request): JsonResponse
    {
        try {
            $jobId = $request->query->get('job_id');
            $type = $request->query->get('type');
            $createdAt = $request->query->get('created_at');
            $company = $request->query->get('company');
            $location = $request->query->get('location');
            $title = $request->query->get('title');
            $companyLogo = $request->query->get('company_logo');
            $userId = auth()->user()->id;
            Favourite::create(
                ['user_id' => $userId, 'job_id' => $jobId,
                    'title' => $title, 'company' => $company,
                    'type' => $type, 'company_logo' => $companyLogo,
                    'location' => $location, 'created_at' => $createdAt]
            );
            return response()->json([
                'message' =>'Job successfully added to favourites!',
                'jobId' => $jobId],
                Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFavouritesOfUser(): JsonResponse
    {
        try {
            $userId = auth()->user()->id;
            $jobs = DB::table('favourites')
                ->where('user_id', '=', $userId)
                ->select(array('job_id', 'title', 'company', 'type',
                    'company_logo', 'location', 'created_at'))->get();
            return response()->json([
                'jobs' => $jobs,
                'id' => $userId,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['something went wrong'], 400);
        }
    }

    public function removeFromFavourites(Request $request)
    {
        try {
            $jobId = $request->query->get('id');
            $userId = auth()->user()->id;
            Favourite::where('user_id', '=', $userId)
                    ->where( 'job_id', '=', $jobId)
            ->delete();
            return response()->json([
                'message' =>'Job successfully removed to favourites!',
                'jobId' => $jobId],
                Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }

    public function isFavouriteOfUser($id, $userId)
    {
        try {
            $job = Favourite::where('job_id', '=', $id)
                ->where( 'user_id', '=', $userId)
                ->first();
            if ($job === null) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }
}
