<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    protected $table = "replays";

    protected $fillable = [

        'replay',


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
