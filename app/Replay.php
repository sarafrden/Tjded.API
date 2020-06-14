<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Replay",
 *     description="Replay model",
 *     @OA\Xml(
 *         name="Replay"
 *     )
 * )
 */
class Replay extends Model
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
     *      title="replay",
     *      description="replay body",
     *      example="I can do it"
     * )
     *
     * @var string
     */
    private $replay;
    /**
     * @OA\Property(
     *      title="images",
     *      description="photo of a model",
     *      example="photo"
     * )
     *
     * @var string
     */
    private $images;

    protected $table = "replays";

    protected $fillable = [

        'replay',
        'images'

    ];

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }

    public function Provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
