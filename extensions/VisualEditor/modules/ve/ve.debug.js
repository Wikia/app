/*global console */
/**
 * VisualEditor debugging methods.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Static variables */

ve.debug = true;

/* Static Methods */

/**
 * Logs data to the console.
 *
 * @static
 * @method
 * @param {Mixed} [...] Data to log
 */
ve.log = function () {
	Function.prototype.apply.call( console.log, console, arguments );
};

/**
 * Logs an object to the console.
 *
 * @static
 * @method
 * @param {Object} obj Object to log
 */
ve.dir = function () {
	Function.prototype.apply.call( console.dir, console, arguments );
};
