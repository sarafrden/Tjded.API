<?php

namespace App\Http\Controllers;

use App\Core\Helpers\Utilities;
use App\Core\DAL\ProviderRepository;
use App\Provider;
use Illuminate\Http\Request;

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


    public function getById($id)
    {
        $response = $this->ProviderRepository->getById($id);
        return Utilities::wrap($response);
    }


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


    public function delete($id)
    {
        $response = $this->ProviderRepository->softDelete($id);

        return Utilities::wrap($response);
    }




}
