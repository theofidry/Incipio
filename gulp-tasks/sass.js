var gutil   = require('gulp-util');

module.exports = function(gulp, plugins, config) {

    var options = {};

    if (config.dev) {
        options.sourcemap = true;
        options.style = 'expanded';
        options.trace = true;
    } else {
        options.style = 'compressed';
    }

    return function() {
        return plugins.rubySass(config.paths.sass.src, options)
            //.pipe(gutil.noop())
            .pipe(plugins.size())
            .pipe(gulp.dest(config.paths.sass.dest))
        ;
    };
    //
    //var files = gulp.src(config.paths.sass.src)
    //    .pipe(plugins.rubySass({
    //
    //        style: sassStyle, sourcemap: sourceMap, precision: 2
    //    }))
    //    .on('error', function(err) {
    //        new gutil.PluginError('CSS', err, {showStack: true});
    //    });
    //
    //return es.concat(gulp.src(vendorFiles.styles), files)
    //    .pipe(plugins.concat('style.min.css'))
    //    .pipe(plugins.autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    //    .pipe(isProduction? plugins.combineMediaQueries({
    //        log: true
    //    }): gutil.noop())
    //    .pipe(isProduction? plugins.cssmin(): gutil.noop())
    //    .pipe(plugins.size())
    //    .pipe(gulp.dest(paths.styles.dest));
};
