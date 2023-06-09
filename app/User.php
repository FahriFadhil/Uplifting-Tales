<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
  
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers()
    {
        return $this->hasMany(Follower::class);
    }
    public function followings()
    {
        return $this->hasMany(Following::class);
    }
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
    public function following_tags()
    {
        return $this->hasMany(FollowingTag::class);
    }

    // public function stories()
    // {
    //     return $this->belongsToMany(Story::class);
    // }
}
