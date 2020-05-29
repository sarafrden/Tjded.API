<?php


namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Category;
use App\Item;


class CategoryRepository extends BaseRepository
{


    public function getList($conditions, $columns, $orderBy, $skip, $take)
    {
        $result = Category::where('is_deleted', '=', 0)->where($conditions);

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


    public function createCategory(array $data)
    {

        return $this->createModel(new Category($data));
    }

    public function getItems($conditions, $columns, $orderBy, $skip, $take, $id)
    {
        $result = Item::where('category_id', $id)->where($conditions);

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



}
