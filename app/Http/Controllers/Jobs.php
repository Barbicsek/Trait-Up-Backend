<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Jobs extends Controller
{
    //
    function fetchJobs(Request $request) {
        $curl = curl_init();
        $url = "https://jobs.github.com/positions.json?page=". $request->get('page');

        curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url
        ]);

        $response = curl_exec($curl);


        return response()->json([
            'jobs' => $response
        ]);

//        if ($e = curl_error($curl))
//        {
//            echo $e;
//        }else {
//            $decoded = json_decode($resp);
//            print_r($decoded);
//        }

    }

    function getJobDescriptionById(Request $request) {
        $fc = new FavouritesController;
        $id = $request->id;
        $userId = $request->user_id;
        $isFavourite = $fc->isFavouriteOfUser($id, $userId);
        $curl = curl_init();
        $url = "https://jobs.github.com/positions/" . $request->get('id') . ".json";

        curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url
        ]);

        $response = curl_exec($curl);


        return response()->json([
            'job' => $response,
            'isFav' => $isFavourite
        ]);

//        if ($e = curl_error($curl))
//        {
//            echo $e;
//        }else {
//            $decoded = json_decode($resp);
//            print_r($decoded);
//        }

    }
}
