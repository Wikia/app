/**
 * A set of AMD modules wrapping local storage API
 */
(function(context) {
	'use strict';

	define('wikia.localStorage', function() {
		return context.localStorage;
	});

}(this));
