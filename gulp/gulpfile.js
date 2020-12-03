/**
 * Process our Styles and Scripts and output them into our theme
 * 
 * When converting to Gulp 4 we used this link as an example
 * @link https://levelup.gitconnected.com/how-to-setup-your-workflow-using-gulp-v4-0-0-5450e3d7c512
 */

//THIS SHOULD MATCH YOUR THEME NAME
var THEME = 'narrative';


var gulp = require('gulp');
var through2 = require('through2');
//var uglify = require('gulp-uglify');
var uglify = require('gulp-uglify-es').default;
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var browserSync = require('browser-sync').create();
var sass = require('gulp-sass');
//var cssnano = require("cssnano");
//var postcss = require("gulp-postcss");


//file paths
var SRC_PATH = './';
var THEME_PATH = '../wp-content/themes/'+THEME+'/';
var SCRIPTS_PATH = SRC_PATH+'scripts/*.js';
var SCRIPTS_WATCH_PATH = SRC_PATH+'scripts/**/*.js';
var SCSS_PATH = SRC_PATH+'scss/styles.scss';
var SCSS_WATCH_PATH = SRC_PATH+'scss/**/*.scss';

var REACT_BUILD_PATH = SRC_PATH+'react/'+THEME+'/build/';
var REACT_WATCH_PATH = REACT_BUILD_PATH+'**/*';
var REACT_THEME_PATH = THEME_PATH+'templates/admin/';

var paths = {
    styles: {
        src: SCSS_PATH,
        watch: SCSS_WATCH_PATH,
        dest: THEME_PATH + 'styles'
    },
    scripts: {
        src: SCRIPTS_PATH,
        watch: SCRIPTS_WATCH_PATH,
        dest: THEME_PATH + 'js'
    },
    php: {
      watch: THEME_PATH + "**/*.php"
    }
};


/**
 * REACT Task 
 * We need to move various react files to various places in our site. This way we don't ever have to manually move our React files around after building
 * 
 * NOTE: When building for production we need to make sure we comment out the .unregister() function in the src/index.js file
 */
// gulp.task('react', function() {
//     console.log('Reacting...');

//     // STEPS
//     // ✓ 1. Watch REACT_WATCH_PATH. 
//     // ✓ 2. Move index.html from REACT_BUILD_PATH into REACT_THEME_PATH
//     // ✓ 3. Move static files from REACT_BUILD_PATH + '/static/' to ROOT + '/static/' Overwrite / remove old files
//     // ✓ 4. Move assets from REACT_BUILD_PATH + '/assets/' to ROOT + '/assets/' Overwrite / remove old files
//     // 5 (Optional?) Move the service-worker.js, manifest.js, asset-manifest.js, and precache files to ROOT directory

//     var folders = [
//       {
//         src: REACT_BUILD_PATH+'assets/**/*.*',
//         dest: '../assets/'
//       },
//       {
//         src: REACT_BUILD_PATH+'static/**/*.*',
//         dest: '../static/'
//       },
//       {
//         src: REACT_BUILD_PATH+'index.html',
//         dest: REACT_THEME_PATH
//       },
//       // We might want to also stick our index.html into our root so that our service worker is able to target it for cachine...IF we even want to use the service worker since it will only affect one page
//       // {
//       //   src: REACT_BUILD_PATH+'index.html',
//       //   dest: ROOT
//       // }
//     ];

//     var tasks = folders.map(function(path){
//         return gulp.src(path.src)
//           .pipe(plumber(function(err){
//             //this function will run WHEN an error occurs in this task
//             console.log('React Task Error');
//             console.log(err);
//             this.emit('end'); //this line will stop this task chain but continue running gulp
//           }))
//           //.pipe(replace(/<\/body><\/html>/g, ''))
//           .pipe(gulp.dest(path.dest));
//     });

//     return merge(tasks);
// });



// Process our SASS Files
function style() {
    return gulp
        .src(paths.styles.src)
        .pipe( through2.obj( function( file, enc, cb ) {
              let date = new Date();
              file.stat.atime = date;
              file.stat.mtime = date;
              cb( null, file );
        }) )
        // Initialize sourcemaps before compilation starts
        //.pipe(sourcemaps.init())
        .pipe(autoprefixer({
          browsers: ['last 2 versions']
        }))
        .pipe(sass())
        .pipe(rename({
            basename: "dev"
        }))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.stream())
        .pipe(sass({
          outputStyle: 'compressed'
        }))
        // Use postcss with autoprefixer and compress the compiled file using cssnano
        //.pipe(postcss([autoprefixer(), cssnano()]))
        // Now add/write the sourcemaps
        //.pipe(sourcemaps.write())
        .pipe(rename({
            basename: "live"
        }))
        .pipe(gulp.dest(paths.styles.dest))
        // Add browsersync stream pipe after compilation
        // .pipe(browserSync.stream());
}


// Process our Scripts
function scripts() {
    return gulp
        .src(paths.scripts.src)
        .pipe( through2.obj( function( file, enc, cb ) {
              let date = new Date();
              file.stat.atime = date;
              file.stat.mtime = date;
              cb( null, file );
        }) )
        //.pipe(sourcemaps.init())
        /*.pipe(babel({
          presets: ['es2015']
        }))*/
        .pipe(concat('dev.js'))
        .pipe(gulp.dest(THEME_PATH + '/js'))
        //.pipe(sourcemaps.write())
        .pipe(uglify({ mangle: false }))
        .pipe(concat('live.js'))
        .pipe(gulp.dest(THEME_PATH + '/js'));
        //.pipe(livereload());
}


function reload(done) {
  browserSync.reload();
  done();
}

// Add browsersync initialization at the start of the watch task
function watch() {
    browserSync.init({
        proxy: "http://localhost/"+THEME
    });

    gulp.watch(paths.styles.watch, gulp.series(style));
    gulp.watch(paths.scripts.watch, gulp.series(scripts, reload));
    gulp.watch(paths.php.watch, gulp.series(reload));
}


// Don't forget to expose the task!
exports.watch = watch

// Expose the task by exporting it
// This allows you to run it from the commandline using
// $ gulp style
exports.style = style;

exports.scripts = scripts;

/*
 * Specify if tasks run in series or parallel using `gulp.series` and `gulp.parallel`
 */
var build = gulp.parallel(style, scripts, watch);
 
/*
 * You can still use `gulp.task` to expose tasks
 */
gulp.task('build', build);
 
/*
 * Define default task that can be called by just running `gulp` from cli
 */
gulp.task('default', build);