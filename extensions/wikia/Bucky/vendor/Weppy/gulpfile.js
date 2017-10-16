var gulp = require('gulp'),
	qunit = require('gulp-qunit'),
	rename = require('gulp-rename'),
	ts = require('gulp-typescript'),
	wrap = require('gulp-wrap'),
	source = './src/weppy.ts',
	destination = './dist';


var all_deps = [];

gulp.task('compile', function () {
	return gulp.src(source)
		.pipe(ts()).js
		.pipe(gulp.dest(destination));
});
all_deps.push('compile');

gulp.task('compileAMD', function () {
	return gulp.src(source)
		.pipe(wrap('<%= contents %> export = Weppy;'))
		.pipe(ts({module: 'amd'})).js
		.pipe(rename(function (path) {
			path.basename += '.amd';
		}))
		.pipe(gulp.dest(destination));
});
all_deps.push('compileAMD');

gulp.task('compileCommonJS', function () {
	return gulp.src(source)
		.pipe(wrap('<%= contents %> export = Weppy;'))
		.pipe(ts({module: 'commonjs'})).js
		.pipe(rename(function (path) {
			path.basename += '.cjs';
		}))
		.pipe(gulp.dest(destination));
});
all_deps.push('compileCommonJS');

gulp.task('copy-weppy.d.ts',function(){
	return gulp.src('./weppy.d.ts')
		.pipe(gulp.dest('./dist'));
});
all_deps.push('copy-weppy.d.ts');

gulp.task('test',function(){
	return gulp.src('./tests/index.html')
		.pipe(qunit());
});

gulp.task('default', all_deps);
