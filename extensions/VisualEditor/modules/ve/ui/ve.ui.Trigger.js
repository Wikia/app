/*!
 * VisualEditor UserInterface Trigger class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Key trigger.
 *
 * @class
 *
 * @constructor
 * @param {jQuery.Event|string} [e] Event or string to create trigger from
 */
ve.ui.Trigger = function VeUiTrigger( e ) {
	// Properties
	this.modifiers = {
		'meta': false,
		'ctrl': false,
		'alt': false,
		'shift': false
	};
	this.primary = false;

	// Initialiation
	var i, len, key, parts,
		keyAliases = ve.ui.Trigger.static.keyAliases,
		primaryKeys = ve.ui.Trigger.static.primaryKeys,
		primaryKeyMap = ve.ui.Trigger.static.primaryKeyMap;
	if ( e instanceof jQuery.Event ) {
		this.modifiers.meta = e.metaKey || false;
		this.modifiers.ctrl = e.ctrlKey || false;
		this.modifiers.alt = e.altKey || false;
		this.modifiers.shift = e.shiftKey || false;
		this.primary = primaryKeyMap[e.which] || false;
	} else if ( typeof e === 'string' ) {
		// Normalization: remove whitespace and force lowercase
		parts = e.replace( /\s*/g, '' ).toLowerCase().split( '+' );
		for ( i = 0, len = parts.length; i < len; i++ ) {
			key = parts[i];
			// Resolve key aliases
			if ( key in keyAliases ) {
				key = keyAliases[key];
			}
			// Apply key to trigger
			if ( key in this.modifiers ) {
				// Modifier key
				this.modifiers[key] = true;
			} else if ( primaryKeys.indexOf( key ) !== -1 ) {
				// WARNING: Only the last primary key will be used
				this.primary = key;
			}
		}
	}
};

/* Static Properties */

/**
 * @static
 * @property
 * @inheritable
 */
ve.ui.Trigger.static = {};

/**
 * Symbolic modifier key names.
 *
 * The order of this array affects the canonical order of a trigger string.
 *
 * @static
 * @property
 */
ve.ui.Trigger.static.modifierKeys = ['meta', 'ctrl', 'alt', 'shift'];

/**
 * Symbolic primary key names.
 *
 * @static
 * @property
 */
ve.ui.Trigger.static.primaryKeys = [
	// Special keys
	'backspace', 'tab', 'enter', 'escape', 'page-up', 'page-down', 'end', 'home', 'left', 'up',
	'right', 'down', 'delete', 'clear',
	// Numbers
	'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	// Letters
	'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
	't', 'u', 'v', 'w', 'x', 'y', 'z',
	// Numpad special keys
	'multiply', 'add', 'subtract', 'decimal', 'divide',
	// Function keys
	'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9', 'f10', 'f11', 'f12',
	// Punctuation
	';', '=', ',', '-', '.', '/', '`', '[', '\\', ']', '\''
];

/**
 * Filter to use when rendering string for a specific platform.
 *
 * @static
 * @property
 */
ve.ui.Trigger.static.platformFilters = {
	'mac': ( function () {
		var names = {
			'meta': '⌘',
			'shift': '⇧',
			'backspace': '⌫',
			'ctrl': '^',
			'alt': '⎇',
			'escape': '⎋'
		};
		return function ( keys ) {
			var i, len;
			for ( i = 0, len = keys.length; i < len; i++ ) {
				keys[i] = names[keys[i]] || keys[i];
			}
			return keys.join( '' ).toUpperCase();
		};
	} )()
};

/**
 * Aliases for modifier or primary key names.
 *
 * @static
 * @property
 */
ve.ui.Trigger.static.keyAliases = {
	// Platform differences
	'command': 'meta', 'apple': 'meta', 'windows': 'meta', 'option': 'alt', 'return': 'enter',
	// Shorthand
	'esc': 'escape', 'cmd': 'meta', 'del': 'delete',
	// Longhand
	'control': 'ctrl', 'alternate': 'alt',
	// Symbols
	'⌘': 'meta', '⎇': 'alt', '⇧': 'shift', '⏎': 'enter', '⌫': 'backspace', '⎋': 'escape'
};

