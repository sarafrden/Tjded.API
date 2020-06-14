<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

/**
 * @OA\Schema(
 *     title="Provider",
 *     description="Provider model",
 *     @OA\Xml(
 *         name="Provider"
 *     )
 * )
 */
class Provider extends Model
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
     *      description="provider name",
     *      example="Sara"
     * )
     *
     * @var string
     */
    private $name;
    /**
     * @OA\Property(
     *      title="profession",
     *      description="provider job",
     *      example="dyer"
     * )
     *
     * @var string
     */
    private $profession;
    /**
     * @OA\Property(
     *      title="skills",
     *      description="provider skills",
     *      example="carpentry"
     * )
     *
     * @var string
     */
    private $skills;
    /**
     * @OA\Property(
     *      title="phone_number",
     *      description="provider phone",
     *      example="0770*******"
     * )
     *
     * @var string
     */
    private $phone_number;
    /**
     * @OA\Property(
     *      title="photo",
     *      description="provider picture",
     *      example="photo"
     * )
     *
     * @var string
     */
    private $photo;
    /**
     * @OA\Property(
     *      title="models",
     *      description="models of his work",
     *      example="photo"
     * )
     *
     * @var string
     */
    private $models;

    use Rateable;
    protected $table = "providers";
    //public $timestamps = false;

    protected $fillable = [

        'name',
        'profession',
        'skills',
        'phone_number',
        'photo',
        'models'
    ];

    public function Replay()
    {
        return $this->hasMany(Replay::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
