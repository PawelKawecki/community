<?php

namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommunityLink extends Model
{
    protected $fillable = [
        'title',
        'channel_id',
        'link'
    ];

    /**
     * Relation with User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation with Channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Relation with CommunityLinkVote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(CommunityLinkVote::class, 'community_link_id');
    }

    /**
     * Query scope - filters links by given channel
     *
     * @param Builder $query
     * @param Channel $channel
     *
     * @return mixed
     */
    public function scopeForChannel(Builder $query, Channel $channel)
    {
        if($channel->exists) {
            return $query->where('channel_id', $channel->id);
        }

        return $query;
    }

    /**
     * Method assign user with link.
     *
     * @param User $user
     *
     * @return static
     */
    public static function from(User $user)
    {
        $link = new static;

        $link->user_id = $user->id;

        if($user->isTrusted()) {
            $link->approve();
        }

        return $link;
    }

    /**
     * Contributes link to page.
     *
     * @param array $attributes
     * @param Controller $caller
     *
     * @return bool
     */
    public function contribute($attributes, $caller)
    {
        if(($existing = $this->alreadySubmitted($attributes['link']))) {
            $caller->linkAlreadySubmitted();
            return $existing->touch();
        }

        return $this->fill($attributes)->save();
    }

    /**
     * Make link approved.
     * Approved links are displayed on main page.
     *
     * @return $this
     */
    private function approve()
    {
        $this->approved = true;

        return $this;
    }

    /**
     * Determine if the link has already been submitted.
     *
     * @param string $link
     *
     * @return mixed
     */
    protected function alreadySubmitted($link)
    {
        return self::where('link', $link)->first();
    }
}
