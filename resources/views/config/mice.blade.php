{{--Add New Mouse--}}
<form method="POST" action="/config/mice/add">
    {{ csrf_field() }}
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="form-group input-group">
                <span class="input-group-addon">New Mouse:</span>
                <input type="text" class="form-control" name="name" placeholder="Mouse Name..." required/>
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </span>
            </div>
        </div>
    </div>
</form>

{{--List All Mice--}}
<div class="container">
    <ul class="list-group col-lg-6 col-lg-offset-3">
        <a data-toggle="collapse" href="#mice"
           class="list-group-item active collapse-toggle collapsed">
            Current Mice
            <span class="badge pull-left">{{ count( $mice ) }}</span>
        </a>

        <div id="mice" class="collapse">
            @foreach( $mice as $mouse )
                <li class="list-group-item"><span class="pull-left">{{ $mouse->id }}</span>{{ $mouse->name }}
                    <a href="/config/mice/remove/{{ $mouse->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
</div>
