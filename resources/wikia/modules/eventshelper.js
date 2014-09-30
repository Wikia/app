(function( context ){
	'use strict';

	function eventshelper() {
		var timers = [];

		function waitForFinalEvent(callback, ms, uniqueId) {
			if (!uniqueId) {
				return;
			}
			if (timers[uniqueId]) {
				clearTimeout (timers[uniqueId]);
			}
			timers[uniqueId] = setTimeout(callback, ms);
		}

		return {
			waitForFinalEvent: waitForFinalEvent
		};
	}

	if ( !context.Wikia ) {
		context.Wikia = {};
	}

	context.Wikia.EventsHelper = eventshelper( context );

	if ( context.define && context.define.amd ) {
		context.define( 'wikia.eventshelper', eventshelper );
	}
}(this));
