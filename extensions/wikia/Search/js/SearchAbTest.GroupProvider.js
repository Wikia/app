/**
 * Provides ids of search related A/B test groups.
 */
define('SearchAbTest.GroupProvider' ,['wikia.window', 'wikia.log'], function( window, log ) {
	'use strict';
	// IF AbTests are absent THEN return dummy
	if ( !window || !window.Wikia || !window.Wikia.AbTest ) {
		log('AbTest is not present. Fallback to dummy SearchAbTest.GroupProvider', log.levels.debug, 'search');
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
		log('Search related experiment groups = ' + searchExperiments.join(','), log.levels.debug, 'search');
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
		log('Found A/B groups: ' + groupIds.join(',') , log.levels.debug, 'search');
		return groupIds;
	};

	return SearchAbGroupsProvider;

});
