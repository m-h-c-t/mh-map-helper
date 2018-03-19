{{--Add New Setup--}}
<div class="container well">
    <H2>Setups</H2><br/>
    <form method="POST" action="/config/setups/add">
        {{ csrf_field() }}
        <div class="col-md-6 col-md-offset-3 no-left-padding">
            <div class="form-group input-group">
                <span class="input-group-addon">New Setup:</span>
                <select class="form-control" name="location">
                    <option value="">Location</option>
                    @foreach($locations->sortBy('name') as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
                <select class="form-control" name="stage">
                    <option value="">Stage</option>
                    @foreach($stages->sortBy('name') as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
                <select class="form-control" name="mouse">
                    <option value="">Mouse</option>
                    @foreach($mice->sortBy('name') as $mouse)
                        <option value="{{ $mouse->id }}">{{ $mouse->name }}</option>
                    @endforeach
                </select>
                <select class="form-control" name="cheese">
                    <option value="">Cheese</option>
                    @foreach($cheeses->sortBy('name') as $cheese)
                        <option value="{{ $cheese->id }}">{{ $cheese->name }}</option>
                    @endforeach
                </select>
                <span class="input-group-addon">
                    <button type="submit" class="btn btn-primary">Add</button>
                </span>
            </div>
        </div>
    </form>

    {{--List All Setups DISABLED--}}
	{{--
	<ul class="list-group col-md-8 col-md-offset-2">
        <a data-toggle="collapse" href="#setups"
           class="list-group-item active collapse-toggle collapsed">
            Current Setups
            <span class="badge pull-left">{{ count( $setups ) }}</span>
        </a>

        <div id="setups" class="collapse">
            @foreach( $setups as $setup )
                <li class="list-group-item"><span class="pull-left">{{ $setup->id }}</span>
                    {{ $setup->location->name }} @if($setup->stage)- {{ $setup->stage->name }} @endif -
                    {{ $setup->mouse->name }} -
                    {{ $setup->cheese->name }}
                    <a href="/config/setups/remove/{{ $setup->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
	--}}
</div>
