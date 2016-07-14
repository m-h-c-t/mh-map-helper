<!-- Locations (with mice and cheese) -->
<div class="container well" ng-show="mice_found">
    <h2 style="margin-top:0;margin-bottom:1em;"><i class="glyphicon glyphicon-globe"></i> Locations</h2>
    <div ng-repeat="location in search_results | orderBy:['-size', 'name']" ng-show="location.size">
        <div style="padding:0px 7px;" class="list-group col-sm-4" ng-init="is_collapsed = true">
            <!-- Location Title -->
            <a data-toggle="collapse" ng-click="is_collapsed = !is_collapsed" href="#location{{$id}}" class="text-capitalize list-group-item active">
                {{location.name | lowercase}}
                <span class="badge pull-left">{{location.size}} {{location.size === 1 ? "mouse" : "mice"}}</span>
                <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': is_collapsed, 'glyphicon-chevron-up': !is_collapsed}"></i>
            </a>
            <!-- Mice dropdown -->
            <div id="location{{$id}}" class="collapse">
                <!-- Stages -->
                <div ng-repeat="(stage_name, stage) in location.stages | orderBy: stage_name" ng-init="stage_collapsed = true">
                    <!-- Mice With Stages -->
                    <a href="" class="list-group-item text-capitalize" style="background-color:lightgray" ng-if="stage_name && stage.mice.length" ng-click="toggle_stage(stage.id);stage_collapsed=!stage_collapsed">
                        <span class="badge pull-left">{{stage.mice.length}} {{stage.mice.length === 1 ? "mouse" : "mice"}}</span>
                        {{stage_name | lowercase}}
                        <i class="pull-right glyphicon" ng-class="{'glyphicon-plus': stage_collapsed, 'glyphicon-minus': !stage_collapsed}"></i>
                    </a>
                    <div name='wrapper_for_hiding' id="stage{{stage.id}}" class="hide_class" ng-if="stage_name && stage.mice.length">
                        <div class="list-group-item" ng-repeat="mouse in stage.mice | orderBy: 'name'" >
                            <div class="row">
                                <div class="text-capitalize col-sm-6 text-left">
                                    <table>
                                        <tr>
                                            <td>
                                                <i class="glyphicon glyphicon-remove pull-left clickable large-gray" ng-click="remove_a_mouse(mouse.name)"></i>&nbsp;
                                            </td>
                                            <td>
                                                <a href="{{mouse.mouse_wiki_url}}" target="_blank">{{mouse.name | lowercase}}</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- Cheese list -->
                                <ul class="col-sm-6 list-group list-unstyled" style="margin-bottom:0;">
                                    <li class="text-capitalize small list-group-item-warning" ng-repeat="cheese in mouse.cheeses | orderBy">
                                        <small>{{cheese | lowercase}}</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Mice Without Stages-->
                    <div class="list-group-item" ng-repeat="mouse in stage.mice | orderBy: 'name'" ng-if="!stage_name">
                        <div class="row">
                            <div class="text-capitalize col-sm-6 text-left">
                                <div style="float:left">
                                    <i class="glyphicon glyphicon-remove pull-left clickable large-gray" ng-click="remove_a_mouse(mouse.name)"></i>
                                    &nbsp;
                                </div>
                                <div><a href="{{mouse.mouse_wiki_url}}" target="_blank">{{mouse.name | lowercase}}</a></div>
                            </div>
                            <!-- Cheese list -->
                            <ul class="col-sm-6 list-group list-unstyled" style="margin-bottom:0;">
                                <li class="text-capitalize small list-group-item-warning" ng-repeat="cheese in mouse.cheeses | orderBy">
                                    <small>{{cheese | lowercase}}</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br ng-if="($index+1)%3==0" style="clear:both" />
    </div>
    <p class="col-xs-12 text-muted">(Sorted by number of mice) ({{mice_found}} {{mice_found === 1 ? "mouse" : "mice"}} found)</p>
</div>
<!-- Mice not found -->
<ul class="list-group container" ng-show="mice_not_found.length" style="padding:0">
    <li class="list-group-item list-group-item-danger"><strong>Could not find the following mice:</strong></li>
    <li class="list-group-item"ng-repeat="mouse in mice_not_found">{{mouse.name}}</li>
</ul>
