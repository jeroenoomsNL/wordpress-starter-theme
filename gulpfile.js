/* jshint node:true */
'use strict';

var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserSync = require('browser-sync').create();

var wordpressThemeFolder = '../wordpress/wp-content/themes/startertheme';
var wordpressLocalhost = 'localhost:8888/wordpress';

gulp.task('styles', function () {
  return $.rubySass('src/styles/style.scss', {precision: 10, style: 'compressed'})
    .on('error', $.rubySass.logError)
    .pipe($.autoprefixer({browsers: ['last 2 versions']}))
    .pipe(gulp.dest('dist'));
});

gulp.task('jshint', function () {
  return gulp.src('src/scripts/**/*.js')
    .pipe($.jshint())
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.jshint.reporter('fail'));
});

gulp.task('scripts', ['jshint'], function () {
  return gulp.src('src/scripts/**/*.js', {
    base: 'src'
  })
    .pipe($.uglify())
    .pipe(gulp.dest('dist'));
});

gulp.task('images', function () {
  return gulp.src('src/images/**/*')
    .pipe($.cache($.imagemin({
      progressive: true,
      interlaced: true
    })))
    .pipe(gulp.dest('dist/images'));
});

gulp.task('fonts', function () {
  return gulp.src('src/fonts/**/*')
    .pipe($.filter('**/*.{eot,svg,ttf,woff}'))
    .pipe($.flatten())
    .pipe(gulp.dest('dist/fonts'));
});

gulp.task('templates', function () {
  return gulp.src([
    'src/templates/**/*'
  ], {
    base: 'src/templates'
  }).pipe(gulp.dest('dist'));
});

gulp.task('languages', function () {
  return gulp.src([
    'src/languages/**/*'
  ], {
    base: 'src'
  }).pipe(gulp.dest('dist'));
});

gulp.task('clean', require('del').bind(null, ['.sass-cache','dist']));

gulp.task('watch', function () {

  browserSync.init({
    proxy: {
      target: wordpressLocalhost
    },
    nofity: false
  });

  gulp.watch('src/**/*', ['local']);

  gulp.watch(wordpressThemeFolder).on('change', browserSync.reload);
});

gulp.task('build', ['templates', 'styles', 'scripts', 'images', 'fonts', 'languages'], function () {
  return gulp.src('dist/**/*').pipe($.size({title: 'build', gzip: true}));
});

gulp.task('local', ['templates', 'styles', 'scripts', 'images', 'fonts', 'languages'], function () {
  return gulp.src('dist/**/*')
    .pipe(gulp.dest(wordpressThemeFolder))
    .pipe($.size({title: 'local'}));
});

gulp.task('default', ['clean'], function () {
  gulp.start('build');
});
