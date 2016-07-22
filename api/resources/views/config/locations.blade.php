{{--Add New Location--}}
<div class="container well">
    <form method="POST" action="/config/locations/add">
        {{ csrf_field() }}
        <div class="col-md-6 no-left-padding">
            <div class="form-group input-group">
                <span class="input-group-addon">New Location:</span>
                <input type="text" class="form-control" name="name" placeholder="Location Name..." required/>
                <select class="form-control" name="stage_id">
                    <option value="">No Stage</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </span>
            </div>
        </div>
    </form>

    {{--List All Locations--}}
    <ul class="list-group col-md-6">
        <a data-toggle="collapse" href="#locations"
           class="list-group-item active collapse-toggle collapsed">
            Current Locations
            <span class="badge pull-left">{{ count( $locations ) }}</span>
        </a>

        <div id="locations" class="collapse">
            @foreach( $locations as $location )
                <li class="list-group-item"><span class="pull-left">{{ $location->id }}</span>
                    {{ $location->name }} @if($location->stage) - {{ $location->stage->name }} @endif
                    <a href="/config/locations/remove/{{ $location->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
</div>
