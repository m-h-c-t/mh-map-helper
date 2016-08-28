{{--Add New Setup--}}
<div class="container well">
    <form method="POST" action="/config/setups/add">
        {{ csrf_field() }}
        <div class="col-md-6 col-md-offset-3 no-left-padding">
            <div class="form-group input-group">
                <span class="input-group-addon">New Setup:</span>
                <select class="form-control" name="location">
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }} @if($location->stage)
                                - {{ $location->stage->name }} @endif</option>
                    @endforeach
                </select>
                <select class="form-control" name="mouse">
                    @foreach($mice as $mouse)
                        <option value="{{ $mouse->id }}">{{ $mouse->name }}</option>
                    @endforeach
                </select>
                <select class="form-control" name="cheese">
                    @foreach($cheeses as $cheese)
                        <option value="{{ $cheese->id }}">{{ $cheese->name }}</option>
                    @endforeach
                </select>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Add</button>
                </span>
            </div>
        </div>
    </form>

    {{--List All Setups--}}
    <ul class="list-group col-md-8 col-md-offset-2">
        <a data-toggle="collapse" href="#setups"
           class="list-group-item active collapse-toggle collapsed">
            Current Setups
            <span class="badge pull-left">{{ count( $setups ) }}</span>
        </a>

        <div id="setups" class="collapse">
            @foreach( $setups as $setup )
                <li class="list-group-item"><span class="pull-left">{{ $setup->id }}</span>
                    {{ $setup->location->name }} @if($setup->location->stage)- {{ $setup->location->stage->name }} @endif -
                    {{ $setup->mouse->name }} -
                    {{ $setup->cheese->name }}
                    <a href="/config/setups/remove/{{ $setup->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
</div>
