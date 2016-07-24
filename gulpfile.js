// Includes
const gulp = require('gulp');
const rename = require('gulp-rename');
const livereload = require('gulp-livereload');
const rev = require('gulp-rev');

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
gulp.task('js', ['css'], function () {
    gulp.src('node_modules/js-cookie/src/js.cookie.js')
        // .pipe(gulp.dest('api/public/js/dist'))
        .pipe(gulp.dest('front/js/dist'));

    gulp.src('front/js/source/*.js')
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            },
            noSource: true
            // exclude: ['tasks'],
            // ignoreFiles: ['rev-replace.js']
        }))
        .pipe(gulp.dest('front/js/dist'))
        .pipe(rev())
        .pipe(gulp.dest('front/js/dist'))
        // .pipe(gulp.dest('api/public/js/dist'))
        .pipe(rev.manifest({merge: true}))
        .pipe(gulp.dest('front'))
        // .pipe(gulp.dest('api/public'))
        .pipe(livereload());
});

// IMAGES
const imagemin = require('gulp-imagemin');
gulp.task('img', function () {
    gulp.src('front/images/source/*')
        .pipe(imagemin())
        .pipe(gulp.dest('front/images/dist'))
        .pipe(gulp.dest('api/public/images/dist'))
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
        .pipe(gulp.dest('api/public/css/dist'))
        .pipe(rev())
        .pipe(gulp.dest('front/css/dist'))
        .pipe(gulp.dest('api/public/css/dist'))
        .pipe(rev.manifest({merge: true}))
        .pipe(gulp.dest('front'))
        .pipe(gulp.dest('api/public'))
        .pipe(livereload());
});
