<?php
    require_once 'rev-replace.php';
?>
<!DOCTYPE html>
<html lang="en" ng-app="mainapp">
<head>
    <meta charset="utf-8">
    <base href="/">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
    <link rel="stylesheet" href="css/dist/<?php echo asset_path('custom.min.css'); ?>">
    <script defer src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script defer src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-route.min.js"></script>
    <script defer src="js/dist/js.cookie.js"></script>
    <script defer src="js/dist/<?php echo asset_path('main-controller.min.js'); ?>"></script>
</head>
<body class="text-center" ng-controller="MainController">
    <!-- Loading Screen -->
    <div id="custom_loader"></div>

    <custom-header></custom-header>

    <ng-view></ng-view>

    <mice-list-form></mice-list-form>

    <custom-footer></custom-footer>

    <!-- JS Includes -->
    <script defer src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script defer src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
