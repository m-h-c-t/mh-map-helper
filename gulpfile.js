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

// JAVASCRIPTS
const jsClean = () => cleanFiles('front/js/dist/main-controller*.js');

const copyCookie = () => gulp
    .src('node_modules/js-cookie/src/js.cookie.js')
    .pipe(gulp.dest('front/js/dist'));

const minifyJs = () => gulp
    .src('front/js/source/*.js')
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
exports.js = gulp.parallel(copyCookie, gulp.series(jsClean, minifyJs));

// IMAGES
exports.img = () => gulp
    .src('front/images/source/*')
    .pipe(imagemin())
    .pipe(gulp.dest('front/images/dist'))
    .pipe(gulp.dest('api/public/images/dist'))
    .pipe(livereload());

// CSS
const clean_frontend_css = () => cleanFiles('front/css/dist/custom*.css');
const clean_api_css = () => cleanFiles('api/public/css/dist/custom*.css');

const css_update = () => gulp
    .src('front/css/source/*.css')
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
exports['css-clean'] = gulp.parallel(clean_frontend_css, clean_api_css);
exports.css = gulp.series(this["css-clean"], css_update);

// DEFAULT
exports.default = gulp.parallel(this.img, this.css, this.js);

// WATCH
exports.watch = () => {
    livereload.listen();
    gulp.watch('front/js/source/*.js', {usePolling: true}, this.js);
    gulp.watch('front/css/source/*.css', {usePolling: true}, this.css);
    gulp.watch('front/images/source/*', {usePolling: true}, this.img);
};

