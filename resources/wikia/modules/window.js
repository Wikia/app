/**
 * A set of AMD modules wrapping window and browser APIs:
 *  - local storage
 *  - location
 */
(function(context) {
	'use strict';

	define('window', function() {
		return context;
	});

	define('localStorage', function() {
		return context.localStorage;
	});

	define('location', function() {
		return context.location;
	});

}(this));
