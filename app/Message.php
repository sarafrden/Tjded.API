<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Message",
 *     description="Message model",
 *     @OA\Xml(
 *         name="Message"
 *     )
 * )
 */
class Message extends Model
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
     *      title="message",
     *      description="chat to ask for design",
     *      example="hello"
     * )
     *
     * @var string
     */
    private $message;


    protected $fillable = ['message'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
