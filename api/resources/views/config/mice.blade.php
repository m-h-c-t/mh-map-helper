{{--Add New Mouse--}}
<div class="container well">
    <form method="POST" action="/config/mice/add">
        {{ csrf_field() }}
        <div class="col-md-6 no-left-padding">
            <div class="form-group input-group">
                <span class="input-group-addon">New Mouse:</span>
                <input type="text" class="form-control" name="name" placeholder="Mouse Name..." required/>
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </span>
            </div>
        </div>
    </form>

    {{--List All Mice--}}
    <ul class="list-group col-md-6">
        <a data-toggle="collapse" href="#mice"
           class="list-group-item active collapse-toggle collapsed">
            Current Mice
            <span class="badge pull-left">{{ count( $mice ) }}</span>
        </a>

        <div id="mice" class="collapse">
            @foreach( $mice->sortBy('name') as $mouse )
                <li class="list-group-item"><span class="pull-left">{{ $mouse->id }}</span><a href="mice/{{ $mouse->id }}">{{ $mouse->name }}</a>
                    <a href="/config/mice/remove/{{ $mouse->id }}">
                        <i class="pull-right glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                    </a>
                </li>
            @endforeach
        </div>
    </ul>

    <a href="/config/mice/update_wiki_urls"><input type="button" value="Add All Missing Mouse Wiki URLs"
                                                   class="btn btn-primary"/></a>
</div>
