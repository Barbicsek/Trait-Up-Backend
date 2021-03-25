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
            $jobId = $request->query->get('id');
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
            return response()->json(['Job successfully added to favourites!'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e, Response::HTTP_BAD_REQUEST);
        }
    }

    public function getFavouritesOfUser(): JsonResponse
    {
        try {
            $userId = auth()->user()->id;
            $mail = DB::table('favourites')
                ->where('user_id', '=', $userId)
                ->select(array('job_id', 'title', 'company', 'type',
                    'company_logo', 'location', 'created_at'))->get();
            return response()->json([
                'mail' => $mail,
                'id' => $userId,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['something went wrong'], 400);
        }
    }
}
