<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    private $UserRepository;
    public function __construct()
    {
        $this->UserRepository = new UserRepository(new User());
    }

    /**
     * Getting Users' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/Users/getList",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of Users",
     *      description="Returns list of Users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer'
        ]);

        $conditions = json_decode($request->filter, true);
        $columns = json_decode($request->columns, true);
        $sort = json_decode($request->sort);
        $skip = $request->skip;
        $take = $request->take;
        $response = $this->UserRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/Users/{id}/getById",
    *      operationId="GetSingleUser",
    *      tags={"Users"},
    *      summary="Get single Users",
    *      description="Returns Get single Users",
    * @OA\Parameter(
    *          name="id",
    *          description="Users id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/User")
    *       ),
    *     )
    */

    public function getById($id)
    {
        $response = $this->UserRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/users/{id}/delete",
    *      operationId="DeleteSingleUser",
    *      tags={"Users"},
    *      summary="Delete single User",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="User id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/User")
    *       ),
    *     security={
    *         {
    *             "api_key": {},
    *         }
    *     },
    *     )
    */


    public function delete($id)
    {
        $response = $this->UserRepository->softDelete($id);

        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/user/getOTP",
     *      operationId="getOTP",
     *      tags={"Auth"},
     *      summary="getOTP",
     *      description="Returns User otp",
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
    public function getOTP(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required',
//            'g-recaptcha-response' => 'required|captcha',
        ]);
        $response = $this->UserRepository->getOTP($data['phone']);
        return Utilities::wrapStatus($response['response'], $response['code']);

    }

    /**
         * @OA\Post(
         *      path="/user/loginUsingOTP",
         *      operationId="loginUsingOTP",
         *      tags={"Auth"},
         *      summary="loginUsingOTP",
         *      description="Returns Access otp",
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
    public function loginUsingOTP(Request $request)
    {
        $data = $request->validate([
            'OTP' => 'required',
            'phone' => 'required',
            'name' =>'string',
            'passwod' =>'string',
            'role' =>'string',
        ]);
        $cache = cache()->get($data['phone']);
        $response = $this->UserRepository->loginWithOTP($cache, $data);
        return Utilities::wrapStatus($response['response'], $response['code']);
    }




}
