// Includes // TODO: move this all to /front/ gulp
// var elixir = require('laravel-elixir');
const gulp = require('gulp');
const rename = require('gulp-rename');
const imagemin = require('gulp-imagemin');

// DEFAULT
gulp.task('default', function() {
    gulp.start('js', 'img', 'css');
});

// JAVASCRIPTS
const minify = require('gulp-minify');
gulp.task('js', function () {
    gulp.src('front/js/source/*.js')
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            },
            noSource: true,
            // exclude: ['tasks'],
            // ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('front/js/dist'));
});

// IMAGES
gulp.task('img', function () {
    gulp.src('front/images/source/*')
        .pipe(imagemin())
        .pipe(gulp.dest('front/images/dist'));
});

// CSS
const cleanCSS = require('gulp-clean-css');
gulp.task('css', function () {
    return gulp.src('front/css/source/*.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('front/css/dist'));
});
