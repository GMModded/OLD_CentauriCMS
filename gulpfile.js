// gulpfile.js made for :: Gulp v4
// => Due to changes of how tasks working in version (from 3 to) 4 of gulp,
//    this can be used either as template (for testing purposes)
//    or for productive [deployment] tasks.

// ============================================================================================================
// Definitions
var gulp     = require('gulp');
	clean    = require('gulp-clean');
	watch    = require('gulp-watch');
	concat   = require('gulp-concat');
	uglify   = require('gulp-uglify');
	sass     = require('gulp-sass');
	minify   = require('gulp-minify-css');


// ============================================================================================================
// Configurations
	inputSrc = 'Assets/';
	outputSrc = 'public/';
	fileName = 'centauri.min';


// ============================================================================================================
// For downloaded (via package-manager-tools (e.g. npm, yarn, pmt, etc.))
// => when you'd like to use the downloaded package / module,
//    you've to link it here in order the task for js recognize it and concat & uglifys it.
// NOTE: Watch out for case-sensivity of directory names!
	var modules = {
		"jquery"      : "packages/jquery/dist/jquery.min.js",
		"jquery-ui"   : "packages/jquery-ui/jquery-ui.min.js",
		"mdbootstrap" : "packages/mdbootstrap/js/mdb.min.js",
		"ckeditor"    : "packages/ckeditor/ckeditor.js"
	};



// ============================================================================================================
// CSS Tasks

gulp.task('css:build', function() {
	return gulp.src(inputSrc + "scss/main.scss")
		.pipe(sass().on('error', sass.logError))
		.pipe(concat(fileName + ".css"))
		.pipe(gulp.dest(outputSrc + "css"))
});
gulp.task('css:deploy', function() {
	return gulp.src(inputSrc + "scss/main.scss")
		.pipe(sass().on('error', sass.logError))
		.pipe(concat(fileName + ".css"))
		.pipe(minify())
		.pipe(gulp.dest(outputSrc + "css"))
});

// ============================================================================================================
// JS Tasks

gulp.task('js:build', function() {
	return gulp.src([
		modules["jquery"],
		modules["jquery-ui"],
		modules["mdbootstrap"],
		inputSrc + "js/**/*.js"
	])
	.pipe(concat(fileName + ".js"))
	.pipe(gulp.dest(outputSrc + "js"))
});
gulp.task('js:deploy', function() {
	return gulp.src([
		modules["jquery"],
		modules["jquery-ui"],
		modules["mdbootstrap"],
		inputSrc + "js/**/*.js"
	])
	.pipe(concat(fileName + ".js"))
	.pipe(uglify())
	.pipe(gulp.dest(outputSrc + "js"));
});
// ============================================================================================================



// ============================================================================================================
// Build with Watcher Task

gulp.task('watch:build:task', function() {
	gulp.watch(inputSrc + "scss/**/*.{sass,scss}", gulp.series('css:build'));
	gulp.watch(inputSrc + "js/**/*.js", gulp.series('js:build'));
});

gulp.task('watch:build', gulp.series('css:build', 'js:build',
	gulp.parallel('watch:build:task')
));

gulp.task('build', gulp.series('css:build', 'js:build',
	gulp.parallel('watch:build')
));
// ============================================================================================================



// ============================================================================================================
// Deploy with Watcher Task

gulp.task('watch:deploy:task', function() {
	gulp.watch(inputSrc + "scss/**/*.{sass,scss}", gulp.series('css:deploy'));
	gulp.watch(inputSrc + "js/**/*.js", gulp.series('js:deploy'));
});

gulp.task('watch:deploy', gulp.series('css:deploy', 'js:deploy', gulp.parallel('watch:deploy:task')));
gulp.task('watch:deploy', gulp.series('css:deploy', 'js:deploy', gulp.parallel('watch:deploy')));
// ============================================================================================================



// ============================================================================================================
// Simple deploy task

gulp.task("deploy", gulp.series("css:deploy", "js:deploy"));
// ============================================================================================================
