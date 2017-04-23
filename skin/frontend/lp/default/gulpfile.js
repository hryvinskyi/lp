/*
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

var
    gulp = require('gulp'),
    sass = require('gulp-sass'),
    uglify = require('gulp-uglify'),
    rimraf = require('gulp-rimraf'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache');

var config = {
    minifyCss: true,
    uglifyJS: true
};

gulp.task('sass', function () {
    return gulp.src(['./src/scss/main.scss', './src/scss/bootstrap/bootstrap.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css'));
});

gulp.task('js', function () {
    var scripts = [
        //'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        'bower_components/select2/dist/js/select2.full.min.js',
        // 'bower_components/bootstrap/js/transition.js',
        // 'bower_components/bootstrap/js/collapse.js',
        // 'bower_components/bootstrap/js/carousel.js',
        // 'bower_components/bootstrap/js/dropdown.js',
        // 'bower_components/bootstrap/js/modal.js',
        'src/js/script.js'
    ];

    var stream = gulp
        .src(scripts)
        .pipe(concat('script.js'));

    if (config.uglifyJS === true) {
        stream.pipe(uglify());
    }

    return stream
        .pipe(gulp.dest('js'))
        .pipe(notify({message: 'Successfully compiled JavaScript'}));
});

gulp.task('images', function () {
    return gulp
        .src('src/images/**/*')
        .pipe(gulp.dest('images'))
        .pipe(notify({message: 'Successfully processed image'}));
});

gulp.task('fonts', function () {
    return gulp
        .src([
            'bower_components/bootstrap/fonts/**/*'
        ])
        .pipe(gulp.dest('fonts'))
        .pipe(notify({message: 'Successfully processed font'}));
});

gulp.task('rimraf', function () {
    return gulp
        .src(['css', 'js', 'images'], {read: false})
        .pipe(rimraf());
});

gulp.task('default', ['rimraf'], function () {
    gulp.start('css', 'js', 'images', 'fonts');
});

// Watch
gulp.task('watch', function () {
    gulp.watch('src/scss/**/*.scss', ['sass']);
    gulp.watch('src/js/**/*.js', ['js']);
    gulp.watch('src/images/**/*', ['images']);
    gulp.watch('bower_components/bootstrap/fonts/**/*', ['fonts']);
});
