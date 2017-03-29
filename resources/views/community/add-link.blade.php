@if(Auth::check())
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Contribute a link</h2>
        </div>
        <div class="panel-body">
            <form action="{{ url('community') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <select name="channel_id" id="" class="form-control">
                        <option value="null">Pick a channel</option>
                        @foreach($channels as $channel)
                            <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{ $channel->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="title" class="form-control" placeholder="Title here" value="{{ old('title', null) }}">
                </div>

                <div class="form-group">
                    <input type="text" name="link" class="form-control" placeholder="URL here" value="{{ old('link', null) }}">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Contribute Link">
                </div>
            </form>
        </div>
    </div>
</div>
@endif