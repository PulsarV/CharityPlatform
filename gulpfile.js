var gulp = require('gulp'),
 less = require('gulp-less'),
 clean = require('gulp-clean');
 concatJs = require('gulp-concat'),
 minifyJs = require('gulp-uglify');
gulp.task('less', function() {
 return gulp.src(['web-src/less/*.less', 'web-src/less/*.css'])
 .pipe(less({compress: true}))
 .pipe(gulp.dest('web/css/'));
});
gulp.task('images', function () {
 return gulp.src([
 'web-src/images/*',
 ])
 .pipe(gulp.dest('web/images/'))
});
gulp.task('images-ico', function () {
 return gulp.src([
 'web-src/images/ico/*',
 ])
 .pipe(gulp.dest('web/images/ico/'))
});
gulp.task('images-test', function () {
 return gulp.src([
 'web-src/images/test/*',
 ])
 .pipe(gulp.dest('web/images/test/'))
});
gulp.task('fonts', function () {
 return gulp.src(['web-src/fonts/*'])
 .pipe(gulp.dest('web/fonts/'))
});
gulp.task('lib-js', function() {
 return gulp.src([
 'bower_components/jquery/dist/jquery.js',
 'bower_components/bootstrap/dist/js/bootstrap.js'
 ])
 .pipe(concatJs('app.js'))
 .pipe(minifyJs())
 .pipe(gulp.dest('web/js/'));
});
gulp.task('pages-js', function() {
 return gulp.src([
 'web-src/js/*.js'
 ])
 .pipe(minifyJs())
 .pipe(gulp.dest('web/js/'));
});
gulp.task('clean', function () {
 return gulp.src(['web/css/*', 'web/js/*', 'web/images/*', 'web/fonts/*'])
 .pipe(clean());
});
gulp.task('default', ['clean'], function () {
 var tasks = ['images', 'images-ico', 'images-test', 'fonts', 'less', 'lib-js', 'pages-js'];
tasks.forEach(function (val) {
 gulp.start(val);
 });
});
gulp.task('watch', function () {
 var less = gulp.watch('web-src/less/*.less', ['less']),
 js = gulp.watch('web-src/js/*.js', ['pages-js']);
});