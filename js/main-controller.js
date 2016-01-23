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
        $http.get("api.php", {
            params: {
                action: 'get_mice_info',
                mice: JSON.stringify($scope.micelist),
            }
        }).success(function(response) {
            // populate $scope.search_results grouped by location
            angular.forEach(response, function(mouse) {
                if (mouse.is_valid) {
                    $scope.mice_found++;
                    angular.forEach(mouse.locations, function(location, location_id) {
                        if (!$scope.search_results.hasOwnProperty(location_id)) {
                            $scope.search_results[location_id] = {};
                            $scope.search_results[location_id].mice = [];
                        }
                        $scope.search_results[location_id].name = location.name;
                        $scope.search_results[location_id].stage = location.stage;
                        var cheeses = [];
                        angular.forEach(mouse.cheeses, function(cheese) {
                            cheeses.push(cheese);
                        });
                        $scope.search_results[location_id].mice.push({
                            name: mouse.name,
                            mouse_wiki_url: mouse.mouse_wiki_url,
                            cheeses: cheeses
                        });
                        $scope.search_results[location_id].size = $scope.search_results[location_id].mice.length;
                    });
                } else if (mouse.name != '') {
                    $scope.mice_not_found.push({
                        name: mouse.name
                    });
                }
            });
            $('#custom_loader').fadeOut('slow');
            $scope.first_load = false;
        });
    };
    // Reset everything
    $scope.reset = function() {
        $scope.micelist = [];
        $scope.search_results = [];
        $scope.first_load = true;
        $scope.mice_not_found = [];
    };
    // Remove a mouse from list
    $scope.remove_a_mouse = function(mouse_name) {
        angular.forEach($scope.search_results, function(location) {
            angular.forEach(location.mice, function(mouse, key) {
                if (mouse.name === mouse_name) {
                    location.mice.splice(key, 1);
                    location.size--;
                }
            });
        });
    };
}]);
app.directive('miceListForm', function() {
    return {
        restrict: 'E',
        templateUrl: 'mice-list-form.html'
    };
});
app.directive('searchResults', function() {
    return {
        restrict: 'E',
        templateUrl: 'search-results.html'
    };
});
app.directive('customFooter', function() {
    return {
        restrict: 'E',
        templateUrl: 'custom-footer.html'
    };
});
app.directive('customHeader', function() {
    return {
        restrict: 'E',
        templateUrl: 'custom-header.html'
    };
});