'use strict';

var gulp    = require('gulp');
var es      = require('event-stream');
var gutil   = require('gulp-util');
var plugins = require('gulp-load-plugins')();

// Variables configuration
var config = {
    paths: {
        basePaths: {
            src:  __dirname + '/src/FrontBundle/Resources/assets',   // Assets source directory
            dest: __dirname + '/web/assets'                          // Directory into which all assets will be compiled
        }
    },
    dev: false  // If true is in dev mode
};

config.paths.sass = {
    src:  config.paths.basePaths.src + '/scss/app.scss',
    dest: config.paths.basePaths.dest
};

config.paths.scripts = {
    src:  config.paths.basePaths.src + '/scripts/app.js',
    dest: config.paths.basePaths.dest
};

config.paths.img = {
    src:  config.paths.basePaths.src + '/img',
    dest: config.paths.basePaths.dest + '/img'
};

config.paths.fonts = {
    src:  config.paths.basePaths.src + '/fonts/**/*',
    dest: config.paths.basePaths.src + '/fonts'
};

if (true === gutil.env.dev) {
    config.dev = true;
}

function getTask(task) {
    return require('./gulp-tasks/' + task)(gulp, plugins, config);
}

// Fired whenever a file changes. This outputs what file it was and what happened to it
var changeEvent = function(evt) {
    gutil.log('File', gutil.colors.cyan(evt.path.replace(new RegExp('/.*(?=/' + config.paths.basePaths.src + ')/'), '')), 'was', gutil.colors.magenta(evt.type));
};

// Load tasks
//gulp.task('scripts', getTask('scripts'));
console.log(getTask('sass'));
gulp.task('sass', getTask('sass'));

// Define tasks
gulp.task('build', ['scripts', 'scss']);
gulp.task('default', ['scripts', 'sass'], function () {
    gulp.watch('src/js/**/*.js', ['scripts']);
    gulp.watch('src/sass/**/*.{sass,scss}', ['sass']);
});

//var batch = require('gulp-batch');
//var sass  = require('gulp-sass');
//var watch = require('gulp-watch');
//
//var browserify = require('browserify');
//var source = require('vinyl-source-stream');
//var buffer = require('vinyl-buffer');
//var uglify = require('gulp-uglify');
//var sourcemaps = require('gulp-sourcemaps');
//var gutil = require('gulp-util');
//var watchify = require('watchify');
//var assign = require('lodash.assign');
//
//var assets_src  = 'src/FrontBundle/Resources/assets';
//var assets_dest = 'web/assets';
//
//var sass_src  = assets_src + '/scss';
//var sass_dest = assets_dest;
//
//var js_src = assets_src + '/js/app.js';
//var js_dest = assets_dest;
//
//var fonts_src = assets_src + '/fonts/**/*';
//var fonts_dest = assets_dest + '/fonts';
//
//// Copy files without any changes
//gulp.task('copy', function() {
//
//    // Copy fonts
//    gulp.src(fonts_src)
//        .pipe(gulp.dest(fonts_dest));
//});
//
//// Compile SASS files to CSS
//gulp.task('sass', function () {
//    gulp.src(sass_src + '/app.scss')
//        .pipe(sass())
//        .pipe(gulp.dest(sass_dest));
//});
//
//// Publish JavaScript files
//// add custom browserify options here
//var customOpts = {
//    entries: [js_src],
//    debug: true
//};
//var opts = assign({}, watchify.args, customOpts);
//var b = watchify(browserify(opts));
//
//gulp.task('js', bundle); // so you can run `gulp js` to build the file
//b.on('update', bundle); // on any dep update, runs the bundler
//b.on('log', gutil.log); // output build logs to terminal
//
//function bundle() {
//    return b.bundle()
//        // log errors if they happen
//        .on('error', gutil.log.bind(gutil, 'Browserify Error'))
//        .pipe(source('app.js'))
//        // optional, remove if you don't need to buffer file contents
//        .pipe(buffer())
//        // optional, remove if you dont want sourcemaps
//        .pipe(sourcemaps.init({loadMaps: true})) // loads map from browserify file
//        // Add transformation tasks to the pipeline here.
//        .pipe(sourcemaps.write('./')) // writes .map file
//        .pipe(gulp.dest(js_dest));
//}
//
//// Configure watch task
//gulp.task('watch', function () {
//
//    // Watch SCSS files
//    gulp.watch(sass_src + '**/*.scss', ['sass']);
//});
//
//
//
//
//
//var usemin = require('gulp-usemin');
//var uglify = require('gulp-uglify');
//var minifyHtml = require('gulp-minify-html');
//var minifyCss = require('gulp-minify-css');
//var rev = require('gulp-rev');
//
//gulp.task('usemin', function () {
//    return gulp.src('./*.html')
//        .pipe(usemin({
//            css: [minifyCss(), 'concat'],
//            html: [minifyHtml({empty: true})],
//            js: [uglify(), rev()],
//            inlinejs: [uglify()],
//            inlinecss: [minifyCss(), 'concat']
//        }))
//        .pipe(gulp.dest('build/'));
//});

//gulp        = require 'gulp'
//
//jade        = require 'gulp-jade'
//
//coffee      = require 'gulp-coffee'
//
//concat      = require 'gulp-concat'
//
//gutil       = require 'gulp-util'
//
//
//
//paths =
//
//    jade:
//
//src: './server/app/views/**/*.jade'
//
//dest: './client/public/'
//
//
//
//coffee_client:
//
//    src: './client/app/**/*.coffee'
//
//dest: './client/public'
//
//
//
//gulp.task 'default', ['jade', 'coffee']
//
//
//
//gulp.task 'jade', ->
//
//gulp.src paths.jade.src
//
//    .pipe jade()
//
//    .pipe gulp.dest paths.jade.dest
//
//
//
//gulp.task 'coffee', ->
//
//gulp.src paths.coffee_client.src
//
//    .pipe(coffee(bare: true).on('error', gutil.log))
//
//.pipe(concat('app.js'))
//
//    .pipe gulp.dest paths.coffee_client.dest
//
//
//
//# watcher = gulp.watch './server/app/views/**/*.jade', ['jade']
//
//
//
//gulp.task 'watch', ->
//
//gulp.watch(paths.jade.src, [ 'jade' ]).on 'change', (event) ->
//
//console.log 'File ' + event.path + ' was ' + event.type + ', rendering...'
//
//gulp.watch(paths.coffee_client.src, [ 'coffee' ]).on 'change', (event) ->
//
//console.log 'File ' + event.path + ' was ' + event.type + ', rendering...'
