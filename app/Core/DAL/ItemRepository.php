<?php
namespace App\Core\DAL;
use App\Core\Helpers\Utilities;
use Illuminate\Http\UploadedFile;
use App\Item;
use App\Replay;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Auth;

class ItemRepository extends BaseRepository {

    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = Item::where('is_deleted', '=', 0)->where($conditions);

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





     public function getListWithCategory($conditions, $columns, $sort, $skip, $take)
    {
         $result = Item::where('is_deleted', '=', 0)->where($conditions)->with('category');

         if(!is_null($columns))
            $result = $result->select($columns);

         if(!is_null($sort))
            $result = $result->orderBy($sort->column, $sort->dir);

        return [
            'items' => $result->skip($skip)->take($take)->get(),
            'totalCount' => $result->count()
        ];
    }

     public function getReplay($conditions, $columns, $orderBy, $skip, $take, $id)
    {
        $result = Replay::where('Item_id', $id)->where('is_deleted', '=', 0)->where($conditions);

        if(!is_null($columns))
            $result = $result->select($columns);

        if(!is_null($orderBy))
            $result = $result->orderBy($orderBy->column, $orderBy->dir);

        return [
            'items' => $result->skip($skip)
                ->take($take)
                ->get(),
            'totalCount' => $result->count()
        ];
    }

    public function createItem(array $data)
    {

        return $this->createModel(new Item($data));
    }
}
