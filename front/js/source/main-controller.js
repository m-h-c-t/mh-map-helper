(function() {
var app = angular.module('mainapp', ['ngRoute']);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
   $routeProvider
       .when('/', {})
       .when("/mice/:mice", {
           templateUrl: 'search-results.html'
       })
       .otherwise({ redirectTo: '/' });

    $locationProvider.html5Mode(true);
}]);

app.controller('MainController', ['$scope', '$http', '$location', '$route', function ($scope, $http, $location, $route) {
    $scope.mice_list = {text: []};
    $scope.invalid_mice = [];
    $scope.setups = {};
    $scope.setups.locations = {};
    $scope.setups.mice_count = [];
    $scope.setups.mice_count_number = 0;

    // Get locations and cheese for each mouse
    $scope.search = function () {
        $('#custom_loader:hidden').show();
        $scope.invalid_mice = [];
        $scope.setups = {};
        $scope.setups.locations = {};
        $scope.setups.mice_count = {};
        $scope.setups.mice_count_number = 0;

        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.get("https://api." + window.location.hostname + "/search", {
            params: {
                mice: JSON.stringify($scope.mice_list.text),
            }
        }).success(function (response) {
            $scope.invalid_mice = response.invalid_mice;

            // Build structured array and dedup everything by grouping
            angular.forEach(response.valid_mice, function (mouse) {

                angular.forEach(mouse.setups, function (setup) {

                    // Add location
                    // Using location name as index instead of id because we have different location ids for different stages
                    if (!(setup.location.name in $scope.setups.locations)) {
                        $scope.setups.locations[setup.location.name] = {};
                        $scope.setups.locations[setup.location.name].stages = {};
                        $scope.setups.locations[setup.location.name].mice_count = {};
                    }
                    $scope.setups.locations[setup.location.name].id = setup.location.id;
                    $scope.setups.locations[setup.location.name].name = setup.location.name;

                    // Add stage
                    var stage_name = '';
                    var stage_id = '';
                    var stage_order = '';
                    if (setup.stage != null) {
                        stage_name = setup.stage.name;
                        stage_id = setup.stage.id;
                        stage_order = setup.stage.order;
                    }

                    if (!(stage_id in $scope.setups.locations[setup.location.name].stages)) {
                        $scope.setups.locations[setup.location.name].stages[stage_id] = {};
                        $scope.setups.locations[setup.location.name].stages[stage_id].mice = {};
                        $scope.setups.locations[setup.location.name].stages[stage_id].mice_count = {};
                    }
                    $scope.setups.locations[setup.location.name].stages[stage_id].id = stage_id;
                    $scope.setups.locations[setup.location.name].stages[stage_id].name = stage_name;
                    $scope.setups.locations[setup.location.name].stages[stage_id].order = stage_order;

                    // Add mouse
                    if (!(setup.mouse.id in $scope.setups.locations[setup.location.name].stages[stage_id].mice)) {
                        $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id] = {};
                        $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses = {};
                    }
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].id = setup.mouse.id;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].name = setup.mouse.name;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].wiki_url = setup.mouse.wiki_url;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].ht_id = setup.mouse.ht_id;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].mhhh_id = setup.mouse.mhhh_id;

                    // Add cheese
                    if (!(setup.cheese.id in $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses)) {
                        $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id] = {};
                    }
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id].id = setup.cheese.id;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id].name = setup.cheese.name;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id].ar = setup.ar;

                    // Mice counts
                    $scope.setups.mice_count[setup.mouse.id] = true;
                    $scope.setups.mice_count_number = Object.keys($scope.setups.mice_count).length;
                    $scope.setups.locations[setup.location.name].mice_count[setup.mouse.id] = true;
                    $scope.setups.locations[setup.location.name].mice_count_number = Object.keys($scope.setups.locations[setup.location.name].mice_count).length;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice_count[setup.mouse.id] = true;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice_count_number = Object.keys($scope.setups.locations[setup.location.name].stages[stage_id].mice_count).length;
                });
            });

            // Converting to arrays for easy sorting
            // Not doing this right away to dedup first
            var temp_locations = $scope.setups.locations;
            $scope.setups.locations = [];
            angular.forEach(temp_locations, function (location) {
                var temp_stages = location.stages;
                location.stages = [];
                angular.forEach(temp_stages, function (stage) {
                    var temp_mice = stage.mice;
                    stage.mice = [];
                    angular.forEach(temp_mice, function (mouse) {
                        var temp_cheeses = mouse.cheeses;
                        mouse.cheeses = [];
                        angular.forEach(temp_cheeses, function (cheese) {
                            mouse.cheeses.push(cheese);
                        });
                        stage.mice.push(mouse);
                    });
                    location.stages.push(stage);
                });
                $scope.setups.locations.push(location);
            });

            $('#custom_loader').fadeOut('slow');
        });
    };


    // check if mice exist in url, and if they do, search for them
    $scope.$on('$routeChangeSuccess', function () {
        // $route.current.params should be populated here
        $scope.mice_list = {text: []};

        if ($location.path().match('^/mice/')
            && $route.current.params.mice != null && $route.current.params.mice.length) {
            $scope.mice_list = {text: $route.current.params.mice.split('+')};
            $scope.search();
        }
        else {
            $('#custom_loader').fadeOut('slow');
        }
    });

    // store searched mice in the url
    $scope.form_submit = function() {
        $location.path("/mice/" + $scope.mice_list.text.join('+'));
    };

    // Reset everything
    $scope.reset = function () {
        $location.path("/");
    };

    // Remove a mouse from list
    $scope.remove_a_mouse = function (mouse_id) {
        var removed_mouse = false;
        var remove_mouse_name = '';
        angular.forEach($scope.setups.locations, function (location) {
            var removed_location_mouse = false;
            angular.forEach(location.stages, function (stage) {
                var removed_stage_mouse = false;
                angular.forEach(stage.mice, function (mouse, index) {
                    if (mouse.id === mouse_id) {
                        remove_mouse_name = stage.mice[index].name;
                        stage.mice.splice(index, 1);
                        removed_mouse = true;
                        removed_location_mouse = true;
                        removed_stage_mouse = true;
                    }
                });
                if (removed_stage_mouse) stage.mice_count_number--;
            });
            if (removed_location_mouse) location.mice_count_number--;
        });

        if (removed_mouse) {
            $scope.setups.mice_count_number--;
            remove_mouse_name = remove_mouse_name.toUpperCase();

            // Update textarea
            var temp_mice_list = $scope.mice_list.text;
            $scope.mice_list = {text: []};
            angular.forEach(temp_mice_list, function (text_mouse_name, index) {
                if (remove_mouse_name !== text_mouse_name.toUpperCase()) {
                    $scope.mice_list.text.push(text_mouse_name);
                }
            });

            // Redirect disabled for now because it collapses all, and loading animation
            // $location.path("/mice/" + $scope.mice_list.text.join('+'));
        }
    };

}]);

// Input form
app.directive('miceListForm', function () {
    return {
        restrict: 'E',
        templateUrl: 'mice-list-form.html'
    };
});

// Footer
app.directive('customFooter', function () {
    return {
        restrict: 'E',
        templateUrl: 'custom-footer.html'
    };
});

// Header
app.directive('customHeader', function () {
    return {
        restrict: 'E',
        templateUrl: 'custom-header.html'
    };
});

})();
