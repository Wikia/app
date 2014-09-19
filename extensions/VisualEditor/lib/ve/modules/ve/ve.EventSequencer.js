/*!
 * VisualEditor EventSequencer class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * This matters when many events are added to the task queue in one go.
 * For instance, browsers often queue 'keydown' and 'keypress' in immediate
 * sequence, so a setTimeout(f, 0) defined in the keydown listener will run
 * *after* the keypress listener (i.e. in the 'wrong' order). EventSequencer
 * ensures that this does not happen.
 *
 * All these listeners receive the jQuery event as an argument. If an on-event
 * listener needs to pass information to a corresponding after-event listener,
 * it can do so by adding properties into the jQuery event itself.
 *
 * There are also 'onLoop' and 'afterLoop' listeners, which only fire once per
 * Javascript event loop iteration, respectively before and after all the
 * other listeners fire.
 *
 * For further event loop / task queue information, see:
 * http://www.whatwg.org/specs/web-apps/current-work/multipage/webappapis.html#event-loops
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
	 * @property {Object.<string,Function[]>}
	 */
	this.onListenersForEvent = {};

	/**
	 * @property {Object.<string,Function[]>}
	 */
	this.afterListenersForEvent = {};

	/**
	 * @property {Object.<string,Function[]>}
	 */
	this.afterOneListenersForEvent = {};

	for ( i = 0, len = eventNames.length; i < len; i++ ) {
		eventName = eventNames[i];
		this.onListenersForEvent[eventName] = [];
		this.afterListenersForEvent[eventName] = [];
		this.afterOneListenersForEvent[eventName] = [];
		this.eventHandlers[eventName] = makeEventHandler( eventName );
	}

	/**
	 * @property {Function[]}
	 */
	this.onLoopListeners = [];

	/**
	 * @property {Function[]}
	 */
	this.afterLoopListeners = [];

	/**
	 * @property {Function[]}
	 */
	this.afterLoopOneListeners = [];

	/**
	 * @property {boolean}
	 */
	this.doneOnLoop = false;

	/**
	 * @property {number}
	 */
	this.afterLoopTimeoutId = null;
};

/**
 * Attach to a node, to listen to its jQuery events
 *
 * @method
 * @param {jQuery} $node The node to attach to
 * @chainable
 */
ve.EventSequencer.prototype.attach = function ( $node ) {
	this.detach();
	this.$node = $node.on( this.eventHandlers );
	return this;
};

/**
 * Detach from a node (if attached), to stop listen to its jQuery events
 *
 * @method
 * @chainable
 */
ve.EventSequencer.prototype.detach = function () {
	if ( this.$node === null ) {
		return;
	}
	this.runPendingCalls();
	this.$node.off( this.eventHandlers );
	this.$node = null;
	return this;
};

/**
 * Add listeners to be fired at the start of the Javascript event loop iteration
 * @method
 * @param {Function[]} listeners Listeners that take no arguments
 * @chainable
 */
ve.EventSequencer.prototype.onLoop = function ( listeners ) {
	Array.prototype.push.apply( this.onLoopListeners, listeners );
	return this;
};

/**
 * Add listeners to be fired just before the browser native action
 * @method
 * @param {Object.<string,Function>} listeners Function for each event
 * @chainable
 */
ve.EventSequencer.prototype.on = function ( listeners ) {
	var eventName;
	for ( eventName in listeners ) {
		this.onListenersForEvent[eventName].push( listeners[eventName] );
	}
	return this;
};

/**
 * Add listeners to be fired as soon as possible after the native action
 * @method
 * @param {Object.<string,Function>} listeners Function for each event
 * @chainable
 */
ve.EventSequencer.prototype.after = function ( listeners ) {
	var eventName;
	for ( eventName in listeners ) {
		this.afterListenersForEvent[eventName].push( listeners[eventName] );
	}
	return this;
};

/**
 * Add listeners to be fired once, as soon as possible after the native action
 * @method
 * @param {Object.<string,Function[]>} listeners Function for each event
 * @chainable
 */
ve.EventSequencer.prototype.afterOne = function ( listeners ) {
	var eventName;
	for ( eventName in listeners ) {
		this.afterOneListenersForEvent[eventName].push( listeners[eventName] );
	}
	return this;
};

/**
 * Add listeners to be fired at the end of the Javascript event loop iteration
 * @method
 * @param {Function|Function[]} listeners Listener(s) that take no arguments
 * @chainable
 */
ve.EventSequencer.prototype.afterLoop = function ( listeners ) {
	if ( !ve.isArray( listeners ) ) {
		listeners = [listeners];
	}
	Array.prototype.push.apply( this.afterLoopListeners, listeners );
	return this;
};

/**
 * Add listeners to be fired once, at the end of the Javascript event loop iteration
 * @method
 * @param {Function|Function[]} listeners Listener(s) that take no arguments
 * @chainable
 */
ve.EventSequencer.prototype.afterLoopOne = function ( listeners ) {
	if ( !ve.isArray( listeners ) ) {
		listeners = [listeners];
	}
	Array.prototype.push.apply( this.afterLoopOneListeners, listeners );
	return this;
};

/**
 * Generic listener method which does the sequencing
 * @private
 * @method
 * @param {string} eventName Javascript name of the event, e.g. 'keydown'
 * @param {jQuery.Event} ev The browser event
 */
