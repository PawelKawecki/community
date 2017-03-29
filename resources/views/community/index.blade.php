@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3><a href="{{ url('community') }}">Community</a></h3>

                <ul class="list-group">
                    @foreach($links as $link)
                        <li class="list-group-item">
                            <a href="{{ url('community/' . $link->channel->title) }}" class="label label-default" style="background: {{ $link->channel->color }}">
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

                {{ $links->links() }}
            </div>

           @include('community.add-link')

        </div>
    </div>

@stop