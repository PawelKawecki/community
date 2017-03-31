<ul class="nav nav-tabs">
    <li class="{{ request()->has('popular') ? '' : 'active'}}"><a href="{{ request()->url() }}">Most recent</a></li>
    <li class="{{ request()->has('popular') ? 'active' : ''}}"><a href="{{ request()->url() . '?popular=1' }}">Most popular</a></li>
</ul>
<ul class="list-group">
    @foreach($links as $link)
        <li class="list-group-item">

            <form action="{{ url("votes/$link->id") }}" method="POST">
                {{ csrf_field() }}

                <button class="btn @if(Auth::check() && Auth::user()->votedFor($link)) btn-primary @endif @if(Auth::guest()) disabled @endif">
                    {{ $link->votes->count() }}
                </button>
            </form>

            <a href="{{ url('community/' . $link->channel->slug) }}" class="label label-default" style="background: {{ $link->channel->color }}">
                {{ $link->channel->title }}
            </a>

            &nbsp;

            <a href="{{ $link->link }}" target="_blank">
                {{ $link->title }}
            </a>

            <small>Contributed By: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>

        </li>

    @endforeach
</ul>

{{ $links->appends(request()->query())->links() }}