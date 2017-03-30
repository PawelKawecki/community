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

    /**
     * Relation with CommunityLink
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communityLinks()
    {
        return $this->hasMany(CommunityLink::class, 'user_id', 'id');
    }

    /**
     * Relation with CommunityLink
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(CommunityLink::class, 'community_link_votes')->withTimestamps();
    }

    /**
     * Checks if user voted for a given linl
     *
     * @param CommunityLink $link
     *
     * @return mixed
     */
    public function votedFor(CommunityLink $link)
    {
        return $link->votes->contains('user_id', $this->id);
    }

    /**
     * Determine if user is trusted
     *
     * @return mixed
     */
    public function isTrusted()
    {
        return $this->approved;
    }
}
