<?php

namespace App;

use App\Http\Controllers\VotesController;
use Illuminate\Database\Eloquent\Model;

class CommunityLinkVote extends Model
{
    protected $fillable = [
        'user_id',
        'community_link_id'
    ];

    /**
     * Adds / removes vote for link
     *
     * @param VotesController $caller
     *
     * @return bool|null
     */
    public function toggleIt($caller)
    {
        if ($this->exists) {
            $this->delete();
            $caller->setUnvotedMessage();

        } else {
            $this->save();
        }

    }
}
