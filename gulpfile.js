var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.js.browserify.watchify.options.poll = true;

elixir(function(mix) {
    mix.sass('custom.scss');

    mix.scripts('main-controller.js');

    mix.copy('resources/assets/images', 'public/images');
        // .version('public/images');

    mix.version(['public/css/custom.css', 'public/js/main-controller.js'], 'public/build');
});
