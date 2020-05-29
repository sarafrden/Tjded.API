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

    public function getById($id)
    {
        $response = $this->ItemRepository->getById($id);
        return Utilities::wrap($response);
    }


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


    public function delete($id)
    {
        $response = $this->ItemRepository->softDelete($id);

        return Utilities::wrap($response);
    }


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
