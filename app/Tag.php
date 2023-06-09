<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['id'];

    // public function stories()
    // {
    //     return $this->belongsToMany(Story::class);
    // }
}
