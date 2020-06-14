<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
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
     *      description="name of the new user",
     *      example="sara"
     * )
     *
     * @var string
     */
    private $name;
     /**
     * @OA\Property(
     *      title="role",
     *      description="role of the new user",
     *      example="admin"
     * )
     *
     * @var string
     */
    private $role;
    /**
     * @OA\Property(
     *      title="phone",
     *      description="phone of the new user",
     *      example="07707722504"
     * )
     *
     * @var string
     */
    private $phone;
    /**
     * @OA\Property(
     *      title="password",
     *      description="Password of the new user",
     *      example="sara1234"
     * )
     *
     * @var string
     */
    private $password;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'user';
    protected $fillable = [
        'name', 'phone', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Item()
    {
        return $this->hasMany(Item::class);
    }

    public function Provider()
    {
        return $this->hasMany(Provider::class);
    }

    public function identities() {
        return $this->hasMany(SocialIdentity::class);
    }

    public function getGuard()
    {
        return $this->guard;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
