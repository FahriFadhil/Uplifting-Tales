<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
