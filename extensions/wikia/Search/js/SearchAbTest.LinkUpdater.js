/**
 * Updates all links related to search to contain specified parameters.
 */
define('SearchAbTest.LinkUpdater' ,['jquery', 'wikia.log'], function( $, log ) {
	'use strict';
	var searchPaginationLinksSelector = '.wikia-paginator a.paginator-page, .search-tabs a';

	return {
		/**
		 * Perform dom update
		 * @param params
		 */
		update: function(params) {
			if( !params ) return;
			var self = this;
			$(searchPaginationLinksSelector).each(function() {
				var originalLink = $(this).attr('href');
				var modifiedLink = self.modifyLink(originalLink, params);
				log('Modifying link: "' + originalLink + '" to "' + modifiedLink + '"', log.levels.debug, 'search');
				$(this).attr('href', modifiedLink);
			});
		},

		/**
		 * Adds parameters to link and returns modified link.
		 * if originalLink="http://domain/path?asd" and params={foo: 'bar'} then return http://domain/path?asd&foo=bar
		 * @param originalLink
		 * @param params params that we want to add to link
		 * @returns string modified link
		 */
		modifyLink: function(originalLink, params) {
			params = params || {};
			var modifiedLink = originalLink;
			var joinCharacter = "?";
			if ( originalLink.indexOf('?') > -1 ) {
				joinCharacter = "&";
			}
			if ( originalLink.indexOf('?') == originalLink.length - 1 ) {
				joinCharacter = '';
			}
			for( var paramName in params ) {
				modifiedLink = modifiedLink + joinCharacter + paramName + '=' + params[paramName];
				joinCharacter = "&";
			}
			return modifiedLink;
		}
	};

});
