<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
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
