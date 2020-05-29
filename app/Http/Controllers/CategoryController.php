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


    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $response = $this->CategoryRepository->createCategory($data);
        return Utilities::wrap($response);
    }


    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'string',
        ]);
        $response = $this->CategoryRepository->update($id, $data);
        return Utilities::wrap($response);
    }


    public function delete($id)
    {
        $response = $this->CategoryRepository->softDelete($id);
        return Utilities::wrap($response);
    }

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
