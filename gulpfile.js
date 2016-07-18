// Includes
var elixir = require('laravel-elixir');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');

// Config
elixir.config.js.browserify.watchify.options.poll = true;

// Process
elixir.extend('images', function () {
    new elixir.Task('images', function () {
        return gulp.src('resources/assets/images/*')
            .pipe(imagemin())
            .pipe(gulp.dest('public/images'));
    }).watch('resources/assets/images/*');
});

elixir(function (mix) {
    mix.sass('custom.scss');

    mix.scripts('main-controller.js');

    mix.version(['public/css/custom.css', 'public/js/main-controller.js'], 'public/build');

    mix.images();
});
