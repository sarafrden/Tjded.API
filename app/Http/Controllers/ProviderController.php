<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\ProviderRepository;
use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    private $ProviderRepository;
    public function __construct()
    {
        $this->ProviderRepository = new ProviderRepository(new Provider());
    }

    /**
     * Getting Providers' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/Providers/getList",
     *      operationId="getProvidersList",
     *      tags={"Providers"},
     *      summary="Get list of Providers",
     *      description="Returns list of Providers",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
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
        $response = $this->ProviderRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/Providers/getById/{id}",
    *      operationId="GetSingleProvider",
    *      tags={"Providers"},
    *      summary="Get single Providers",
    *      description="Returns Get single Providers",
    * @OA\Parameter(
    *          name="id",
    *          description="Providers id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Provider")
    *       ),
    *     )
    */

    public function getById($id)
    {
        $response = $this->ProviderRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/Providers/create",
     *      operationId="Insert Provider",
     *      tags={"Providers"},
     *      summary="Insert new Provider",
     *      description="Returns Provider data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
     *       ),
     *   security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     * )
     */

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'profession' => 'string',
            'skills' => 'string',
            'models' => 'string',
            'photo' => 'file',
        ]);
        if($request->hasFile('photo'))
            $data['photo'] = Utilities::upload(request()->photo, 'Providers');

        $response = $this->ProviderRepository->createProvider($data);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/Providers/{id}/update",
     *      operationId="Update Provider",
     *      tags={"Providers"},
     *      summary="Insert new Provider info",
     *      description="Returns Provider data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Provider id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
     *       ),
     *  security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     * )
     */

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'string',
            'phone_number' => 'string',
            'profession' => 'string',
            'skills' => 'string',
            'models' => 'string',
            'photo' => 'file',
        ]);

        if($request->hasFile('photo'))
            $data['photo'] = Utilities::upload(request()->photo, 'Providers');

        $response = $this->ProviderRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/Providers/{id}/delete",
    *      operationId="DeleteSingleProvider",
    *      tags={"Providers"},
    *      summary="Delete single Provider",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="Provider id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Provider")
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
        $response = $this->ProviderRepository->softDelete($id);

        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/Providers/rate/{id}",
     *      operationId="Rate Provider",
     *      tags={"Providers"},
     *      summary="Insert Provider Rate",
     *      description="Returns Provider data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Provider id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Provider")
     *       ),
     *  security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     * )
     */

    public function rate($id, Request $request)
    {
        request()->validate(['rate' => 'required|boolean']);

        $Provider = Provider::find($id);
        $rating = new \willvincent\Rateable\Rating;

        $rating->rating = $request->rate;
        $rating->user_id = auth()->user()->id;
        $Provider->ratings()->save($rating);
        $response = $Provider->averageRating;
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/Providers/{id}/getRate",
    *      operationId="GetSingleProviderRate",
    *      tags={"Providers"},
    *      summary="Get single ProvidersRate",
    *      description="Returns Get single Providers Rate",
    * @OA\Parameter(
    *          name="id",
    *          description="Providers id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Provider")
    *       ),
    *     )
    */


    public function getRate($id, Request $request)
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
        $response = $this->ProviderRepository->getRate($conditions, $columns, $sort, $skip, $take, $id);
        return Utilities::wrap($response);
    }
}
