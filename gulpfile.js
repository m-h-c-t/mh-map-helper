// Includes - global
const gulp = require('gulp');
const rename = require('gulp-rename');
const livereload = require('gulp-livereload');
const rev = require('gulp-rev');
const del = require('del');
// Includes - js
const minify = require('gulp-minify');
// Includes - images
const imagemin = require('gulp-imagemin');
// Includes - css
const cleanCSS = require('gulp-clean-css');

/**
 * Delete files matching the fileglob using `del`
 * @param {string} srcGlob path and glob of files to be deleted by the gulp task.
 */
const cleanFiles = (srcGlob) => del(srcGlob);

// WATCH
gulp.task('watch', function () {
    livereload.listen();
    gulp.watch('front/js/source/*.js', {usePolling: true}, gulp.task('js'));
    gulp.watch('front/css/source/*.css', {usePolling: true}, gulp.task('css'));
    gulp.watch('front/images/source/*', {usePolling: true}, gulp.task('img'));
});

// JAVASCRIPTS
gulp.task('js-clean', function () {
    return cleanFiles('front/js/dist/main-controller*.js')
});

gulp.task('copy-cookie', function () {
    return gulp.src('node_modules/js-cookie/src/js.cookie.js')
        .pipe(gulp.dest('front/js/dist'));
});

gulp.task('minify-js', function () {
    return gulp.src('front/js/source/*.js')
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
gulp.task('js', gulp.series('js-clean', gulp.parallel('copy-cookie', 'minify-js')));

// IMAGES
gulp.task('img', function () {
    return gulp.src('front/images/source/*')
        .pipe(imagemin())
        .pipe(gulp.dest('front/images/dist'))
        .pipe(gulp.dest('api/public/images/dist'))
        .pipe(livereload());
});

// CSS
const clean_frontend_css = () => cleanFiles('front/css/dist/custom*.css');
const clean_api_css = () => cleanFiles('api/public/css/dist/custom*.css');

gulp.task('css-clean', gulp.parallel(
    clean_frontend_css,
    clean_api_css
));

gulp.task('css', gulp.series('css-clean', function css_update() {
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
}));

// DEFAULT
gulp.task('default', gulp.parallel('img', 'css', 'js'));
