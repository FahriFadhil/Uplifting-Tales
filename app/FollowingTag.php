<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowingTag extends Model
{
    protected $guarded = ['id'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
