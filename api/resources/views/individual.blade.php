@extends('layout')

@section('content')

    <div class="container">

        <h3>@if($main->location) {{ $main->location->name }} - @endif
            {{ $main->name }} @if($main->stage) - {{ $main->stage->name }} @endif<br/>
            @if($main->wiki_url)
                <small>Wiki: <a href="{{$main->wiki_url}}">{{$main->wiki_url}}</a></small>
            @endif
        </h3>
        <div class="row col-md-10 col-md-offset-1">
            <table class="table table-striped table-bordered">
                <tr>
                    <th class="text-center">Mouse</th>
                    <th class="text-center">Location - Stage</th>
                    <th class="text-center">Cheese</th>
                </tr>
                @foreach( $setups as $setup )
                    <tr>
                        <td><a href="/mice/{{$setup->mouse->id}}">{{$setup->mouse->name}}</a></td>
                        <td><a href="/locations/{{$setup->location->id}}">{{$setup->location->name}} @if($setup->location->stage) - {{$setup->location->stage->name}}@endif</a></td>
                        <td><a href="/cheeses/{{$setup->cheese->id}}">{{$setup->cheese->name}}<a/></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row col-md-offset-5 col-xs-2">
            <a href="/config"><input type="button" class="btn btn-default"
                                                                 value="Back to Main"/></a>
        </div>
    </div>
    <br/>

@stop
