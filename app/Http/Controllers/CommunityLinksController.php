<?php

namespace App\Http\Controllers;

use App\Channel;
use App\CommunityLink;
use Illuminate\Http\Request;

class CommunityLinksController extends Controller
{

    public function index(Channel $channel)
    {
        $links = CommunityLink::forChannel($channel)->where('approved', 1)->paginate(5);

        $channels = Channel::orderBy('title', 'ASC')->get();

        return view('community.index', compact('links', 'channels'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      => 'required',
            'link'       => 'required|url|unique:community_links',
            'channel_id' => 'required|exists:channels,id',
        ]);

        auth()->user()->contributeLink($request->all());

        return redirect('community')->with('message', 'Link has been contributed');
    }
}
