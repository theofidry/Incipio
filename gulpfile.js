var gulp  = require('gulp');
var batch = require('gulp-batch');
var sass  = require('gulp-sass');
var watch = require('gulp-watch');

var sass_src  = 'src/FrontBundle/Resources/assets/scss';
var sass_dest = 'web/assets';

// Compile SASS files to CSS
gulp.task('sass', function () {
    gulp.src(sass_src + '/app.scss')
        .pipe(sass())
        .pipe(gulp.dest(sass_dest));
});

// Configure watch task
gulp.task('watch', function () {

    // Watch SCSS files
    gulp.watch(sass_src + '**/*.scss', ['sass']);
});
