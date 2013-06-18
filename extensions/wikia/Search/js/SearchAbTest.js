/**
 * This is workaround of fact that we have only front-end A/B testing platform at the moment.
 * This file contains modules responsible for passing A/B testing related parameters to php backend.
 * We do that by modifying dom. We add some parameters to search related forms and links.
 */
//try {
	/**
	 * Util to obtain window parameters.
	 * It's in separate module to make testing easier.
	 */
	define("SearchAbTest.WindowUtil", ['wikia.window'], function( window ) {
		'use strict';
		var WindowUtil = {};

		WindowUtil.getQueryParameters = function() {
			var queryString = window.location.search || '';
			var parameters = {};

			queryString.replace(
				new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){
					parameters[ $1 ] = $3;
				}
			);
			return parameters;
		};

		WindowUtil.getAbTestingParameters = function() {
			var parameters = {};
			var allParameters = this.getQueryParameters();
			for( var parameterName in allParameters ) {
				if( parameterName.indexOf('AbTest.') === 0 || parameterName == 'ab' ) {
					parameters[parameterName] = allParameters[parameterName];
				}
			}
			return parameters;};

		return WindowUtil;

	});

	/**
	 * Updates all forms related to search to contain specified parameters.
	 * In other words it adds <input type="hidden">
	 */
	define('SearchAbTest.FormUpdater' ,['jquery', 'wikia.log'], function( $, log ) {
		'use strict';
		var searchFormsSelector = 'form.WikiaSearch';

		var FormUpdater = {};

		FormUpdater.update = function(params) {
			if( !params ) return;
			var $searchForms = $(searchFormsSelector);
			for( var paramName in params ) {
				var newInput = '<input type="hidden" name="' + paramName + '" value="' + params[paramName] + '">';
				$searchForms.append(newInput);
				log('Add new input: ' + newInput, 'debug', 'search');
			}
		};

		return FormUpdater;

	});

	/**
	 * Updates all links related to search to contain specified parameters
	 */
	define('SearchAbTest.LinkUpdater' ,['jquery', 'wikia.log'], function( $, log ) {
		'use strict';
		var searchPaginationLinksSelector = '.wikia-paginator a.paginator-page, .search-tabs a';

		var LinkUpdater = {};

		LinkUpdater.update = function(params) {
			if( !params ) return;
			$(searchPaginationLinksSelector).each(function() {
				var originalLink = $(this).attr('href'),
					modifiedLink = originalLink;
				for( var paramName in params ) {
					modifiedLink = modifiedLink + '&' + paramName + '=' + params[paramName];
				}
				log('Modifying link: ' + originalLink + " to " + modifiedLink, 'debug', 'search');
				$(this).attr('href', modifiedLink);
			});
		};

		return LinkUpdater;
	});


	/**
	 * Provides ids of search related A/B test groups.
	 */
	define('SearchAbTest.GroupProvider' ,['wikia.window', 'wikia.log'], function( window, log ) {
		'use strict';
		// IF AbTests are absent THEN return dummy
		if ( !window || !window.Wikia || !window.Wikia.AbTest ) {
			log('AbTest is not present. Fallback to dummy SearchAbTest.GroupProvider', 'debug', 'search');
			return { getGroups: function() {return []}};
		}
		var AbTest = window.Wikia.AbTest;


		var SearchAbGroupsProvider = {};

		/**
		 * Gets list of all active A/B tests that are related to search.
		 * We make assumption that all search related A/B tests
		 * have name that starts with "Search" (case insensitive).
		 * @returns {Array}
		 */
		function findSearchRelatedExperiments() {
			var searchExperiments = [];
			var experiments = AbTest.getExperiments();
			for( var i = 0; i < experiments.length; i++ ) {
				if( experiments[i] && experiments[i].name && experiments[i].name.toUpperCase().indexOf('SEARCH') === 0 ) {
					// all experiments with name starting with search are considered search related
					searchExperiments.push(experiments[i]);
				}
			}
			log('Search related experiment groups = ' + searchExperiments.join(','), 'debug', 'search');
			return searchExperiments;
		}

		/**
		 * Gets list ids of all groups of current user in active A/B tests that are related to search.
		 * We make assumption that all search related A/B tests
		 * have name that starts with "Search" (case insensitive).
		 * @see findSearchRelatedExperiments
		 * @returns {Array}
		 */
		SearchAbGroupsProvider.getGroups = function() {
			var searchRelatedExperiments = findSearchRelatedExperiments();
			var groupIds = [];
			for( var i = 0; i < searchRelatedExperiments.length; i++ ) {
				if ( searchRelatedExperiments[i].group ) {
					groupIds.push( searchRelatedExperiments[i].group.id );
				}
			}
			log('Found A/B groups: ' + groupIds.join(',') , 'debug', 'search');
			return groupIds;
		};

		return SearchAbGroupsProvider;

	});

	require(['wikia.window', 'SearchAbTest.GroupProvider', 'SearchAbTest.WindowUtil', 'SearchAbTest.LinkUpdater', 'SearchAbTest.FormUpdater', 'wikia.log']
		, function( window, groupProvider, windowUtil, linkUpdater, formUpdater, log )  {
		'use strict';
		var abGroupParameterName = 'ab';
		if ( window.Wikia && window.Wikia.AbTest ) {
			log('AbTest is present. Enable Search A/B testing.', 'debug', 'search');
			var updaters = [ linkUpdater, formUpdater ];
			var groups = groupProvider.getGroups();
			/**
			 * url parameters that we want to enforce on search pages.
			 * parametersToEnforce = { 'ab' = 123 } means &ab=123 to search related urls
			 */
			var parametersToEnforce = {};

			if( groups.length ) {
				/* we want to add &ab=123,432 to parameter */
				parametersToEnforce[abGroupParameterName] = groups.join(',');
			}

			/**
			 * We also want to enforce all current ab testing parameters.
			 * When we already have ab=123 in current query string, we want
			 * it to stay there. At least until we don't leave search
			 */
			var abTestingParameters = windowUtil.getAbTestingParameters();
			for( var parameterName in abTestingParameters ) {
				parametersToEnforce[parameterName] = abTestingParameters[parameterName];
			}

			/**
			 * use all updaters to enforce parameters
			 */
			for( var i in updaters ) {
				updaters[i].update(parametersToEnforce);
			}
		}
	});
//} catch( exception ) {
//	/*
//	 * We don't want to break other scripts if something goes wrong.
//	 * Breaking rest of the site because of A/B testing is not worth it.
//	 * Swallow exception and write out log if possible
//	 */
//	if ( console && typeof(console.error) === 'function' ) { exception.stac
//		console.error("Unhandled exception in Search A/B testing.\n" + exception.name + ": ", exception.message + "\n" );
//		for ( var parameter in exception ) {
//			console.error(parameter + "= " + exception[parameter]);
//		}
//	}
//}
