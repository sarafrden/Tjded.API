<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\ReplayRepository;
use App\Replay;
use Illuminate\Http\Request;

class ReplayController extends Controller
{
    private $ReplayRepository;
    public function __construct()
    {
        $this->ReplayRepository = new ReplayRepository(new Replay());
    }

    /**
     * Getting Replays' list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/replays/getList",
     *      operationId="getreplaysList",
     *      tags={"Replays"},
     *      summary="Get list of replays",
     *      description="Returns list of replays",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Replay")
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
        $response = $this->ReplayRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/replays/{id}/getById",
    *      operationId="GetSinglereplay",
    *      tags={"Replays"},
    *      summary="Get single replays",
    *      description="Returns Get single replays",
    * @OA\Parameter(
    *          name="id",
    *          description="replays id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Replay")
    *       ),
    *     )
    */


    public function getById($id)
    {
        $response = $this->ReplayRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/replays/create",
     *      operationId="Insert Replay",
     *      tags={"Replays"},
     *      summary="Insert new Replay",
     *      description="Returns Replay data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Replay")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Replay")
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
            'replay' => 'required|string',
            'images' => 'file|nullable',

        ]);

        if($request->has('images'))
            $data['images'] = Utilities::upload($request->images, 'Replays');

        $response = $this->ReplayRepository->createReplay($data);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/replays/{id}/update",
     *      operationId="Update Replay",
     *      tags={"Replays"},
     *      summary="Insert new Replay info",
     *      description="Returns Replay data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Replay id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Replay")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Replay")
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
            'replay' => 'string',
            'images' => 'file|nullable',
        ]);
        if ($request->hasFile('images'))
        {
            $data['images'] = Utilities::upload($request->images, 'Replays');
        }

        $response = $this->ReplayRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/replays/{id}/delete",
    *      operationId="DeleteSingleReplay",
    *      tags={"Replays"},
    *      summary="Delete single Replay",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="Replay id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Replay")
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
        $response = $this->ReplayRepository->softDelete($id);

        return Utilities::wrap($response);
    }




}
