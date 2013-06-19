/**
 * Updates all links related to search to contain specified parameters.
 */
define('SearchAbTest.LinkUpdater' ,['jquery', 'wikia.log'], function( $, log ) {
	'use strict';
	var searchPaginationLinksSelector = '.wikia-paginator a.paginator-page, .search-tabs a';

	var LinkUpdater = {};

	/**
	 * Perform dom update
	 * @param params
	 */
	LinkUpdater.update = function(params) {
		if( !params ) return;
		$(searchPaginationLinksSelector).each(function() {
			var originalLink = $(this).attr('href'),
				modifiedLink = originalLink;
			for( var paramName in params ) {
				modifiedLink = modifiedLink + '&' + paramName + '=' + params[paramName];
			}
			log('Modifying link: ' + originalLink + " to " + modifiedLink, log.levels.debug, 'search');
			$(this).attr('href', modifiedLink);
		});
	};

	return LinkUpdater;
});
