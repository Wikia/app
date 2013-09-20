/**
 * This is workaround of fact that we have only front-end A/B testing platform at the moment.
 * This file contains modules responsible for passing A/B testing related parameters to php backend.
 * We do that by modifying dom. We add some parameters to search related forms and links.
 */
require([
		'wikia.window',
		'SearchAbTest.Context',
		'SearchAbTest.DomUpdater',
		'wikia.log'
	], function( window, context, domUpdater, log )  {
	'use strict';
	var abGroupParameterName = 'ab';

	if ( window.Wikia && window.Wikia.AbTest ) {
		log('AbTest is present. Enable Search A/B testing.', log.levels.debug, 'search');
		var updaters = [ domUpdater.linkUpdater, domUpdater.formUpdater ];
		var groups = context.getAbTestGroups();
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
		var abTestingParameters = context.getAbTestParameters();
		for( var parameterName in abTestingParameters ) {
			parametersToEnforce[parameterName] = abTestingParameters[parameterName];
		}

		/**
		 * use all updaters to enforce parameters
		 */
		for( var i = 0; i < updaters.length; i++ ) {
			updaters[i].update(parametersToEnforce);
		}
	}
});
