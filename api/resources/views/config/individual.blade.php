@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <a class="col-xs-2" href="/config">
                <input type="button" class="btn btn-default" value="Back to Main"/>
            </a>
            <div class="col-xs-8" style="font-size: 200%;">
                {{ $main->name }}
            </div>
        </div>
        @if($type == 'mouse')
            <div class="row col-md-10 col-md-offset-1">
                <form method="POST" action="/config/mice/{{$main->id}}/update_wiki_url" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH">
                    <div class="form-group input-group">
                        <span class="input-group-addon">Wiki: http://mhwiki.hitgrab.com/wiki/index.php/</span>
                        <input type="text" class="form-control" name="wiki_url" value="{{$main->wiki_url}}" required />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </span>
                    </div>
                </form>
                <form method="POST" action="/config/mice/{{$main->id}}/update_ht_id" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH">
                    <div class="form-group input-group">
                        <span class="input-group-addon">HornTracker ID: http://horntracker.com/index.php?mouse=</span>
                        <input type="text" class="form-control" name="ht_id" value="{{$main->ht_id}}" required />
                        <span class="input-group-addon">|false</span>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </span>
                    </div>
                </form>
            </div>
        @endif

        <div class="row col-md-10 col-md-offset-1">
            <form method="POST" action="/config/setups/add">
                {{ csrf_field() }}
                <table class="table table-striped table-bordered">
                    <tr>
                        <th class="text-center">Mouse</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Stage</th>
                        <th class="text-center">Cheese</th>
                        <th></th>
                    </tr>
                    @foreach( $setups as $setup )
                        <tr>
                            <td><a href="/config/mice/{{$setup->mouse->id}}">{{$setup->mouse->name}}</a></td>
                            <td><a href="/config/locations/{{$setup->location->id}}">{{$setup->location->name}}</a></td>
                            <td>@if($setup->stage)<a href="/config/stages/{{$setup->stage->id}}">{{$setup->stage->name}}@endif</a></td>
                            <td><a href="/config/cheeses/{{$setup->cheese->id}}">{{$setup->cheese->name}}<a/></td>
                            <td><a href="/config/setups/remove/{{ $setup->id }}">
                                    <i class="glyphicon glyphicon-remove text-danger" style="font-size: 1.4em;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td>
                            <select class="form-control" name="mouse">
                                <option value="">Mouse</option>
                                @foreach($mice->sortBy('name') as $mouse)
                                    <option value="{{ $mouse->id }}"
                                        @if($type == 'mouse' && $main->id == $mouse->id) selected @endif
                                    >{{ $mouse->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="location">
                                <option value="">Location</option>
                                @foreach($locations->sortBy('name') as $location)
                                    <option value="{{ $location->id }}"
                                        @if($type == 'location' && $main->id == $location->id) selected @endif
                                    >{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="stage">
                                <option value="">Stage</option>
                                @foreach($stages->sortBy('name') as $stage)
                                    <option value="{{ $stage->id }}"
                                            @if($type == 'stage' && $main->id == $stage->id) selected @endif
                                    >{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="cheese">
                                <option value="">Cheese</option>
                                @foreach($cheeses->sortBy('name') as $cheese)
                                    <option value="{{ $cheese->id }}"
                                        @if(($type == 'cheese') && ($main->id == $cheese->id)) selected @endif
                                    >{{ $cheese->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="row col-md-offset-5 col-xs-2">
            <a href="/config"><input type="button" class="btn btn-default"
                                     value="Back to Main"/></a>
        </div>
    </div>
    <br/>

@stop
