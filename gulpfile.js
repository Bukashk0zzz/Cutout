'use strict';

var gulp = require('gulp'),
	browserSync = require('browser-sync'),
	reload = browserSync.reload,
	uglify = require('gulp-uglifyjs'),
	concat    = require('gulp-concat'),
	minifyCSS = require('gulp-minify-css'),
	rename    = require('gulp-rename'),
	gzip = require('gulp-gzip'),
	cache = require('gulp-cached');

// Compile and Automatically Prefix Stylesheets
gulp.task('styles', function () {
    gulp.src([
        'css/materialize.css',
        'css/materialPreloader.css',
        'css/main.css'
    ])
	.pipe(cache('styling'))
    .pipe(concat('style.css'))
    .pipe(minifyCSS())
    .pipe(rename('styles.min.css'))
    .pipe(gulp.dest('css/'))
    .pipe(gzip({ append: true, level: 6 }))
    .pipe(gulp.dest('css/'));
});

// JS main
gulp.task('js', function () {
    return gulp.src([
        'js/jquery-2.1.1.min.js',
        'js/Chart.js',
        'js/materialize.js',
        'js/materialPreloader.js',
        'js/main.js'
    ])
        .pipe(cache('jsing'))
        .pipe(concat('uglify.js'))
        .pipe(uglify())
        .pipe(rename('main.min.js'))
        .pipe(gulp.dest('js/'))
        .pipe(gzip({ append: true, level: 6 }))
        .pipe(gulp.dest('js/'));
});

// Watch Files For Changes & Reload
gulp.task('default', ['styles','js'], function () {
    browserSync({
        notify: false,
        open: false,
        logPrefix: 'WSK',
        port: 8800,
        injectChanges: true,
        proxy: "http://127.0.0.1:8000"
    });

    gulp.watch(['css/**/*.css'], ['styles']);
    gulp.watch(['js/**/*.js'], ['js']);
});