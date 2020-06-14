<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="SocialIdentity",
 *     description="SocialIdentity model",
 *     @OA\Xml(
 *         name="SocialIdentity"
 *     )
 * )
 */
class SocialIdentity extends Model
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
     *      title="user_id",
     *      description="user_id",
     *      example=1
     * )
     *
     * @var integer
     */
    private $user_id;
    /**
     * @OA\Property(
     *      title="provider_name",
     *      description="provider_name",
     *      example="facebook"
     * )
     *
     * @var string
     */
    private $provider_name;
    /**
     * @OA\Property(
     *      title="provider_id",
     *      description="provider_id",
     *      example=1
     * )
     *
     * @var integer
     */
    private $provider_id;

    protected $fillable = ['user_id', 'provider_name', 'provider_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
