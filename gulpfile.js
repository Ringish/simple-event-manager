var gulp = require('gulp'),
plumber = require('gulp-plumber'),
rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin'),
cache = require('gulp-cache');
var minifycss = require('gulp-minify-css');
var sass = require('gulp-sass');




gulp.task('styles-public', function(){
  styles_task('public');
});
gulp.task('styles-admin', function(){
  styles_task('admin');
});

gulp.task('scripts-public', function(){
  return scripts_task('public');
});
gulp.task('scripts-admin', function(){
  scripts_task('admin');
});

gulp.task('default', function(){
  gulp.watch("public/src/styles/**/*.scss", ['styles-public']);
  gulp.watch("admin/src/styles/**/*.scss", ['styles-admin']);
  gulp.watch("public/src/scripts/**/*.js", ['scripts-public']);
  gulp.watch("admin/src/scripts/**/*.js", ['scripts-admin']);
});

function styles_task(directory) {
  return gulp.src([directory+'/src/styles/**/*.scss'])
  .pipe(plumber({
    errorHandler: function (error) {
      console.log(error.message);
      this.emit('end');
    }}))
  .pipe(sass())
  .pipe(autoprefixer('last 2 versions'))
  .pipe(gulp.dest('dist/styles/'))
  .pipe(rename({suffix: '.min'}))
  .pipe(minifycss())
  .pipe(gulp.dest(directory+'/dist/styles/'))
}
function scripts_task(directory) {
  return gulp.src(directory+'/src/scripts/**/*.js')
  .pipe(plumber({
    errorHandler: function (error) {
      console.log(error.message);
      this.emit('end');
    }}))
  .pipe(concat('main.js'))
  .pipe(gulp.dest(directory+'/dist/scripts/'))
  .pipe(rename({suffix: '.min'}))
  .pipe(uglify())
  .pipe(gulp.dest(directory+'/dist/scripts/'));
}