/**
 * Mapping of key codes and symbolic key names.
 *
 * @static
 * @property
 */
ve.ui.Trigger.static.primaryKeyMap = {
	// Special keys
	8: 'backspace', 9: 'tab', 12: 'clear', 13: 'enter', 27: 'escape', 33: 'page-up', 34: 'page-down',
	35: 'end', 36: 'home', 37: 'left', 38: 'up', 39: 'right', 40: 'down', 46: 'delete',
	// Numbers
	48: '0', 49: '1', 50: '2', 51: '3', 52: '4', 53: '5', 54: '6', 55: '7', 56: '8', 57: '9',
	// Punctuation
	59: ';', 61: '=',
	// Letters
	65: 'a', 66: 'b', 67: 'c', 68: 'd', 69: 'e', 70: 'f', 71: 'g', 72: 'h', 73: 'i', 74: 'j',
	75: 'k', 76: 'l', 77: 'm', 78: 'n', 79: 'o', 80: 'p', 81: 'q', 82: 'r', 83: 's', 84: 't',
	85: 'u', 86: 'v', 87: 'w', 88: 'x', 89: 'y', 90: 'z',
	// Numpad numbers
	96: '0', 97: '1', 98: '2', 99: '3', 100: '4', 101: '5', 102: '6', 103: '7', 104: '8', 105: '9',
	// Numpad special keys
	106: 'multiply', 107: 'add', 109: 'subtract', 110: 'decimal', 111: 'divide',
	// Function keys
	112: 'f1', 113: 'f2', 114: 'f3', 115: 'f4', 116: 'f5', 117: 'f6', 118: 'f7', 119: 'f8',
	120: 'f9', 121: 'f10', 122: 'f11', 123: 'f12',
	// Punctuation
	186: ';', 187: '=', 188: ',', 189: '-', 190: '.', 191: '/', 192: '`', 219: '[', 220: '\\',
	221: ']', 222: '\''
};

/* Methods */

/**
 * Checks if trigger is complete.
 *
 * For a trigger to be complete, there must be a valid primary key.
 *
 * @method
 * @returns {boolean} Trigger is complete
 */
ve.ui.Trigger.prototype.isComplete = function () {
	return this.primary !== false;
};

/**
 * Gets a trigger string.
 *
 * Trigger strings are canonical representations of triggers made up of the symbolic names of all
 * active modifier keys and the primary key joined together with a '+' sign.
 *
 * To normalize a trigger string simply create a new trigger from a string and then run this method.
 *
 * An incomplete trigger will return an empty string.
 *
 * @method
 * @returns {string} Canonical trigger string
 */
ve.ui.Trigger.prototype.toString = function () {
	var i, len,
		modifierKeys = ve.ui.Trigger.static.modifierKeys,
		keys = [];
	// Add modifier keywords in the correct order
	for ( i = 0, len = modifierKeys.length; i < len; i++ ) {
		if ( this.modifiers[modifierKeys[i]] ) {
			keys.push( modifierKeys[i] );
		}
	}
	// Check that there were modifiers and the primary key is whitelisted
	if ( this.primary ) {
		// Add a symbolic name for the primary key
		keys.push( this.primary );
		return keys.join( '+' );
	}
	// Alternatively return an empty string
	return '';
};

/**
 * Gets a trigger message.
 *
 * This is similar to #toString but the resulting string will be formatted in a way that makes it
 * appear more native for the platform.
 *
 * @method
 * @returns {string} Message for trigger
 */
ve.ui.Trigger.prototype.getMessage = function () {
	var keys,
		platformFilters = ve.ui.Trigger.static.platformFilters,
		platform = ve.init.platform.getSystemPlatform();

	keys = this.toString().split( '+' );
	if ( platform in platformFilters ) {
		return platformFilters[platform]( keys );
	}
	return keys.join( '+' ).toUpperCase();
};
