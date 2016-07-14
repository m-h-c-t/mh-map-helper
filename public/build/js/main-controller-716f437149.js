var app = angular.module('mainapp', []);
app.controller('MainController', ['$scope', '$http', function($scope, $http) {
    $scope.micelist = [];
    $scope.search_results = [];
    $scope.first_load = true;
    $scope.mice_found = 0;
    // Get locations and cheese for each mouse
    $scope.search = function() {
        $('#custom_loader').show();
        $scope.search_results = [];
        $scope.mice_not_found = [];
        $scope.mice_found = 0;

        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.get("search", {
            params: {
                mice: JSON.stringify($scope.micelist),
            }
        }).success(function(response) {
            console.log(response);
            var structured_locations = {};
            // build location objects from mice objects in response
            angular.forEach(response, function(mouse) {
                if (mouse.is_valid) {
                    $scope.mice_found++;
                    angular.forEach(mouse.locations, function(location, location_id) {
                        if (!structured_locations.hasOwnProperty(location.name)) {
                            structured_locations[location.name] = {};
                            structured_locations[location.name].mice = {};
                            structured_locations[location.name].stages ={};
                        }
                        if (!structured_locations[location.name].stages.hasOwnProperty(location.stage)) {
                            structured_locations[location.name].stages[location.stage] = {};
                            structured_locations[location.name].stages[location.stage].mice = [];
                            structured_locations[location.name].stages[location.stage].size = 0;
                            structured_locations[location.name].stages[location.stage].id = location_id;
                        }
                        structured_locations[location.name].name = location.name;

                        var cheeses = [];
                        angular.forEach(mouse.cheeses, function(cheese) {
                            cheeses.push(cheese);
                        });
                        structured_locations[location.name].stages[location.stage].mice.push({
                            name: mouse.name,
                            mouse_wiki_url: mouse.mouse_wiki_url,
                            cheeses: cheeses
                        });

                        structured_locations[location.name].mice[mouse.name] = true;
                        structured_locations[location.name].size = Object.keys(structured_locations[location.name].mice).length;
                    });
                } else if (mouse.name != '') {
                    $scope.mice_not_found.push({
                        name: mouse.name
                    });
                }
            });

            // populate $scope.search_results grouped by location
            angular.forEach(structured_locations, function(location) {
                $scope.search_results.push(location);
            });

            $('#custom_loader').fadeOut('slow');
            $scope.first_load = false;
        })
        .error(function(response) {
            alert("Failed to reach server, please try again later.");
            console.log(response);
        });
    };
    // Reset everything
    $scope.reset = function() {
        $scope.micelist = [];
        $scope.search_results = [];
        $scope.first_load = true;
        $scope.mice_not_found = [];
        $scope.mice_found = 0;
    };
    // Remove a mouse from list
    $scope.remove_a_mouse = function(mouse_name) {
        angular.forEach($scope.search_results, function(location) {
            var reduce_location = false;
            angular.forEach(location.stages, function(stage, stage_name) {
                angular.forEach(stage.mice, function(mouse, key) {
                    if (mouse.name === mouse_name) {
                        stage.mice.splice(key, 1);
                        reduce_location = true;
                    }
                });
            });
            if (reduce_location) location.size--;
        });
        $scope.mice_found--;
    };
    $scope.toggle_stage = function(id) {
        $('#stage' + id).toggleClass("hide_class", 0);
    };
}]);

//# sourceMappingURL=main-controller.js.map
