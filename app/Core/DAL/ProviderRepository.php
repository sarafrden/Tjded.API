<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Provider;
use App\Replay;
use Illuminate\Http\UploadedFile;

class ProviderRepository extends BaseRepository {

    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = Provider::where('is_deleted', '=', 0)->where($conditions);

        if(!is_null($columns))
            $result = $result->select($columns);

        if(!is_null($orderBy))
        {
            $result = $result->orderBy($orderBy->column, $orderBy->dir);
        }

        return [
            'items' => $result->skip($skip)->take($take)->get(),
            'totalCount' => $result->count()
        ];
    }

    public function createProvider($data)
    {

        return $this->createModel(new Provider($data));
    }




    // public function getReplay($conditions, $columns, $orderBy, $skip, $take, $id)
    // {
    //     $result = Replay::where('Provider_id', $id)->where('is_deleted', '=', 0)->where($conditions);

    //     if(!is_null($columns))
    //         $result = $result->select($columns);

    //     if(!is_null($orderBy))
    //         $result = $result->orderBy($orderBy->column, $orderBy->dir);

    //     return [
    //         'items' => $result->skip($skip)
    //             ->take($take)
    //             ->get(),
    //         'totalCount' => $result->count()
    //     ];
    // }


}
