/**
 * Util to obtain window parameters.
 * It's in separate module to make testing easier.
 */

define("SearchAbTest.WindowUtil", ['wikia.window'], function( window ) {
	'use strict';

	return {
		/**
		 * Returns map of parameters from query string
		 * if url is http://foo/bar?a=1&b=2&a=x it will return { a: 'x', b: '2'}
		 * @returns {{}}
		 */
		getQueryParameters: function() {
			var queryString = window.location.search || '';
			var parameters = {};

			queryString.replace(
				new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){
					parameters[ $1 ] = $3;
				}
			);
			return parameters;
		},

		/**
		 *
		 * @returns {{}}
		 */
		getAbTestingParameters: function() {
			var parameters = {};
			var allParameters = this.getQueryParameters();
			for( var parameterName in allParameters ) {
				if( parameterName.indexOf('AbTest.') === 0 || parameterName == 'ab' ) {
					parameters[parameterName] = allParameters[parameterName];
				}
			}
			return parameters;
		}
	};

});
