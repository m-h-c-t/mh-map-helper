var app = angular.module('mainapp', []);
app.controller('MainController', ['$scope', '$http', function ($scope, $http) {
    $scope.mice_list = [];
    $scope.invalid_mice = [];
    $scope.setups = {};
    $scope.setups.locations = {};
    $scope.setups.mice_count = [];
    $scope.setups.mice_count_number = 0;

    if (Cookies.get('mice') != null) {
        var cookie_mice = JSON.parse(Cookies.get('mice'));
    }

    // Get locations and cheese for each mouse
    $scope.search = function () {
        $('#custom_loader').show();
        $scope.invalid_mice = [];
        $scope.setups = {};
        $scope.setups.locations = {};
        $scope.setups.mice_count = {};
        $scope.setups.mice_count_number = 0;

        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.get("http://api." + window.location.hostname + "/search", {
            params: {
                mice: JSON.stringify($scope.mice_list),
            }
        }).success(function (response) {
            $scope.invalid_mice = response.invalid_mice;
            cookie_mice = [];

            // Build structured array and dedup everything by grouping
            angular.forEach(response.valid_mice, function (mouse) {
                cookie_mice.push(mouse.name);

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
                    if (setup.location.stage != null) {
                        stage_name = setup.location.stage.name;
                        stage_id = setup.location.stage.id;
                        stage_order = setup.location.stage.order;
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

                    // Add cheese
                    if (!(setup.cheese.id in $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses)) {
                        $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id] = {};
                    }
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id].id = setup.cheese.id;
                    $scope.setups.locations[setup.location.name].stages[stage_id].mice[setup.mouse.id].cheeses[setup.cheese.id].name = setup.cheese.name;

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

            Cookies.set('mice', JSON.stringify(cookie_mice), { expires: 30 });
            $('#custom_loader').fadeOut('slow');
        });
    };


    if (cookie_mice != null && cookie_mice.length) {
        $scope.mice_list = cookie_mice;
        $scope.search();
    }

    // Reset everything
    $scope.reset = function () {
        $scope.mice_list = [];
        $scope.invalid_mice = [];
        $scope.setups = {};
        cookie_mice = '';
        Cookies.remove('mice');
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

            // Update cookie
            cookie_mice = JSON.parse(Cookies.get('mice'));
            angular.forEach(cookie_mice, function (cookie_mouse_name, index) {
                if (remove_mouse_name == cookie_mouse_name) {
                    cookie_mice.splice(index, 1);
                }
            });
            Cookies.set('mice', JSON.stringify(cookie_mice), { expires: 30 });
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

// Search Results
app.directive('searchResults', function () {
    return {
        restrict: 'E',
        templateUrl: 'search-results.html'
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
