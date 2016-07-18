@extends('main')


@section('search-results')
    {{--Valid Mice--}}
    @if( !empty( $setups ) )
        <h2><i class="glyphicon glyphicon-globe"></i> Locations</h2>
        <span class="gray">( Sorted by number of mice per location ) ( Mice found: {{ $valid_mice_count }}
            @if( !empty( $invalid_mice ) ) - Mice not found: {{ count($invalid_mice) }} @endif )</span>
        <div class="container well" id="main-search-results">
            {{--Locations--}}
            @foreach( $setups as $location_name => $location )
                <div class="list-group col-sm-6 col-md-4 location">
                    {{--Location Name--}}
                    <a data-toggle="collapse" href="#location{{ $location['id'] }}"
                       class="text-capitalize list-group-item active collapse-toggle collapsed"
                       data-parent="#main-search-results">
                        {{ $location_name }}
                        <span class="badge pull-left">{{ count( $location['mice_count'] ) }} @if(count( $location['mice_count']) > 1 ) Mice @else Mouse @endif</span>
                    </a>

                    <div id="location{{$location['id']}}" class="collapse">
                        {{--Stages--}}
                        @foreach( $location['stages'] as $stage_name => $stage )

                            <div class="list-group stage">
                                @if( $stage_name != '' )
                                    <a href="#stage-search-results{{ $stage['id'] }}" class="list-group-item stage-name collapse-toggle-two collapsed"
                                       data-toggle="collapse" data-parent="#stage-search-results{{ $stage['id'] }}">
                                        {{ $stage_name }}
                                        <span class="badge pull-left">{{ count( $stage['mice'] ) }} @if(count( $stage['mice']) > 1 ) Mice @else Mouse @endif</span>
                                    </a>
                                    <div class="collapse list-group-submenu" id="stage-search-results{{ $stage['id'] }}">
                                        @endif

                                        {{--Mice--}}
                                        @foreach( $stage['mice'] as $mouse)
                                            <div class="list-group-item" data-parent="#stage-search-results{{ $stage['id'] }}">
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
                                        @if( $stage_name != '' )
                                    </div>
                                @endif
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
                <a data-toggle="collapse" href="#invalid_mice" id="invalid_mice_title"
                   class="text-capitalize list-group-item collapse-toggle collapsed">
                    Could not find {{ count($invalid_mice) }} @if( count($invalid_mice) > 1) mice @else mouse @endif
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

