/**
 * The module dependencies.
 */
const path = require('path');
const slash = require('slash');

// Base `src` path
module.exports.srcPath = (basePath = '', destPath = '') =>
	path.resolve(__dirname, '../', basePath, destPath);


// Base `build` path
module.exports.buildPath = (basePath = '', destPath = '') =>
	path.resolve(__dirname, '../', basePath, destPath);


// Base `src` path for scripts
module.exports.srcScriptsPath = destPath =>
	exports.srcPath('js', destPath);

// Base `src` path for stylesheets
module.exports.srcStylesPath = destPath =>
	exports.srcPath('scss', destPath);

// Base `src` path for images
module.exports.srcImagesPath = destPath =>
	exports.srcPath('images', destPath);

// Base `src` path for fonts
module.exports.srcFontsPath = destPath =>
	exports.srcPath('fonts', destPath);

// Base `src` path for vendor files
module.exports.srcVendorPath = destPath =>
	exports.srcPath('vendor', destPath);

// Base `build` path for scripts
module.exports.buildScriptsPath = destPath =>
	exports.buildPath('', destPath);

// Base `build` path for stylesheets
module.exports.buildStylesPath = destPath =>
	exports.buildPath('', destPath);

// Base `build` path for images
module.exports.buildImagesPath = destPath =>
	exports.buildPath('images', destPath);

// Base `build` path for fonts
module.exports.buildFontsPath = destPath =>
	exports.buildPath('fonts', destPath);

// Base `build` path for vendor files
module.exports.buildVendorPath = destPath =>
	exports.buildPath('vendor', destPath);

// Detect invironment type
module.exports.detectEnv = () => {
	const env = process.env.NODE_ENV || 'build';
	const isDev = env === 'development';
	const isProd = env === 'production';
	const isBuild = env === 'build';

	return {
		env,
		isDev,
		isProd,
		isBuild
	};
};
