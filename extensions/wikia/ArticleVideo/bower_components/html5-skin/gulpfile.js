// Build automation
// Require sudo npm install -g gulp
// For dev, initiate watch by executing either `gulp` or `gulp watch`

var gulp        = require('gulp'),
    browserify  = require('browserify'),
    watchify    = require('watchify'),
    reactify    = require('reactify'),
    bulkify     = require('bulkify'),
    source      = require('vinyl-source-stream'),
    buffer      = require('vinyl-buffer'),
    gutil       = require('gulp-util'),
    sourcemaps  = require('gulp-sourcemaps'),
    uglify      = require('gulp-uglify'),
    shell       = require('gulp-shell'),
    sass        = require('gulp-sass'),
    rename      = require('gulp-rename'),
    replace     = require('gulp-replace'),
    connect     = require('gulp-connect'),
    open        = require('gulp-open'),
    git         = require('git-rev'),
    realFs      = require('fs'),
    gracefulFs  = require('graceful-fs'),
    concat      = require('gulp-concat');
    //Fix OSX EMFILE error
    gracefulFs.gracefulify(realFs);

var path = {
  scripts: ['./js/**/*.js'],
  sass: ['./scss/**/*.scss'],
  pages: ['./iframe.html']
};

var devServer = {
  host: '0.0.0.0',
  port: 4444,
  file: 'sample.html',
  livereloadPort: 35729

};

//Build JS
function buildJS(file, hash, watch, ugly, sourcemap, debug, externalReact, callback) {
  var props ={
    entries: ['./js/controller.js'],
    debug: debug,
    transform:    [reactify, bulkify],
    cache: {},
    packageCache: {}
  };
  var bundler = watch ? watchify(browserify(props)) : browserify(props);

  function rebundle(reload) {
    if (externalReact) {
      bundler.external('react');
      bundler.external('react-dom');
    }

    bundler.bundle()
      .on("error", function (err) {
          gutil.log(
            gutil.colors.red("Browserify compile error:"),
            err.message
          );
          gutil.beep();
        })
      .on('end', function() {
        gutil.log(gutil.colors.green(file + ' DONE'));
      })
      .pipe(source(file))
      .pipe(buffer())
      .pipe(sourcemap ? sourcemaps.init({loadMaps: true}) : gutil.noop())
      // Add transformation tasks to the pipeline here.
      .pipe(replace('<SKIN_REV>', hash))
      .pipe(ugly ? uglify() : gutil.noop())
      .pipe(sourcemap ? sourcemaps.write('./') : gutil.noop())
      .pipe(gulp.dest('./build'))
      .on('end', function () {
        callback();
      })
      .pipe(reload ? connect.reload() : gutil.noop());
  }

  if (watch) {
    bundler.on('update', function () {
      gutil.log(gutil.colors.yellow('REBUILDING ' + file));
      return rebundle(true);
    });
  }

  return rebundle(false);
}

gulp.task('build:all', ['build:vendor', 'build'], function () {
  gulp.src([
    'build/core.js',
    'build/main_html5.js',
    'build/html5-skin.min.js',
    'build/google_ima.js',
    'build/discovery_api.js'
  ]).pipe(concat('all.js')).pipe(gulp.dest('build'));
});

gulp.task('build:vendor', function () {
  gulp.src('vendor/*.js').pipe(uglify()).pipe(gulp.dest('build'));
	gulp.src(['vendor/*.css', 'vendor/*.swf']).pipe(gulp.dest('build'));
});

// Build All
gulp.task('build', ['browserify', 'browserify:min', 'sass', 'sass:min', 'assets', 'pages']);

// Build Watch
gulp.task('build:watch', ['watchify', 'watchify:min', 'sass', 'sass:min', 'assets', 'pages']);

// Browserify JS
gulp.task('browserify', function(callback) {
  process.env.NODE_ENV = 'production';
  git.long(function (hash) {
    return buildJS('html5-skin.js', hash, false, false, false, false, false, callback);
  })
});

// Browserify Minified JS
gulp.task('browserify:min', function(callback) {
  process.env.NODE_ENV = 'production';
  git.long(function (hash) {
    return buildJS('html5-skin.min.js', hash, false, true, true, true, false, callback);
  })
});

// Browserify Minified, External React.js
gulp.task('external-react', function(callback) {
  process.env.NODE_ENV = 'production';
  git.long(function (hash) {
    return buildJS('html5-skin.min.js', hash, false, true, true, true, true, callback);
  })
});

// Watchify JS
gulp.task('watchify', function(callback) {
  git.long(function (hash) {
    return buildJS('html5-skin.js', hash, true, false, false, false, false, callback);
  })
});

// Watchify Minified JS
gulp.task('watchify:min', function(callback) {
  git.long(function (hash) {
    return buildJS('html5-skin.min.js', hash, true, true, true, true, false, callback);
  })
});

// Build Sass
gulp.task('sass', function () {
  gulp.src(path.sass)
    .pipe(sass()
      .on('error', sass.logError)
      .on('end', function() {gutil.log(gutil.colors.cyan('html5-skin.css DONE'));})
    )
    .pipe(gulp.dest('./build'))
    .pipe(connect.reload())
});

// Build Minified Sass
gulp.task('sass:min', function () {
  gulp.src(path.sass)
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'})
      .on('error', sass.logError)
      .on('end', function() {gutil.log(gutil.colors.cyan('html5-skin.min.css DONE'));})
    )
    .pipe(rename({suffix: '.min'}))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./build'))
    .pipe(connect.reload())
});

// Run tests in Jenkins build
gulp.task('test', shell.task(['npm test']));

// Initiate a watch
gulp.task('watch', ['build:watch'], function() {
  gulp.watch(path.sass, ['sass', 'sass:min']);
  gulp.watch(path.pages, ['pages']);
  gutil.log(gutil.colors.blue('WATCHING...'));
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'open']);

// Generate documentation
gulp.task("docs", shell.task("./node_modules/.bin/jsdoc -c ./jsdoc_conf.json"));

// Assets
gulp.task('assets', function () {
  gulp.src(['assets/**/*'])
    .pipe(gulp.dest('./build/assets'));
});

// HTML pages
gulp.task('pages', function () {
  gulp.src(['iframe.html', 'amp_iframe.html'])
    .pipe(gulp.dest('./build'));
});

// Local HTTP Server
gulp.task('server', function() {
  connect.server({
    port: devServer.port,
    livereload: {
      port: devServer.livereloadPort
    },
    host: devServer.host,
    fallback: devServer.file
  });
});

// Open app in browser
gulp.task('open', ['server'], function() {
  var options = {
    uri: 'http://' + devServer.host + ':' + devServer.port
  };
  gulp.src('./' + devServer.file)
    .pipe(open(options));
});
