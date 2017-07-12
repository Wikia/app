/**
 * A set of AMD modules wrapping local storage API
 */
define('wikia.localStorage', ['wikia.window'], function(window) {
	'use strict';

	try {
		window.localStorage.setItem('localStorageTestItem', 'testValue');
		window.localStorage.getItem('localStorageTestItem');

		return window.localStorage;
	} catch(err) {
		return {};
	}
});
