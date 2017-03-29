<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function communityLinks()
    {
        return $this->hasMany(CommunityLink::class, 'user_id', 'id');
    }

    public function contributeLink($data)
    {
        if($this->isTrusthed()) {
            $data['approved'] = true;
        }

        $this->communityLinks()->create(
            $data
        );
    }

    public function isTrusthed()
    {
        return $this->approved;
    }
}
