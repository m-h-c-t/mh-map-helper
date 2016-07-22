{{--Add New Cheese--}}
<div class="container well">
    <form method="POST" action="/config/cheeses/add">
        {{ csrf_field() }}

        <div class="col-md-6 no-left-padding">
            <div class="form-group input-group">
                <span class="input-group-addon">New Cheese:</span>
                <input type="text" class="form-control" name="name" placeholder="Cheese Name..." required/>
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </span>
            </div>
        </div>

    </form>

    {{--List All Cheeses--}}
    <ul class="list-group col-md-6">
        <a data-toggle="collapse" href="#cheeses"
           class="list-group-item active collapse-toggle collapsed">
            Current Cheeses
            <span class="badge pull-left">{{ count( $cheeses ) }}</span>
        </a>

        <div id="cheeses" class="collapse">
            @foreach( $cheeses as $cheese )
                <li class="list-group-item"><span class="pull-left">{{ $cheese->id }}</span>{{ $cheese->name }}
                    <a href="/config/cheeses/remove/{{ $cheese->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
</div>
