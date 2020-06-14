<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\ItemRepository;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $ItemRepository;
    public function __construct()
    {
        $this->ItemRepository = new ItemRepository(new Item());
    }

    /**
     * @OA\Post(
     *      path="/Items/getList",
     *      operationId="getItemsList",
     *      tags={"Items"},
     *      summary="Get list of Items",
     *      description="Returns list of Items",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer',
        ]);

        $conditions = json_decode($request->filter, true);
        $columns = json_decode($request->columns, true);
        $sort = json_decode($request->sort);
        $skip = $request->skip;
        $take = $request->take;
        $response = $this->ItemRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/Items/getListWithCategory",
     *      operationId="getItemsListWithCategory",
     *      tags={"Items"},
     *      summary="Get list of Items With Category",
     *      description="Returns list of Items With Category",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *     )
     */
    public function getListWithCategory(Request $request)
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
        $response = $this->ItemRepository->getListWithCategory($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/Items/{id}/getById",
    *      operationId="GetSingleItem",
    *      tags={"Items"},
    *      summary="Get single Items",
    *      description="Returns Get single Items",
    * @OA\Parameter(
    *          name="id",
    *          description="Items id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Item")
    *       ),
    *     )
    */

    public function getById($id)
    {
        $response = $this->ItemRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/Items/create",
     *      operationId="Insert Item",
     *      tags={"Items"},
     *      summary="Insert new Item",
     *      description="Returns Item data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
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

            'required' => 'required|string',
            'limited_price' => 'required|string',
            'description' => 'string',
            'images' => 'file',
            'address' => 'required|string',
            'category_id' => 'nullable',

        ]);
        if($request->has('images'))
            $data['images'] = Utilities::upload($request->images, 'Items');

        $response = $this->ItemRepository->createItem($data);
        return Utilities::wrap($response);

    }

    /**
     * @OA\Post(
     *      path="/Items/{id}/update",
     *      operationId="Update Item",
     *      tags={"Items"},
     *      summary="Insert new Item info",
     *      description="Returns Item data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Item id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
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
            'required' => 'string',
            'limited_price' => 'string',
            'description' => 'string',
            'images' => 'file',
            'address' => 'string',
            'category_id' => 'nullable',
        ]);
        if ($request->hasFile('images'))
        {
            $data['images'] = Utilities::upload($request->images, 'Items');
        }

        $response = $this->ItemRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
    * @OA\Get(
    *      path="/Items/{id}/delete",
    *      operationId="DeleteSingleItem",
    *      tags={"Items"},
    *      summary="Delete single Item",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="Item id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Item")
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
        $response = $this->ItemRepository->softDelete($id);

        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/Items/{id}/getReplay",
     *      operationId="getItemReplayssList",
     *      tags={"Items"},
     *      summary="Get list of Items Replays",
     *      description="Returns list of Replays",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *     )
     */

    public function getReplay($id, Request $request)
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
        $response = $this->ItemRepository->getReplay($conditions, $columns, $sort, $skip, $take, $id);
        return Utilities::wrap($response);
    }





}
