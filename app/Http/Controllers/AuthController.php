<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use GuzzleHttp\Client;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="Insert Users",
     *      tags={"Auth"},
     *      summary="Insert new User",
     *      description="Returns User data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);
        $user = new User([
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
         * @OA\Post(
         *      path="/login",
         *      operationId="Login User",
         *      tags={"Auth"},
         *      summary="Login User",
         *      description="Returns Access token",
         *      @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *      ),
         *      @OA\Response(
         *          response=201,
         *          description="Successful operation",
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         * )
         */

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['phone', 'password']);
        if(!Auth::attempt(['phone' => request('phone'), 'password' => request('password')]))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)

        */
        /**
         * @OA\Get(
         *      path="/logout",
         *      operationId="logoutUser",
         *      tags={"Auth"},
         *      summary="logout User",
         *      description="Returns logout",
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         *   security={
         *         {
         *             "api_key": {},
         *         }
         *     },
         * )
         */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User

     */
    /**
         * @OA\Get(
         *      path="/user",
         *      operationId="authenticatedUser",
         *      tags={"Auth"},
         *      summary="Get the authenticated User",
         *      description="Returns user info",
         *      @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *      ),
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         *   security={
        *         {
        *             "api_key": {},
        *         }
        *     },
         * )
         */

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    //Send Code Number
    public function sendOtp(Request $request){

        $rand = rand(100,999) . rand(100,999);
        $phone = $request->phone;
        $mobile = 964 . substr($phone,1);
        $client = new Client();
        $response = $client->post('http://sms-gw.net:81/v2/api/Gateway/SendMessage' , [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6IjE2ZGMwNmEyLThkYWQtNDcyYy1hNDBhLWY3YmQwYWVhZDAxNyIsImVtYWlsIjoiZW5qYXpAc21zLWd3Lm5ldCIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL25hbWUiOiJFTkpBWiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6IkN1c3RvbWVyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwOS8wOS9pZGVudGl0eS9jbGFpbXMvYWN0b3IiOiIyIiwianRpIjoiODQ0MzM3NzAtM2VlMS00NjY3LTg4ODktMDBjOWZhNDdmNDRkIiwibmJmIjoxNTc2NTk0OTAwLCJleHAiOjE2MDgyMTczMDAsImlzcyI6Iklzc3VlciIsImF1ZCI6IkF1ZGllbmNlIn0.xh9avMxWnwHH-uh1QPjLij5CWW5p5fF3ENz4A0xjHb4',
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                'number' => $mobile,
                'text' => ' Please Insert This Code ' . $rand,
                'messageType' => 3,
                'sentThrough' => 1
                ]
            ]);
            return response()->json(['success'=> $phone], 200);
}
}
