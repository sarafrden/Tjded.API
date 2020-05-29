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


    public function getById($id)
    {
        $response = $this->ReplayRepository->getById($id);
        return Utilities::wrap($response);
    }


    public function create(Request $request)
    {
        $data = $request->validate([
            'replay' => 'required|string',

        ]);

        $response = $this->ReplayRepository->createReplay($data);
        return Utilities::wrap($response);
    }


    public function update($id, Request $request)
    {
        $data = $request->validate([
            'replay' => 'string',

        ]);


        $response = $this->ReplayRepository->update($id, $data);
        return Utilities::wrap($response);
    }


    public function delete($id)
    {
        $response = $this->ReplayRepository->softDelete($id);

        return Utilities::wrap($response);
    }




}
