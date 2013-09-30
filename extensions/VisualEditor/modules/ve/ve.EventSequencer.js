/*!
 * VisualEditor EventSequencer class.
 *
 * @copyright 2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * EventSequencer class with on-event and after-event listeners.
 *
 * After-event listeners are fired as soon as possible after the
 * corresponding native event. They are similar to the setTimeout(f, 0)
 * idiom, except that they are guaranteed to execute before any subsequent
 * on-event listener. Therefore, events are executed in the 'right order'.
 *
 * This matters when many events are added to the event queue in one go.
 * For instance, browsers often queue 'keydown' and 'keypress' in immediate
 * sequence, so a setTimeout(f, 0) defined in the keydown listener will run
 * *after* the keypress listener (i.e. in the 'wrong' order). EventSequencer
 * ensures that this does not happen.
 *
 * All listeners receive the jQuery event as an argument. If an on-event
 * listener needs to pass information to a corresponding after-event listener,
 * it can do so by adding properties into the jQuery event itself.
 *
 * @class ve.EventSequencer
 */

/**
 *
 * To fire after-event listeners promptly, the EventSequencer may need to
 * listen to some events for which it has no registered on-event or
 * after-event listeners. For instance, to ensure an after-keydown listener
 * is be fired before the native keyup action, you must include both
 * 'keydown' and 'keyup' in the eventNames Array.
 *
 * @constructor
 * @param {string[]} eventNames List of event Names to listen to
 */
ve.EventSequencer = function VeEventSequencer( eventNames ) {
	var i, len, eventName, eventSequencer = this;
	this.$node = null;
	this.eventNames = eventNames;
	this.eventHandlers = {};

	/**
	 * Generate an event handler for a specific event
	 *
	 * @private
	 * @param {string} eventName The event's name
	 * @returns {Function} An event handler
	 */
	function makeEventHandler( eventName ) {
		return function ( ev ) {
			return eventSequencer.onEvent( eventName, ev );
		};
	}

	/**
	 * @property {Object[]}
	 *  - id {number} Id for setTimeout
	 *  - func {Function} Post-event listener
	 *  - ev {jQuery.Event} Browser event
	 *  - eventName {string} Name, such as keydown
	 */
	this.pendingCalls = [];

	/**
	 * @property {Object.<string,Function>}
	 */
	this.onListenersForEvent = {};

	/**
	 * @property {Object.<string,Function>}
	 */
	this.afterListenersForEvent = {};

	for ( i = 0, len = eventNames.length; i < len; i++ ) {
		eventName = eventNames[i];
		this.onListenersForEvent[eventName] = [];
		this.afterListenersForEvent[eventName] = [];
		this.eventHandlers[eventName] = makeEventHandler( eventName );
	}
};

/**
 * Attach to a node, to listen to its jQuery events
 *
 * @method
 * @param {jQuery} $node The node to attach to
 */
ve.EventSequencer.prototype.attach = function ( $node ) {
	this.detach();
	this.$node = $node.on( this.eventHandlers );
};

/**
 * Detach from a node (if attached), to stop listen to its jQuery events
 *
 * @method
 */
ve.EventSequencer.prototype.detach = function () {
	if ( this.$node === null ) {
		return;
	}
	this.runPendingCalls();
	this.$node.off( this.eventHandlers );
	this.$node = null;
};


/**
 * Add listeners to be fired just before the browser native action
 * @method
 * @param {Object.<string,Function>} listeners Function for each event
 */
ve.EventSequencer.prototype.on = function ( listeners ) {
	var eventName;
	for ( eventName in listeners ) {
		this.onListenersForEvent[eventName].push( listeners[eventName] );
	}
};


/**
 * Add listeners to be fired as soon as possible after the native action
 * @method
 * @param {Object.<string,Function>} listeners Function for each event
 */
ve.EventSequencer.prototype.after = function ( listeners ) {
	var eventName;
	for ( eventName in listeners ) {
		this.afterListenersForEvent[eventName].push( listeners[eventName] );
	}
};

/**
 * Generic listener method which does the sequencing
 * @private
 * @method
 * @param {string} eventName Javascript name of the event, e.g. 'keydown'
 * @param {jQuery.Event} ev The browser event
 */
ve.EventSequencer.prototype.onEvent = function ( eventName, ev ) {
	var i, len, onListener, afterListener, pendingCall;
	this.runPendingCalls();
	// Length cache 'len' is required, as an onListener could add another onListener
	for ( i = 0, len = this.onListenersForEvent[eventName].length; i < len; i++ ) {
		onListener = this.onListenersForEvent[eventName][i];
		onListener( ev );
	}
	// Length cache 'len' for style only
	for ( i = 0, len = this.afterListenersForEvent[eventName].length; i < len; i++ ) {
		afterListener = this.afterListenersForEvent[eventName][i];

		// Create a cancellable pending call
		// - Create the pendingCall object first
		// - then create the setTimeout invocation to modify pendingCall.id
		// - then set pendingCall.id to the setTimeout id, so the call can cancel itself
		// Must wrap everything in a function call, to create the required closure.
		pendingCall = { 'func': afterListener, 'id': null, 'ev': ev, 'eventName': eventName };
		/*jshint loopfunc:true */
		( function ( pendingCall, ev ) {
			var id = setTimeout( function () {
				if ( pendingCall.id === null ) {
					// clearTimeout seems not always to work immediately
					return;
				}
				pendingCall.id = null;
				pendingCall.func( ev );
			} );
			pendingCall.id = id;
		} )( pendingCall, ev );
		/*jshint loopfunc:false */
		this.pendingCalls.push( pendingCall );
	}
};

/**
 * Run any pending listeners, and clear the pending queue
 * @private
 * @method
 */
ve.EventSequencer.prototype.runPendingCalls = function () {
	var i, pendingCall;
	for ( i = 0; i < this.pendingCalls.length; i++ ) {
		// Length cache not possible, as a pending call appends another pending call.
		// It's important that this list remains mutable, in the case that this
		// function indirectly recurses.
		pendingCall = this.pendingCalls[i];
		if ( pendingCall.id === null ) {
			// the call has already run
			continue;
		}
		clearTimeout( pendingCall.id );
		pendingCall.id = null;
		// Force to run now. It's important that we set id to null before running,
		// so that there's no chance a recursive call will call the listener again.
		pendingCall.func( pendingCall.ev );
	}
	// This is safe because we only ever appended to the list, so it's definitely exhausted
	// now.
	this.pendingCalls.length = 0;
};
