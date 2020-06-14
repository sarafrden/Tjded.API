<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Category",
 *     description="Category model",
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category extends Model
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;
    /**
     * @OA\Property(
     *      title="name",
     *      description="name of the category",
     *      example="cars"
     * )
     *
     * @var string
     */
    private $name;

    protected $table = "categories";


    protected $fillable = [

        'name',


    ];



    public function Item()
    {
        return $this->hasMany(Item::class);
    }
}
