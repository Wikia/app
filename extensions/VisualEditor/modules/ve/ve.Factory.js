/*!
 * VisualEditor Factory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic object factory.
 *
 * @abstract
 * @extends ve.Registry
 * @constructor
 */
ve.Factory = function VeFactory() {
	// Parent constructor
	ve.Registry.call( this );

	// Properties
	this.entries = [];
};

/* Inheritance */

ve.inheritClass( ve.Factory, ve.Registry );

/* Methods */

/**
 * Register a constructor with the factory.
 *
 * @method
 * @param {string|string[]} name Symbolic name or list of symbolic names
 * @param {Function} constructor Constructor to use when creating object
 * @throws {Error} Constructor must be a function
 */
ve.Factory.prototype.register = function ( name, constructor ) {
	var i, len;

	if ( typeof constructor !== 'function' ) {
		throw new Error( 'constructor must be a function, cannot be a ' + typeof constructor );
	}
	if ( typeof name === 'string' ) {
		this.entries.push( name );
	} else if ( ve.isArray( name ) ) {
		for ( i = 0, len = name.length; i < len; i++ ) {
			this.entries.push( name[i] );
		}
	}
	ve.Registry.prototype.register.call( this, name, constructor );
};

/**
 * Create an object based on a name.
 *
 * Name is used to look up the constructor to use, while all additional arguments are passed to the
 * constructor directly, so leaving one out will pass an undefined to the constructor.
 *
 * @method
 * @param {string} name Object name
 * @param {Mixed...} [args] Arguments to pass to the constructor
 * @returns {Object} The new object
 * @throws {Error} Unknown object name
 */
ve.Factory.prototype.create = function ( name ) {
	var args, obj, constructor;

	constructor = this.registry[name];
	if ( constructor === undefined ) {
		throw new Error( 'No class registered by that name: ' + name );
	}

	// Convert arguments to array and shift the first argument (name) off
	args = Array.prototype.slice.call( arguments, 1 );

	// We can't use the "new" operator with .apply directly because apply needs a
	// context. So instead just do what "new" does: create an object that inherits from
	// the constructor's prototype (which also makes it an "instanceof" the constructor),
	// then invoke the constructor with the object as context, and return it (ignoring
	// the constructor's return value).
	obj = ve.createObject( constructor.prototype );
	constructor.apply( obj, args );
	return obj;
};
