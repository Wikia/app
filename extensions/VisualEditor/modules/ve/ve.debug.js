/*global console */
/*!
 * VisualEditor debugging methods.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @property {boolean} debug
 * @member ve
 */
ve.debug = true;

/**
 * @class ve.debug
 * @override ve
 * @singleton
 */

/* Methods */

/**
 * Logs data to the console.
 *
 * @method
 * @param {Mixed...} [data] Data to log
 */
ve.log = function () {
	// In IE9 console methods are not real functions and as such do not inherit
	// from Function.prototype, thus console.log.apply does not exist.
	// However it is function-like enough that passing it to Function#apply does work.
	Function.prototype.apply.call( console.log, console, arguments );
};

/**
 * Logs an object to the console.
 *
 * @method
 * @param {Object} obj Object to log
 */
ve.dir = function () {
	Function.prototype.apply.call( console.dir, console, arguments );
};