ve.EventSequencer.prototype.onEvent = function ( eventName, ev ) {
	var i, len, onListener, onListeners, pendingCall, eventSequencer, id;
	this.runPendingCalls();
	if ( !this.doneOnLoop ) {
		this.doneOnLoop = true;
		this.doOnLoop();
	}

	onListeners = this.onListenersForEvent[ eventName ] || [];

	// Length cache 'len' is required, as an onListener could add another onListener
	for ( i = 0, len = onListeners.length; i < len; i++ ) {
		onListener = onListeners[i];
		onListener( ev );
	}
	// Queue a call to afterEvent only if there are some
	// afterListeners/afterOneListeners/afterLoopListeners
	if ( ( this.afterListenersForEvent[eventName] || [] ).length > 0 ||
		( this.afterOneListenersForEvent[eventName] || [] ).length > 0 ||
		this.afterLoopListeners.length > 0 ) {
		// Create a cancellable pending call
		// - Create the pendingCall object first
		// - then create the setTimeout invocation to modify pendingCall.id
		// - then set pendingCall.id to the setTimeout id, so the call can cancel itself
		pendingCall = { 'id': null, 'ev': ev, 'eventName': eventName };
		eventSequencer = this;
		id = this.postpone( function () {
			if ( pendingCall.id === null ) {
				// clearTimeout seems not always to work immediately
				return;
			}
			eventSequencer.resetAfterLoopTimeout();
			pendingCall.id = null;
			eventSequencer.afterEvent( eventName, ev );
		} );
		pendingCall.id = id;
		this.pendingCalls.push( pendingCall );
	}
};

/**
 * Generic after listener method which gets queued
 * @private
 * @method
 * @param {string} eventName Javascript name of the event, e.g. 'keydown'
 * @param {jQuery.Event} ev The browser event
 */
ve.EventSequencer.prototype.afterEvent = function ( eventName, ev ) {
	var i, len, afterListeners, afterOneListeners;

	// Snapshot the listener lists, and blank *OneListener list.
	// This ensures reasonable behaviour if a function called adds another listener.
	afterListeners = ( this.afterListenersForEvent[eventName] || [] ).slice();
	afterOneListeners = ( this.afterOneListenersForEvent[eventName] || [] ).slice();
	( this.afterOneListenersForEvent[eventName] || [] ).length = 0;

	for ( i = 0, len = afterListeners.length; i < len; i++ ) {
		afterListeners[i]( ev );
	}

	for ( i = 0, len = afterOneListeners.length; i < len; i++ ) {
		afterOneListeners[i]( ev );
	}
};

/**
 * Call each onLoopListener once
 * @private
 * @method
 */
ve.EventSequencer.prototype.doOnLoop = function () {
	var i, len;
	// Length cache 'len' is required, as the functions called may add another listener
	for ( i = 0, len = this.onLoopListeners.length; i < len; i++ ) {
		this.onLoopListeners[i]();
	}
};

/**
 * Call each afterLoopListener once, unless the setTimeout is already cancelled
 * @private
 * @method
 * @param {number} myTimeoutId The calling setTimeout id
 */
ve.EventSequencer.prototype.doAfterLoop = function ( myTimeoutId ) {
	var i, len, afterLoopListeners, afterLoopOneListeners;

	if ( this.afterLoopTimeoutId !== myTimeoutId ) {
		// cancelled; do nothing
		return;
	}
	this.afterLoopTimeoutId = null;

	// Snapshot the listener lists, and blank *OneListener list.
	// This ensures reasonable behaviour if a function called adds another listener.
	afterLoopListeners = this.afterLoopListeners.slice();
	afterLoopOneListeners = this.afterLoopOneListeners.slice();
	this.afterLoopOneListeners.length = 0;

	for ( i = 0, len = this.afterLoopListeners.length; i < len; i++ ) {
		this.afterLoopListeners[i]();
	}

	for ( i = 0, len = this.afterLoopOneListeners.length; i < len; i++ ) {
		this.afterLoopOneListeners[i]();
	}
};

/**
 * Push any pending doAfterLoop to end of task queue (cancel, then re-set)
 * @private
 * @method
 */
ve.EventSequencer.prototype.resetAfterLoopTimeout = function () {
	var timeoutId, eventSequencer = this;
	if ( this.afterLoopTimeoutId !== null ) {
		this.cancelPostponed( this.afterLoopTimeoutId );
	}
	timeoutId = this.postpone( function () {
		eventSequencer.doAfterLoop( timeoutId );
	} );
	this.afterLoopTimeoutId = timeoutId;
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
		this.cancelPostponed( pendingCall.id );
		pendingCall.id = null;
		// Force to run now. It's important that we set id to null before running,
		// so that there's no chance a recursive call will call the listener again.
		this.afterEvent( pendingCall.eventName, pendingCall.ev );
	}
	// This is safe because we only ever appended to the list, so it's definitely exhausted
	// now.
	this.pendingCalls.length = 0;
};

/**
 * Make a postponed call.
 *
 * This is a separate function because that makes it easier to replace when testing
 *
 * @param {Function} callback The function to call
 * @returns {number} Unique postponed timeout id
 */
ve.EventSequencer.prototype.postpone = function ( callback ) {
	return setTimeout( callback );
};

/**
 * Cancel a postponed call.
 *
 * This is a separate function because that makes it easier to replace when testing
 *
 * @param {number} callId Unique postponed timeout id
 */
ve.EventSequencer.prototype.cancelPostponed = function ( timeoutId ) {
	clearTimeout( timeoutId );
};
