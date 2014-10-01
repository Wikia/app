/**
 * Helper for handling JS events
 */
(function( context ){
	'use strict';

	function eventshelper() {
		var timers = [];

		/**
		 * Call the callback function after event is complete
		 *
		 * @param callback function
		 * @param ms time after which function will be called
		 * @param uniqueId event id
		 */
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
