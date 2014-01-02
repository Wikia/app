/*!
 * VisualEditor UserInterface FlaggableElement class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Flaggable element.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string[]} [flags=[]] Styling flags, e.g. 'primary', 'destructive' or 'constructive'
 */
ve.ui.FlaggableElement = function VeUiFlaggableElement( config ) {
	// Config initialization
	config = config || {};

	// Properties
	this.flags = {};

	// Initialization
	this.setFlags( config.flags );
};

/* Methods */

/**
 * Check if a flag is set.
 *
 * @method
 * @param {string} flag Flag name to check
 * @returns {boolean} Has flag
 */
ve.ui.FlaggableElement.prototype.hasFlag = function ( flag ) {
	return flag in this.flags;
};

/**
 * Get the names of all flags.
 *
 * @method
 * @returns {string[]} flags Flag names
 */
ve.ui.FlaggableElement.prototype.getFlags = function () {
	return ve.getObjectKeys( this.flags );
};

/**
 * Add one or more flags.
 *
 * @method
 * @param {string[]|Object.<string, boolean>} flags List of flags to add, or list of set/remove
 *  values, keyed by flag name
 * @chainable
 */
ve.ui.FlaggableElement.prototype.setFlags = function ( flags ) {
	var i, len, flag,
		classPrefix = 've-ui-flaggableElement-';

	if ( ve.isArray( flags ) ) {
		for ( i = 0, len = flags.length; i < len; i++ ) {
			flag = flags[i];
			// Set
			this.flags[flag] = true;
			this.$.addClass( classPrefix + flag );
		}
	} else if ( ve.isPlainObject( flags ) ) {
		for ( flag in flags ) {
			if ( flags[flags] ) {
				// Set
				this.flags[flag] = true;
				this.$.addClass( classPrefix + flag );
			} else {
				// Remove
				delete this.flags[flag];
				this.$.removeClass( classPrefix + flag );
			}
		}
	}
	return this;
};
