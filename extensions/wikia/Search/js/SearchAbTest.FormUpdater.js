/**
 * Updates all forms related to search to contain specified parameters.
 * In other words it adds <input type="hidden">
 */
define('SearchAbTest.FormUpdater' ,['jquery', 'wikia.log'], function( $, log ) {
	'use strict';
	var searchFormsSelector = 'form.WikiaSearch';

	return {
		/**
		 * perform dom update.
		 * @param params
		 */
		update: function(params) {
			if( !params ) return;
			var $searchForms = $(searchFormsSelector);
			for( var paramName in params ) {
				var newInput = '<input type="hidden" name="' + paramName + '" value="' + params[paramName] + '">';
				$searchForms.append(newInput);
				log('Add new input: ' + newInput, log.levels.debug, 'search');
			}
		}
	};

});
