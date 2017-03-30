<?php

namespace App\Http\Controllers;

use App\CommunityLink;
use App\CommunityLinkVote;

class VotesController extends Controller
{


    private $message = 'Link has been voted';

    /**
     * VotesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Method stores user vote for given link
     *
     * @param CommunityLink $link
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommunityLink $link)
    {
        CommunityLinkVote::firstOrNew([
            'user_id'           => auth()->user()->id,
            'community_link_id' => $link->id,
        ])->toggleIt($this);


        return redirect('community')->with('message', $this->message);
    }

    /**
     * Changes returned message
     */
    public function setUnvotedMessage()
    {
        $this->message = 'Link has been unvoted';
    }
}
