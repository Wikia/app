var gulp = require('gulp'),
	sass = require('gulp-sass');

gulp.task('sass', function () {
	gulp.src('./src/scss/*.scss')
		.pipe(sass())
		.pipe(gulp.dest('./dist/css'));
});

gulp.task('svg', function () {
	gulp.src('./src/svg/*.svg')
		.pipe(gulp.dest('./dist/svg'));
});
