/*!
 * VisualEditor tracking methods.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

( function () {
	var callbacks = $.Callbacks( 'memory' ), queue = [];

	/**
	 * Track an analytic event.
	 *
	 * VisualEditor uses this method internally to track internal changes of state that are of analytic
	 * interest, either because they provide data about how users interact with the editor, or because
	 * they contain exception info, latency measurements, or other metrics that help gauge performance
	 * and reliability. VisualEditor does not transmit these events by default, but it provides a
	 * generic interface for routing these events to an analytics framework.
	 *
	 * @member ve
	 * @param {string} name Event name
	 * @param {Mixed...} [data] Data to log
	 */
	ve.track = function () {
		queue.push( { context: { timeStamp: ve.now() }, args: arguments } );
		callbacks.fire( queue );
	};

	/**
	 * Register a handler for analytic events.
	 *
	 * Handlers will be called once for each tracked event, including any events that fired before the
	 * handler was registered; 'this' is set to a plain object with a 'timeStamp' property indicating
	 * the exact time at which the event fired.
	 *
	 * @member ve
	 * @param {Function} callback
	 */
	ve.trackRegisterHandler = function ( callback ) {
		var invocation, seen = 0;
		callbacks.add( function ( queue ) {
			for ( ; seen < queue.length; seen++ ) {
				invocation = queue[ seen ];
				callback.apply( invocation.context, invocation.args );
			}
		} );
	};
}() );
