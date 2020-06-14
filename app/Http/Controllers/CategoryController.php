<?php

namespace App\Http\Controllers;

use App\Core\DAL\CategoryRepository;
use App\Core\Helpers\Utilities;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $CategoryRepository ;

    public function __construct()
    {
        $this->CategoryRepository = new CategoryRepository(new Category());
    }

    /**
     * @OA\Post(
     *      path="/categories/getList",
     *      operationId="getCategoryList",
     *      tags={"Categories"},
     *      summary="Get list of Categories",
     *      description="Returns list of Categories",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
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
        $response = $this->CategoryRepository->getList($conditions, $columns, $sort, $skip, $take);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/categories/create",
     *      operationId="Insert Category",
     *      tags={"Categories"},
     *      summary="Insert new Category",
     *      description="Returns Category data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
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
        ]);
        $response = $this->CategoryRepository->createCategory($data);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/categories/{id}/update",
     *      operationId="Update Category",
     *      tags={"Categories"},
     *      summary="Insert new Category info",
     *      description="Returns Category data",
     *  @OA\Parameter(
     *          name="id",
     *          description="Category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Category")
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
        ]);
        $response = $this->CategoryRepository->update($id, $data);
        return Utilities::wrap($response);
    }

     /**
    * @OA\Get(
    *      path="/categories/{id}/delete",
    *      operationId="DeleteSingleCategory",
    *      tags={"Categories"},
    *      summary="Delete single Category",
    *      description="Returns Deleted",
    * @OA\Parameter(
    *          name="id",
    *          description="Category id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/Category")
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
        $response = $this->CategoryRepository->softDelete($id);
        return Utilities::wrap($response);
    }

    /**
     * @OA\Post(
     *      path="/categories/{id}/getItems",
     *      operationId="getCategoryItemsList",
     *      tags={"Categories"},
     *      summary="Get list of category Items",
     *      description="Returns list of Items",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *     )
     */

    public function getItems($id, Request $request)
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
        $response = $this->CategoryRepository->getItems($conditions, $columns, $sort, $skip, $take, $id);
        return Utilities::wrap($response);
    }
}
