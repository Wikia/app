define( 'SearchAbTest.DomUpdater', ['jquery', 'wikia.log'], function( $, log ) {
	'use strict';
	var searchPaginationLinksSelector = '.wikia-paginator a.paginator-page, .search-tabs a, a.paginator-next, a.paginator-prev',
		searchFormsSelector = 'form.WikiaSearch';

	return {
		/**
		 * Updates all links related to search to contain specified parameters.
		 */
		linkUpdater: {
			/**
			 * Perform dom update
			 * @param params
			 */
			update: function( params ) {
				if( !params ) {
					return;
				}
				var self = this;
				$(searchPaginationLinksSelector).each(function() {
					var originalLink = $(this).attr('href');
					if ( !!originalLink ) {
						var modifiedLink = self.modifyLink(originalLink, params);
						log('Modifying link: "' + originalLink + '" to "' + modifiedLink + '"', log.levels.debug, 'search');
						$(this).attr('href', modifiedLink);
					}
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
		},

		/**
		 * Updates all forms related to search to contain specified parameters.
		 * In other words it adds <input type="hidden">
		 */
		formUpdater: {
			/**
			 * perform dom update.
			 * @param params
			 */
			update: function( params ) {
				if( !params ) {
					return;
				}
				var $searchForms = $(searchFormsSelector);
				for( var paramName in params ) {
					var newInput = '<input type="hidden" name="' + paramName + '" value="' + params[paramName] + '">';
					$searchForms.append(newInput);
					log('Add new input: ' + newInput, log.levels.debug, 'search');
				}
			}
		}
	};

});
