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
    <meta property="og:title" content="Jack's MouseHunt Tools" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.agiletravels.com" />
    <meta property="og:description" content="Tools to help with the MouseHunt game." />
    <meta property="og:image" content="https://www.agiletravels.com/images/fb_image.jpg" />
    <meta property="fb:app_id" content="314857368939024" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"> -->
    <link rel="stylesheet" href="css/dist/<?php echo asset_path('custom.min.css'); ?>">
    <script defer src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.11/angular.min.js"></script>
    <script defer src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.11/angular-route.min.js"></script>
    <script defer src="js/dist/js.cookie.js"></script>
    <script defer src="js/dist/<?php echo asset_path('main-controller.min.js'); ?>"></script>
</head>
<body class="text-center" ng-controller="MainController">
    <!-- Loading Screen -->
    <div id="custom_loader"></div>

    <div class="header">
        <custom-header></custom-header>
    </div>
<!-- <H1 style="color:red;">(Performing updates... Will be back shortly)</H1> -->
    <div class="content">
        <ng-view></ng-view>

        <mice-list-form></mice-list-form>
    </div>

    <div class="footer">
        <custom-footer></custom-footer>
    </div>

    <!-- JS Includes -->
    <script defer src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script defer src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <?php include_once("ga.php") ?>
</body>
</html>
