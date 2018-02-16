/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Eliasis-Framework/Complement
 * @since     1.0.9
 */

var gulp         = require('gulp'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify-es').default,
    sass         = require('gulp-sass'),
    plumber      = require('gulp-plumber'),
    rename       = require('gulp-rename'),
    cleanCSS     = require('gulp-clean-css'),
    notify       = require('gulp-notify'),
    sourcemaps   = require('gulp-sourcemaps'),
    pump         = require('pump'),
    autoprefixer = require('gulp-autoprefixer');

gulp.task('vue+vue-resource+eliasis-complement', function (cb) {
    pump([
        gulp.src([
            'node_modules/vue/dist/vue.min.js',
            'node_modules/vue-resource/dist/vue-resource.min.js',
            'node_modules/vue-module-manager/dist/vue-module-manager.min.js',
            'node_modules/vue-simple-notify/dist/vue-simple-notify.min.js',
            'src/static/js/source/eliasis-complement.js'
        ]),
        concat('vue+vue-resource+eliasis-complement.min.js'),
        uglify(),
        gulp.dest('src/static/js/')
    ], cb);
});

gulp.task('vue-resource+eliasis-complement', function (cb) {
    pump([
        gulp.src([
            'node_modules/vue-resource/dist/vue-resource.min.js',
            'node_modules/vue-module-manager/dist/vue-module-manager.min.js',
            'node_modules/vue-simple-notify/dist/vue-simple-notify.min.js',
            'src/static/js/source/eliasis-complement.js'
        ]),
        concat('vue-resource+eliasis-complement.min.js'),
        uglify(),
        gulp.dest('src/static/js/')
    ], cb);
});

gulp.task('vue+eliasis-complement', function (cb) {

    pump([
        gulp.src([
            'node_modules/vue/dist/vue.min.js',
            'node_modules/vue-module-manager/dist/vue-module-manager.min.js',
            'node_modules/vue-simple-notify/dist/vue-simple-notify.min.js',
            'src/static/js/source/eliasis-complement.js'
        ]),
        concat('vue+eliasis-complement.min.js'),
        uglify(),
        gulp.dest('src/static/js/'),
    ], cb);

});

gulp.task('eliasis-complement', function (cb) {
    pump([
        gulp.src([
            'node_modules/vue-module-manager/dist/vue-module-manager.min.js',
            'src/static/js/source/eliasis-complement.js'
        ]),
        concat('eliasis-complement.min.js'),
        uglify(),
        gulp.dest('src/static/js/'),
        notify({ message: 'Scripts task complete' })
    ], cb);
});

gulp.task('js', [
    'vue+vue-resource+eliasis-complement',
    'vue-resource+eliasis-complement',
    'vue+eliasis-complement',
    'eliasis-complement'
]);

gulp.task('css', function () {

    gulp.src([
            'node_modules/vue-module-manager/dist/vue-module-manager.min.css',
            'node_modules/vue-simple-notify/dist/vue-simple-notify.min.css'
        ])
        .pipe(plumber())
        .pipe(autoprefixer({ 
            browsers: ['last 2 versions'], 
            cascade:  true 
        }))
        .pipe(concat('eliasis-complement.min.css'))
        .pipe(cleanCSS({
            compatibility: 'ie8' 
        }))
        .pipe(gulp.dest('src/static/css/'))
        .pipe(notify({ message: 'Styles task complete' }));

});

gulp.task('watch', function () {

    var jsFiles  = ['src/static/js/source/*'];

    gulp.watch(jsFiles, ['js']);

});

gulp.task('default', ['js', 'css']);
