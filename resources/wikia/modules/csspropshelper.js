/**
 * Helper module for checking if CSS3 property is supported by the browser and returning this property in JS
 * camel case style formatting. Useful when you set CSS properties in javascript.
 *
 * Example: you want to set 'transform-origin' in JS
 *
 *          calling 'getCSSPropName(transform-origin)' returns 'transformOrigin'
 *          with or without browser prefix based on the current browser
 *          (WebkitTransformOrigin, MozTransformOrigin, msTransformOrigin, OTransformOrigin)
 *
 * @author: Rafal Leszczynski <rafal(at)wikia-inc.com>
 */


define('wikia.csspropshelper', ['wikia.document'], function(document) {
	'use strict';

	var prefixArray = ['Moz', 'webkit', 'ms', 'O'],
		prefixArrayLength = prefixArray.length;

	/**
	 * Find CSS3 property name supported by browser
	 *
	 * @param {[]} propArray - Array CSS3 property names for different browsers
	 *
	 * @return {string||boolean} CSS3 property name
	 */

	function checkForSupportedProp(propArray) {
		var root = document.documentElement,
			i,
			length = propArray.length;

		for (i = 0; i < length; i++) {
			var prop = propArray[i];
			if (prop in root.style) {
				return prop;
			}
		}
		return false;
	}


	/**
	 * Create an array with browser prefixed CSS property names
	 *
	 * @param {string} prop - JS camel case style property name
	 *
	 * @return {[]} array of prefixed CSS properties
	 */

	function createPropArray(prop) {
		var i,
			result = [prop],
			formattedProp = prop.charAt(0).toUpperCase() + prop.slice(1);

		for (i = 0; i < prefixArrayLength; i++) {
			var str = prefixArray[i] + formattedProp;
			result.push(str);
		}

		return result;
	}

	/**
	 * Public API method for converting CSS property name to JS camel case style
	 *
	 * @param {string} prop - CSS style property name
	 *
	 * @return {string} JS camel case styleproperty name
	 */

	function formatName(prop) {
		var i,
			tempArray = prop.split('-'),
			length = tempArray.length,
			result = [tempArray[0]];

		for (i = 1; i < length; i++) {
			var tempStr = tempArray[i],
				str = tempStr.charAt(0).toUpperCase() + tempStr.slice(1);
			result.push(str)
		}
		return result.join('');
	}

	/**
	 * Public API method for getting CSS property name supported by current browser
	 *
	 * @param {string} prop - CSS style property name
	 *
	 * @return {string} JS camel case style property name supported by current browser
	 * @throw {Error} when property is not supported
	 */

	function getSupportedProp(prop) {
		var formattedProp = formatName(prop),
			prefixedPropArray = createPropArray(formattedProp),
			supportedProp = checkForSupportedProp(prefixedPropArray);

		if (supportedProp === false) {
			throw new Error('Requested CSS property - ' + prop + ' is not supported by your browser!');
		}
		return supportedProp;

	}

	/** @public **/

	return {
		formatName: formatName,
		getSupportedProp: getSupportedProp
	}

});
