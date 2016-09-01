// Includes - global
const gulp = require('gulp');
const rename = require('gulp-rename');
const livereload = require('gulp-livereload');
const rev = require('gulp-rev');
const clean = require('gulp-clean');
// Includes - js
const minify = require('gulp-minify');
// Includes - images
const imagemin = require('gulp-imagemin');
// Includes - css
const cleanCSS = require('gulp-clean-css');

// DEFAULT
gulp.task('default', function () {
    gulp.start('img', 'css', 'js');
});

// WATCH
gulp.task('watch', function () {
    livereload.listen();
    gulp.watch('front/js/source/*.js', {usePolling: true}, ['js']);
    gulp.watch('front/css/source/*.css', {usePolling: true}, ['css']);
    gulp.watch('front/images/source/*', {usePolling: true}, ['img']);
});

// JAVASCRIPTS
gulp.task('js-clean', function () {
    gulp.src('front/js/dist/main-controller*.js', {read: false})
        .pipe(clean({force: true}));
});

gulp.task('js', ['css', 'js-clean'], function () {
    gulp.src('node_modules/js-cookie/src/js.cookie.js')
        .pipe(gulp.dest('front/js/dist'));

    gulp.src('front/js/source/*.js')
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            },
            noSource: true
        }))
        .pipe(rev())
        .pipe(gulp.dest('front/js/dist'))
        .pipe(rev.manifest('rev-manifest.json', {base: process.cwd(), merge: true}))
        .pipe(gulp.dest('./'))
        .pipe(gulp.dest('front'))
        .pipe(gulp.dest('api/public'))
        .pipe(livereload());
});

// IMAGES
gulp.task('img', function () {
    gulp.src('front/images/source/*')
        .pipe(imagemin())
        .pipe(gulp.dest('front/images/dist'))
        .pipe(gulp.dest('api/public/images/dist'))
        .pipe(livereload());
});

// CSS
gulp.task('css', ['css-clean'], function () {
    return gulp.src('front/css/source/*.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('api/public/css/dist'))
        .pipe(rev())
        .pipe(gulp.dest('front/css/dist'))
        .pipe(gulp.dest('api/public/css/dist'))
        .pipe(rev.manifest('rev-manifest.json', {base: process.cwd(), merge: true}))
        .pipe(gulp.dest('./'))
        .pipe(gulp.dest('front'))
        .pipe(gulp.dest('api/public'))
        .pipe(livereload());
});

gulp.task('css-clean', function () {
    gulp.src('front/css/dist/custom*.css', {read: false})
        .pipe(clean({force: true}));
    gulp.src('api/public/css/dist/custom*.css', {read: false})
        .pipe(clean({force: true}));
});
