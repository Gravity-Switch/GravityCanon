/**
 * The module dependencies.
 */
const escapeRegEx = require('escape-string-regexp');
const { ProvidePlugin } = require('webpack');
const utils = require('./utils');

/**
 * Setup the env.
 */
const { isProd, isDev } = utils.detectEnv();

/**
 * Babel loader setup
 */
const babelLoader = {
	loader: 'babel-loader',
	options: {
		cacheDirectory: isDev,
		comments: false,
		babelrc: false,
		presets: [
			[
				'@babel/preset-env',
				{
					targets: {
						browsers: [
					    'last 1 version',
					    '> .25%',
					    'ie 10'
					  ]
					}
				}
			]
		]
	}
};

/**
 * Setup the plugins for different envs.
 */
const plugins = [
	new ProvidePlugin({
		$: 'jquery',
		jQuery: 'jquery'
	})
];

/**
 * Export the configuration.
 */
module.exports = {
	/**
	 * The mode.
	 *
	 * @since webpack@4.
	 */
	mode: isProd ? 'production' : 'development',

	/**
	 * The output.
	 */
	output: {
		filename: 'bundle.js'
	},

	/**
	 * Setup the transformations.
	 */
	module: {
		rules: [
			// Process JS files through Babel.
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [babelLoader]
			}
		],
		noParse: ['raty-js'].map(module => new RegExp(escapeRegEx(module)))
	},

	/**
	 * Resolve the dependencies that are available in the global scope.
	 */
	externals: {
		jquery: 'jQuery'
	},

	/**
	 * Setup the transformations.
	 */
	plugins,

	/**
	 * Setup the development tools.
	 */
	cache: isDev,
	bail: false,
	watch: isDev,
	devtool: isDev ? 'source-map' : false
};
