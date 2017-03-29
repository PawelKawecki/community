<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityLink extends Model
{
    protected $fillable = [
        'title',
        'channel_id',
        'link'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeForChannel($query, Channel $channel)
    {
        if($channel->exists) {
            return $query->where('channel_id', $channel->id);
        }

        return $query;
    }
}
