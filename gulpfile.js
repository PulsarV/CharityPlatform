var gulp = require('gulp'),
    less = require('gulp-less'),
    clean = require('gulp-clean'),
    concatJs = require('gulp-concat'),
    minifyJs = require('gulp-uglify');
gulp.task('less', function() {
 return gulp.src(['web-src/less/*.less', 'web-src/less/*.css'])
 .pipe(less({compress: true}))
 .pipe(gulp.dest('web/css/'));
});
gulp.task('images', function () {
 return gulp.src([
  'web-src/images/*'
 ])
 .pipe(gulp.dest('web/images/'))
});
gulp.task('images-ico', function () {
 return gulp.src([
  'web-src/images/ico/*'
 ])
 .pipe(gulp.dest('web/images/ico/'))
});
gulp.task('fonts', function () {
 return gulp.src(['web-src/fonts/*', 'bower_components/bootstrap/fonts/*.*'])
 .pipe(gulp.dest('web/fonts/'))
});
gulp.task('js', function() {
 return gulp.src([
      'web-src/js/*.js'
     ])
     .pipe(minifyJs())
     .pipe(gulp.dest('web/js/'));
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
gulp.task('tinymce', function() {
 return gulp.src([
  'bower_components/tinymce/**/*.*'
 ])
 .pipe(gulp.dest('web/tinymce/'));
});
gulp.task('clean', function () {
 return gulp.src([
  'web/css/*', 'web/js/*', 'web/images/*', 'web/fonts/*', 'web/tinymce/*'
 ])
 .pipe(clean());
});
gulp.task('default', ['clean'], function () {
 var tasks = [
  'images', 'images-ico', 'fonts', 'less', 'js', 'lib-js', 'tinymce'
 ];
 tasks.forEach(function (val) {
  gulp.start(val);
 });
});
gulp.task('watch', function () {
 var less = gulp.watch([
  'web-src/less/*.less', 'web-src/less/*.css'
 ], [
  'less'
 ])
});
