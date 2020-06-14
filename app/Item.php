<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Item",
 *     description="Item model",
 *     @OA\Xml(
 *         name="Item"
 *     )
 * )
 */
class Item extends Model
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
     *      title="required",
     *      description="required to renew",
     *      example="paint"
     * )
     *
     * @var string
     */
    private $required;
    /**
     * @OA\Property(
     *     title="description",
     *     description="description",
     *     example="black & white"
     * )
     *
     * @var string
     */
    private $description;
    /**
     * @OA\Property(
     *     title="images",
     *     description="item images",
     *     example="photo"
     * )
     *
     * @var string
     */
    private $images;
    /**
     * @OA\Property(
     *     title="category_id",
     *     description="category_id",
     *     example=1
     * )
     *
     * @var integer
     */
    private $category_id;
    /**
     * @OA\Property(
     *     title="limited_price",
     *     description="budget",
     *     example=100
     * )
     *
     * @var float
     */
    private $limited_price;
    /**
     * @OA\Property(
     *     title="address",
     *     description="address",
     *     example=1
     * )
     *
     * @var string
     */
    private $address;


    protected $table = "items";
    protected $fillable = [

        'required',
        'description',
        'images',
        'category_id',
        'limited_price',
        'address'

    ];

    public function Replay()
    {
        return $this->hasMany(Replay::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

}
