/**
 * VisualEditor EventEmitter class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Event emitter.
 *
 * @class
 * @abstract
 * @constructor
 * @property {Object} events
 */
ve.EventEmitter = function VeEventEmitter() {
	// Properties
	this.events = {};
};

/* Methods */

/**
 * Emits an event.
 *
 * @method
 * @param {String} type Type of event
 * @param {Mixed} args First in a list of variadic arguments passed to event handler (optional)
 * @returns {Boolean} If event was handled by at least one listener
 */
ve.EventEmitter.prototype.emit = function ( type ) {
	if ( type === 'error' && !( 'error' in this.events ) ) {
		throw new Error( 'Missing error handler error.' );
	}
	if ( !( type in this.events ) ) {
		return false;
	}
	var i,
		listeners = this.events[type].slice(),
		length = listeners.length,
		args = Array.prototype.slice.call( arguments, 1 );
	for ( i = 0; i < length; i++ ) {
		listeners[i].apply( this, args );
	}
	return true;
};

/**
 * Adds a listener to events of a specific type.
 *
 * @method
 * @param {String} type Type of event to listen to
 * @param {Function} listener Listener to call when event occurs
 * @returns {ve.EventEmitter} This object
 * @throws "Invalid listener error" if listener argument is not a function
 */
ve.EventEmitter.prototype.addListener = function ( type, listener ) {
	if ( typeof listener !== 'function' ) {
		throw new Error( 'Invalid listener error. Function expected.' );
	}
	this.emit( 'newListener', type, listener );
	if ( type in this.events ) {
		this.events[type].push( listener );
	} else {
		this.events[type] = [listener];
	}
	return this;
};

/**
 * Add multiple listeners at once.
 *
 * @method
 * @param {Object} listeners List of event/callback pairs
 * @returns {ve.EventEmitter} This object
 */
ve.EventEmitter.prototype.addListeners = function ( listeners ) {
	for ( var event in listeners ) {
		this.addListener( event, listeners[event] );
	}
	return this;
};

/**
 * Add a listener, mapped to a method on a target object.
 *
 * @method
 * @param {Object} target Object to call methods on when events occur
 * @param {String} event Name of event to trigger on
 * @param {String} method Name of method to call
 * @returns {ve.EventEmitter} This object
 */
ve.EventEmitter.prototype.addListenerMethod = function ( target, event, method ) {
	return this.addListener( event, function () {
		if ( typeof target[method] === 'function' ) {
			target[method].apply( target, Array.prototype.slice.call( arguments, 0 ) );
		} else {
			throw new Error( 'Listener method error. Target has no such method: ' + method );
		}
	} );
};

/**
 * Add multiple listeners, each mapped to a method on a target object.
 *
 * @method
 * @param {Object} target Object to call methods on when events occur
 * @param {Object} methods List of event/method name pairs
 * @returns {ve.EventEmitter} This object
 */
ve.EventEmitter.prototype.addListenerMethods = function ( target, methods ) {
	for ( var event in methods ) {
		this.addListenerMethod( target, event, methods[event] );
	}
	return this;
};

/**
 * Alias for addListener
 *
 * @method
 */
ve.EventEmitter.prototype.on = ve.EventEmitter.prototype.addListener;

/**
 * Adds a one-time listener to a specific event.
 *
 * @method
 * @param {String} type Type of event to listen to
 * @param {Function} listener Listener to call when event occurs
 * @returns {ve.EventEmitter} This object
 */
ve.EventEmitter.prototype.once = function ( type, listener ) {
	var eventEmitter = this;
	return this.addListener( type, function listenerWrapper() {
		eventEmitter.removeListener( type, listenerWrapper );
		listener.apply( eventEmitter, Array.prototype.slice.call( arguments, 0 ) );
	} );
};

/**
 * Removes a specific listener from a specific event.
 *
 * @method
 * @param {String} type Type of event to remove listener from
 * @param {Function} listener Listener to remove
 * @returns {ve.EventEmitter} This object
 * @throws "Invalid listener error" if listener argument is not a function
 */
ve.EventEmitter.prototype.removeListener = function ( type, listener ) {
	if ( typeof listener !== 'function' ) {
		throw new Error( 'Invalid listener error. Function expected.' );
	}
	if ( !( type in this.events ) || !this.events[type].length ) {
		return this;
	}
	var i,
		handlers = this.events[type];
	if ( handlers.length === 1 && handlers[0] === listener ) {
		delete this.events[type];
	} else {
		i = ve.indexOf( listener, handlers );
		if ( i < 0 ) {
			return this;
		}
		handlers.splice( i, 1 );
		if ( handlers.length === 0 ) {
			delete this.events[type];
		}
	}
	return this;
};

/**
 * Removes all listeners from a specific event.
 *
 * @method
 * @param {String} type Type of event to remove listeners from
 * @returns {ve.EventEmitter} This object
 */
ve.EventEmitter.prototype.removeAllListeners = function ( type ) {
	if ( type in this.events ) {
		delete this.events[type];
	}
	return this;
};

/**
 * Gets a list of listeners attached to a specific event.
 *
 * @method
 * @param {String} type Type of event to get listeners for
 * @returns {Array} List of listeners to an event
 */
ve.EventEmitter.prototype.listeners = function ( type ) {
	return type in this.events ? this.events[type] : [];
};
