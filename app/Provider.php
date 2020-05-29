<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
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
