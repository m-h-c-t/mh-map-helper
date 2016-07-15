@extends('main')


@section('search-results')
    {{--Valid Mice--}}
    @if( !empty( $setups ) )
        <h2><i class="glyphicon glyphicon-globe"></i> Locations</h2>
        <span class="gray">( Mice found: {{ $valid_mice_count }} - Mice not found: {{ count($invalid_mice) }} )</span>
        <div class="container well">
            {{--Locations--}}
            @foreach( $setups as $location_name => $location )
                <div class="list-group col-sm-6 col-md-4 location">
                    {{--Location Name--}}
                    <a data-toggle="collapse" href="#location{{ $location['id'] }}"
                       class="text-capitalize list-group-item active">
                        {{ $location_name }}
                        <span class="badge pull-left">{{ count( $location['mice_count'] ) }}</span>
                        <i class="pull-right glyphicon glyphicon-chevron-down"></i>
                    </a>

                    <div id="location{{$location['id']}}" class="collapse">
                        {{--Stages--}}
                        @foreach( $location['stages'] as $stage_name => $stage )

                            <div class="list-group stage">
                                @if( $stage_name != '' )
                                    <div class="stage-name">
                                        {{ $stage_name }}
                                    </div>
                                @endif

                                {{--Mice--}}
                                @foreach( $stage['mice'] as $mouse)
                                    <div class="list-group-item">
                                        <div class="row">

                                            <div class="text-capitalize col-sm-6 text-left">
                                                <div>
                                                    <a href="{{ $mouse['link'] }}" target="_blank">
                                                        {{ $mouse['name'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Cheese list -->
                                            <ul class="col-sm-6 list-group list-unstyled cheese">
                                                @foreach( $mouse['cheese'] as $cheese)
                                                    <li class="text-capitalize small list-group-item-warning">
                                                        <small>{{ $cheese }}</small>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{--Invalid Mice--}}
    @if ( !empty( $invalid_mice ) )
        <div class="container">
            <ul class="list-group col-sm-6 col-sm-offset-3" style="padding:0">
                <a data-toggle="collapse" href="#invalid_mice"
                   class="text-capitalize list-group-item">
                    Could not find {{ count($invalid_mice) }} @if( count($invalid_mice) > 1) mice @else mouse @endif
                    <i class="pull-right glyphicon glyphicon-chevron-down"></i>
                </a>
                <div class="collapse" id="invalid_mice">
                    @foreach ( $invalid_mice as $mouse_name )
                        <li class="list-group-item">{{ $mouse_name }}</li>
                    @endforeach
                </div>
            </ul>
        </div>
    @endif
@stop

