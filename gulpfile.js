var gulp = require('gulp'),
    path = require('path'),
    phpcs = require('gulp-phpcs'),
    phpunit = require('gulp-phpunit');

gulp.task('default', ['watch']);

gulp.task('watch', function() {
    var patterns = [
        'src/**/*.php',
        'tests/**/*.php'
    ];

    return gulp.watch(patterns, ['phpcs'])
        .on('error', function(error) {
            console.error(error);
        });
});

gulp.task('phpunit', function() {
    var binary = path.join('vendor', 'bin', 'phpunit');

    return gulp.src('phpunit.xml')
        .pipe(phpunit(binary))
        .on('error', function(error) {
            console.error(error);
        });
});

gulp.task('phpcs', ['phpunit'], function() {
    var binary = path.join('vendor', 'bin', 'phpcs'),
        options = {
            bin: binary,
            standard: 'psr2'
        },
        patterns = [
            'src/**/*.php',
            'tests/**/*.php'
        ];

    return gulp.src(patterns)
        .pipe(phpcs(options))
        .pipe(phpcs.reporter('log'))
        .on('error', function(error) {
            console.error(error);
        });
});
