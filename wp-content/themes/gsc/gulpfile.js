/**
 * The module dependencies.
 */
const del = require('del');
const path = require('path');
const gulp = require('gulp');
const sass = require('gulp-sass');
const utils = require('./config/utils');
const gulpif = require('gulp-if');
const rename = require('gulp-rename');
const notify = require('gulp-notify');
const postcss = require('gulp-postcss');
const plumber = require('gulp-plumber');
const webpack = require('webpack-stream');
const bundler = require('webpack');
const sourcemaps = require('gulp-sourcemaps');
const merge = require('merge-stream');
const sassGlob = require('gulp-sass-glob');

/**
 * Setup the env.
 */
const { isProd, isDev } = utils.detectEnv();

/**
 * Show notification on error.
 */
const error = function(e) {
	notify.onError({
		title: 'Gulp',
		message: e.message,
		sound: 'Beep'
	})(e);

	this.emit('end');
};

/**
 * Process Sass files through Sass and PostCSS.
 */
const styles = () => {
	const config = require('./config/postcss');
	const src = utils.srcStylesPath('style.scss');
	const srcEditor = utils.srcStylesPath('editor-style.scss');
	const styleSheets = ["style", "editor-style"];
	const dest = utils.buildStylesPath();

	let streams = [];
	styleSheets.forEach(function(sheet) {
		let src = utils.srcStylesPath(sheet+'.scss');
		let stream = gulp.src(src)
			.pipe(sassGlob())
			.pipe(gulpif(isDev, sourcemaps.init()))
			.pipe(
				sass({
					includePaths: [
						'.',
						utils.srcVendorPath(),
						path.resolve(__dirname, '../node_modules')
					]
				}).on('error', error)
			)
			.pipe(gulpif(isDev, plumber({ errorHandler: error })))
			.pipe(postcss(config))
			.pipe(rename(sheet+'.css'))
			.pipe(gulpif(isDev, sourcemaps.write('./')))
			.pipe(gulp.dest(dest));
		streams.push(stream);
	});

	return merge(streams);
};

/**
 * Process JS files through Webpack.
 */
const scripts = () => {
	const src = utils.srcScriptsPath('main.js');
	const dest = utils.buildScriptsPath();

	return gulp
		.src(src)
		.pipe(plumber({ errorHandler: error }))
		.pipe(gulpif(
			true,
			webpack(require('./config/webpack'), bundler),
			rename('bundle.js')
		))
		.pipe(gulp.dest(dest));
};


/**
 * Watch for changes and run through different tasks.
 */
const watch = () => {
	gulp.watch(
		[utils.srcStylesPath('*.scss'), utils.srcImagesPath('sprite/*.png'), `${utils.srcPath('{scss,css,fonts,images,components,vendor}/**')}`],
		styles
	);

	gulp.watch(
		[
			utils.srcPath('**'),
			`!${utils.srcPath('{scss,css,fonts,images,js,vendor}/')}`,
			`!${utils.srcPath('{scss,css,fonts,images,js,vendor}/**')}`,
			`!${utils.srcPath('{scss,css,fonts,images,js,vendor}/**/**')}`,
		],
	);

};

/**
 * Remove the build.
 */
const clean = () => {
	return true;
};

/**
 * Register the tasks.
 */
gulp.task(
	'dev',
	gulp.series(
		gulp.parallel(
			styles,
			scripts,
			watch
		)
	)
);

gulp.task(
	'build',
	gulp.series(styles, scripts)
);

/**
 * Register default gulp task.
 */
gulp.task('default', gulp.parallel('build'));
