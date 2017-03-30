<?php

namespace App\Http\Controllers;

use App\Channel;
use App\CommunityLink;
use Illuminate\Http\Request;

class CommunityLinksController extends Controller
{

    private $message = 'Link has been contributed';

    public function index(Channel $channel)
    {
        $links = CommunityLink::with('votes')->forChannel($channel)->where('approved', 1)->latest('updated_at')->paginate(10);

        $channels = Channel::orderBy('title', 'ASC')->get();

        return view('community.index', compact('links', 'channels', 'channel'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      => 'required',
            'link'       => 'required|url',
            'channel_id' => 'required|exists:channels,id',
        ]);

        CommunityLink::from(
            auth()->user()
        )->contribute(
            $request->all(), $this
        );

        return redirect('community')->with('message', $this->message);
    }

    public function linkAlreadySubmitted()
    {
        $this->message = 'Link has been already submitted. Link pushed to top of a list';
    }
}
