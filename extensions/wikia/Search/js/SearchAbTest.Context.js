/**
 * Provides ids of search related A/B test groups.
 */
define( 'SearchAbTest.Context' ,[
		'wikia.window',
		'wikia.log',
		'wikia.querystring'
	], function( window, log, querystring ) {
	'use strict';
	// IF AbTests are absent THEN return dummy
	if ( !window || !window.Wikia || !window.Wikia.AbTest ) {
		log( 'AbTest is not present. Fallback to dummy SearchAbTest.GroupProvider', log.levels.debug, 'search' );
		return {
			getAbTestGroups: function() {
				return [];
			},
			getAbTestParameters: function() {
				return {};
			},
			getQueryParameters: function() {
				return {};
			}
		};
	}
	var AbTest = window.Wikia.AbTest;

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
			var experiment = experiments[i];
			if( experiment && experiment.name && experiment.name.toUpperCase().indexOf('SEARCH') === 0 ) {
				// all experiments with name starting with search are considered search related
				searchExperiments.push(experiment);
			}
		}
		return searchExperiments;
	}

	return {

		/**
		 * Gets list ids of all groups of current user in active A/B tests that are related to search.
		 * We make assumption that all search related A/B tests
		 * have name that starts with "Search" (case insensitive).
		 * @see findSearchRelatedExperiments
		 * @returns {Array}
		 */
		getAbTestGroups: function() {
			var searchRelatedExperiments = findSearchRelatedExperiments();
			var groupIds = [];
			for( var i = 0; i < searchRelatedExperiments.length; i++ ) {
				if ( searchRelatedExperiments[i].group ) {
					groupIds.push( searchRelatedExperiments[i].group.id );
				}
			}
			log('Found A/B groups: ' + groupIds.join(',') , log.levels.debug, 'search');
			return groupIds;
		},

		getQueryParameters: function() {
			var str = querystring(window.location.url);
			return str.getVals();
		},

		/**
		 * Returns parameters related to A/B testing.
		 * That is all parameters that starts with AbTest.* and ab parameter
		 * @returns {Object}
		 */
		getAbTestParameters: function() {
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
