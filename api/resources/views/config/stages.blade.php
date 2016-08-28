{{--Add New Stage--}}
<div class="container well">
    <form method="POST" action="/config/stages/add">
        {{ csrf_field() }}

        <div class="col-md-6 no-left-padding">
            <div class="form-group input-group">
                <span class="input-group-addon">New Stage:</span>
                <input type="text" class="form-control" name="name" placeholder="Stage Name..." required />
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </span>
            </div>
        </div>
    </form>

    {{--List All Stages--}}

    <ul class="list-group col-md-6">
        <a data-toggle="collapse" href="#stages"
           class="list-group-item active collapse-toggle collapsed">
            Current Stages
            <span class="badge pull-left">{{ count( $stages ) }}</span>
        </a>

        <div id="stages" class="collapse">
            @foreach( $stages->sortBy('name') as $stage )
                <li class="list-group-item"><span class="pull-left">{{ $stage->id }}</span><a href="stages/{{ $stage->id }}">{{ $stage->name }}</a>
                    <a href="/config/stages/remove/{{ $stage->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>
</div>
