<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    function index(Request $request)
    {
        try{
            $validation = $request->validate([
                'email' => 'required|email',
                'password' => 'required']);
        }
        catch (\Exception $exception){
            return response()->json("error", Response::HTTP_BAD_REQUEST);
        }

        $user= User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], Response::HTTP_NOT_FOUND);
        }
        $favController = new FavouritesController;
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

//        return response()->json($error, Response::HTTP_BAD_REQUEST);

        return response($response, Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function register(Request $request)
    {
        try{
            $validation = $request->validate([
                'email' => 'required|email',
                'password' => 'required']);
        }
        catch (\Exception $exception){
            return response()->json("error", Response::HTTP_BAD_REQUEST);
        }

        User::firstOrCreate([ "name" => $request->get('name'), "email" => $request->get('email'), "password" => Hash::make( $request->get('password'))]);
        return response()->json([
            'status_code' => 200,
            'message' => 'User created successfully'
        ]);
    }

    function getUserDatasById()
    {
        try {
            $userId = auth()->user()->id;
            $personalData = DB::table("users")
                ->where('id', "=", $userId)
                ->select('users.*')
                ->get();
            return response()->json([
                'personalData' => $personalData,
            ], 200);
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'something went wrong'], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function getUserEducation(Request $request)
    {
        $id = $request->user()->id;
        return DB::table('studies')
            ->join('users', 'studies.user_id', '=', 'users.id')
            ->where('users.id', '=', $request->user()->id)
            ->select('studies.*')
            ->get();
    }

    public function updateUserInfo(Request $request)
    {
        $user = get_object_vars(json_decode($request->query->get('userState')));
        DB::table('users')
            ->where('id', $user['id'])
            ->update(['name' => $user['name'], 'email' => $user['email'],
                      'phone number' => $user['phone number'],
                        'address' => $user['address'],
                        'birth date' => $user['birth date']]);
        return User::find($user['id']);
    }
}
