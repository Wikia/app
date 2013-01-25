/**
 * A set of AMD modules wrapping window and browser APIs:
 *  - local storage
 *  - location
 */
(function(context) {
	'use strict';

	define('wikia.window', function() {
		return context;
	});

	define('wikia.localStorage', function() {
		return context.localStorage;
	});

	define('wikia.location', function() {
		return context.location;
	});

}(this));
