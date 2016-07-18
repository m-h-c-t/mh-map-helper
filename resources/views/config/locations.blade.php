{{--Add New Location--}}
<form method="POST" action="/config/locations/add">
    {{ csrf_field() }}
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="form-group input-group">
                <span class="input-group-addon">New Location:</span>
                <input type="text" class="form-control" name="name" placeholder="Location Name..." required/>
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </span>
            </div>
        </div>
    </div>
</form>

{{--List All Locations--}}
<div class="container">
    <ul class="list-group col-lg-6 col-lg-offset-3">
        <a data-toggle="collapse" href="#locations"
           class="list-group-item active collapse-toggle collapsed">
            Current Locations
            <span class="badge pull-left">{{ count( $locations ) }}</span>
        </a>

        <div id="locations" class="collapse">
            @foreach( $locations as $location )
                <li class="list-group-item"><span class="pull-left">{{ $location->id }}</span>{{ $location->name }}
                    <a href="/config/locations/remove/{{ $location->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
</div>
