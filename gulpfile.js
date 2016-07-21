// Includes // TODO: move this all to /front/ gulp
// var elixir = require('laravel-elixir');
const gulp = require('gulp');
const rename = require('gulp-rename');
const livereload = require('gulp-livereload');

// DEFAULT
gulp.task('default', function() {
    gulp.start('js', 'img', 'css');
});

// WATCH
gulp.task('watch', function() {
    livereload.listen();
    gulp.watch('front/js/source/*.js', { usePolling: true }, ['js']);
    gulp.watch('front/css/source/*.css', { usePolling: true }, ['css']);
    gulp.watch('front/images/source/*', { usePolling: true }, ['img']);
});

// JAVASCRIPTS
const minify = require('gulp-minify');
gulp.task('js', function () {
    gulp.src('node_modules/js-cookie/src/js.cookie.js')
        .pipe(gulp.dest('front/js/dist'));

    gulp.src('front/js/source/*.js')
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            },
            noSource: true
            // exclude: ['tasks'],
            // ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('front/js/dist'))
        .pipe(livereload());
});

// IMAGES
const imagemin = require('gulp-imagemin');
gulp.task('img', function () {
    gulp.src('front/images/source/*')
        .pipe(imagemin())
        .pipe(gulp.dest('front/images/dist'))
        .pipe(livereload());
});

// CSS
const cleanCSS = require('gulp-clean-css');
gulp.task('css', function () {
    return gulp.src('front/css/source/*.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('front/css/dist'))
        .pipe(livereload());
});
