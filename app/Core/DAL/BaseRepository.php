<?php
namespace App\Core\DAL;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository {
    public $table;
    public function __construct(Model $model){
        $this->table = $model;
    }

    public function getAll(){
        return $this->table->all();
    }

    public function getById($id){
        $item = $this->table->find($id);
        if (!is_null($item))
        {
            if(!$item['is_deleted'])
            {
                return [
                    'response' => $item,
                    'code' => 200
                ];
            }
        }
        return [
            'response' => [
                'message' => 'Item not found.',
            ],
            'code' => 401
        ];
    }

    /**
     * Saving model to database and retrieving model.
     * @param $model
     * @return mixed
     */
    public function createModel($model)
    {
        $model->save();
        return $model;
    }

    public function update($id, $values){
        $item = $this->table->findorFail($id);
        $item->update($values);
        $item->save();
        return $item;
    }

    public function delete($model)
    {
         $model->delete();
         return ('deleted');
    }

    public function softDelete($id)
    {
        $model = $this->table->find($id);
        if(is_null($model))
            return [
                'success' => false,
                'message' => 'Item is not found',
            ];
        if($model->update(['is_deleted' => true]) > 0)
            return [
                'success' => true
            ];
        else
            return [
                'success' => false,
                'message' => 'Database Error',
             ];
    }

}
