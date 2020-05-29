<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\UserRepository;
use App\User;
use Illuminate\Http\Request;

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


    public function getById($id)
    {
        $response = $this->UserRepository->getById($id);
        return Utilities::wrap($response);
    }




    public function delete($id)
    {
        $response = $this->UserRepository->softDelete($id);

        return Utilities::wrap($response);
    }




}
