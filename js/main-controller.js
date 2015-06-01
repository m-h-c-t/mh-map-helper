var app = angular.module('mainapp', []);

app.controller('MainController', function($scope, $http) {
    $scope.micelist = [];
    $scope.location_mice = [];
    $scope.first_load = true;

    // Get locations and cheese for each mouse
    $scope.get_location_mice = function() {
        $('#custom_loader').show();
        $scope.location_mice = [];

        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.get("api.php", {
            params: {
                action:'get_mice_info',
                mice: JSON.stringify($scope.micelist),
                }
            })
            .success(function (response) {
                //format into array of objects [i][area][mice][cheeses];
                angular.forEach(response, function(mice_array, location_name) {
                    var location = {name: location_name, mice:[], size:0};
                    angular.forEach(mice_array, function(cheeses_array, mouse_name) {
                        var mouse = {name: mouse_name, cheeses: cheeses_array};
                        location.mice.push(mouse);
                    });
                    location.size = location.mice.length;
                    $scope.location_mice.push(location);
                });

                $('#custom_loader').fadeOut('slow');
                $scope.first_load = false;
            });
    };

    // Reset everything
    $scope.reset = function() {
        $scope.micelist = [];
        $scope.location_mice = [];
        $scope.first_load = true;
    };

    // Remove a mouse from list
    $scope.remove_a_mouse = function(mouse_name) {
        angular.forEach($scope.location_mice, function(location) {
            angular.forEach(location.mice, function(mouse, key) {
                if (mouse.name === mouse_name) {
                    location.mice.splice(key, 1);
                    location.size--;
                }
            });
        });
    };
});

app.directive('miceListForm', function() {
    return {
        restrict: 'E',
        templateUrl: 'mice-list-form.html'
    };
});

app.directive('locations', function() {
    return {
        restrict: 'E',
        templateUrl: 'locations.html'
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
