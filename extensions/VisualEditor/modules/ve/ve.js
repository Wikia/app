/**
 * VisualEditor namespace.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

( function () {
	var ve, hasOwn;

	/**
	 * Namespace for all VisualEditor classes, static methods and static properties.
	 */
	ve = {
		// List of instances of ve.Surface
		'instances': []
		//'actionFactory' instantiated in ve.ActionFactory.js
	};

	/* Utility Functions */

	hasOwn = Object.prototype.hasOwnProperty;

	/* Static Methods */

	/**
	 * Create an object that inherits from another object.
	 *
	 * @static
	 * @method
	 * @until ES5: Object.create.
	 * @source https://github.com/Krinkle/K-js.
	 * @param {Object} origin Object to inherit from.
	 * @return {Object} Empty object that inherits from origin.
	 */
	ve.createObject = Object.create || function ( origin ) {
		function O() {}
		O.prototype = origin;
		var r = new O();

		return r;
	};

	/**
	 * Utility for common usage of ve.createObject for inheriting from one
	 * prototype to another.
	 *
	 * Beware: This redefines the prototype, call before setting your prototypes.
	 * Beware: This redefines the prototype, can only be called once on a function.
	 *  If called multiple times on the same function, the previous prototype is lost.
	 *  This is how prototypal inheritance works, it can only be one straight chain
	 *  (just like classical inheritance in PHP for example). If you need to work with
	 *  multiple constructors consider storing an instance of the other constructor in a
	 *  property instead, or perhaps use a mixin (see ve.mixinClass).
	 *
	 * @example
	 * <code>
	 *     function Foo() {}
	 *
	 *     Foo.prototype.jump = function () {};
	 *
	 *     -------
	 *
	 *     function FooBar() {}
	 *     ve.inheritClass( FooBar, Foo );
	 *
	 *     FooBar.prop.feet = 2;
	 *
	 *     FooBar.prototype.walk = function () {};
	 *
	 *     -------
	 *
	 *     function FooBarQuux() {}
	 *     ve.inheritClass( FooBarQuux, FooBar );
	 *
	 *     FooBarQuux.prototype.jump = function () {};
	 *
	 *     -------
	 *
	 *     FooBarQuux.prop.feet === 2;
	 *     var fb = new FooBar();
	 *     fb.jump();
	 *     fb.walk();
	 *     fb instanceof Foo && fb instanceof FooBar && fb instanceof FooBarQuux;
	 * </code>
	 *
	 * @static
	 * @method
	 * @source https://github.com/Krinkle/K-js.
	 * @param {Function} targetFn
	 * @param {Function} originFn
	 */
	ve.inheritClass = function ( targetFn, originFn ) {
		// Doesn't really require ES5 (jshint/jshint#74@github)
		/*jshint es5: true */
		var targetConstructor = targetFn.prototype.constructor;

		targetFn.prototype = ve.createObject( originFn.prototype );

		// Restore constructor property of targetFn
		targetFn.prototype.constructor = targetConstructor;

		// Messing with static properties can be harmful, but we've agreed on one
		// common property that will be inherited, and that one only. Use this for
		// for making static values visible in child classes
		originFn.static = originFn.static || {}; // Lazy-init
		targetFn.static = ve.createObject( originFn.static );
	};

	/**
	 * Utility to copy over *own* prototype properties of a mixin.
	 * The 'constructor' (whether implicit or explicit) is not copied over.
	 *
	 * This does not create inheritance to the origin. If inheritance is needed
	 * use ve.inheritClass instead.
	 *
	 * Beware: This can redefine a prototype property, call before setting your prototypes.
	 * Beware: Don't call before ve.inheritClass.
	 *
	 * @example
	 * <code>
	 *     function Foo() {}
	 *     function Context() {}
	 *
	 *     // Avoid repeating this code
	 *     function ContextLazyLoad() {}
	 *     ContextLazyLoad.prototype.getContext = function () {
	 *         if ( !this.context ) {
	 *             this.context = new Context();
	 *         }
	 *         return this.context;
	 *     };
	 *
	 *     function FooBar() {}
	 *     ve.inheritClass( FooBar, Foo );
	 *     ve.mixinClass( FooBar, ContextLazyLoad );
	 * </code>
	 *
	 * @static
	 * @method
	 * @source https://github.com/Krinkle/K-js.
	 * @param {Function} targetFn
	 * @param {Function} originFn
	 */
	ve.mixinClass = function ( targetFn, originFn ) {
		for ( var key in originFn.prototype ) {
			if ( key !== 'constructor' && hasOwn.call( originFn.prototype, key ) ) {
				targetFn.prototype[key] = originFn.prototype[key];
			}
		}
	};

	/**
	 * Create a new object that is an instance of the same
	 * constructor as the input, inherits from the same object
	 * and contains the same own properties.
	 *
	 * This makes a shallow non-recursive copy of own properties.
	 * To create a recursive copy of plain objects, use ve.copyObject.
	 *
	 * @example
	 * <code>
	 * var foo = new Person( mom, dad );
	 * foo.setAge( 21 );
	 * var foo2 = ve.cloneObject( foo );
	 * foo.setAge( 22 );
	 * // Then
	 * foo2 !== foo; // true
	 * foo2 instanceof Person; // true
	 * foo2.getAge(); // 21
	 * foo.getAge(); // 22
	 * </code>
	 *
	 * @static
	 * @method
	 * @source https://github.com/Krinkle/K-js.
	 * @param {Object} origin
	 * @return {Object} Clone of origin.
	 */
	ve.cloneObject = function ( origin ) {
		var key, r;

		r = ve.createObject( origin.constructor.prototype );

		for ( key in origin ) {
			if ( hasOwn.call( origin, key ) ) {
				r[key] = origin[key];
			}
		}

		return r;
	};

	ve.isPlainObject = $.isPlainObject;

	ve.isEmptyObject = $.isEmptyObject;

	/**
	 * Check whether given variable is an array. Should not use `instanceof` or
	 * `constructor` due to the inability to detect arrays from a different
	 * scope.
	 * @static
	 * @method
	 * @until ES5: Array.isArray.
	 * @param {Mixed} x
	 * @return {Boolean}
	 */
	ve.isArray = $.isArray;

	/**
	 * Create a function calls the given function in a certain context.
	 * If a function does not have an explicit context, it is determined at
	 * executin time based on how it is invoked (e.g. object member, call/apply,
	 * global scope, etc.).
	 * Performance optimization: http://jsperf.com/function-bind-shim-perf
	 *
	 * @static
	 * @method
	 * @until ES5: Function.prototype.bind.
	 * @param {Function} func Function to bind.
	 * @param {Object} context Context for the function.
	 * @param {Mixed} [..] Variadic list of arguments to prepend to arguments
	 * to the bound function.
	 * @return {Function} The bound.
	 */
	ve.bind = $.proxy;

	/**
	 * Wrapper for Array.prototype.indexOf.
	 *
	 * @static
	 * @method
	 * @until ES5
	 * @param {Mixed} value Element to search for.
	 * @param {Array} array Array to search in.
	 * @param {Number} [fromIndex=0] Index to being searching from.
	 * @return {Number} Index of value in array, or -1 if not found.
	 * Values are compared without type coersion.
	 */
	ve.indexOf = $.inArray;

	/**
	 * Merge properties of one or more objects into another.
	 * Preserves original object's inheritance (e.g. Array, Object, whatever).
	 * In case of array or array-like objects only the indexed properties
	 * are copied over.
	 * Beware: If called with only one argument, it will consider
	 * 'target' as 'source' and 'this' as 'target'. Which means
	 * ve.extendObject( { a: 1 } ); sets ve.a = 1;
	 *
	 * @static
	 * @method
	 * @param {Boolean} [recursive=false]
	 * @param {Mixed} target Object that will receive the new properties.
	 * @param {Mixed} [..] Variadic list of objects containing properties
	 * to be merged into the targe.
	 * @return {Mixed} Modified version of first or second argument.
	 */
	ve.extendObject = $.extend;

	/**
	 * Generates a hash of an object based on its name and data.
	 * Performance optimization: http://jsperf.com/ve-gethash-201208#/toJson_fnReplacerIfAoForElse
	 *
	 * To avoid two objects with the same values generating different hashes, we utilize the replacer
	 * argument of JSON.stringify and sort the object by key as it's being serialized. This may or may
	 * not be the fastest way to do this; we should investigate this further.
	 *
	 * Objects an arrays are hashed recursively. When hashing an object that has a .getHash()
	 * function, we call that function and use its return value rather than hashing the object
	 * ourselves. This allows classes to define custom hashing.
	 *
	 * @static
	 * @method
	 * @param {Object} val Object to generate hash for
	 * @returns {String} Hash of object
	 */
	ve.getHash = function ( val ) {
		return JSON.stringify( val, ve.getHash.keySortReplacer );
	};

	/**
	 * Helper function for ve.getHash which sorts objects by key.
	 *
	 * This is a callback passed into JSON.stringify.
	 *
	 * @static
	 * @method
	 * @param {String} key Property name of value being replaced
	 * @param {Mixed} val Property value to replace
	 * @returns {Mixed} Replacement value
	 */
	ve.getHash.keySortReplacer = function ( key, val ) {
		var normalized, keys, i, len;
		if ( val && typeof val.getHash === 'function' ) {
			// This object has its own custom hash function, use it
			return val.getHash();
		}
		if ( !ve.isArray( val ) && Object( val ) === val ) {
			// Only normalize objects when the key-order is ambiguous
			// (e.g. any object not an array).
			normalized = {};
			keys = ve.getObjectKeys( val ).sort();
			i = 0;
			len = keys.length;
			for ( ; i < len; i += 1 ) {
				normalized[keys[i]] = val[keys[i]];
			}
			return normalized;

		// Primitive values and arrays get stable hashes
		// by default. Lets those be stringified as-is.
		} else {
			return val;
		}
	};

	/**
	 * Gets an array of all property names in an object.
	 *
	 * This falls back to the native impelentation of Object.keys if available.
	 * Performance optimization: http://jsperf.com/object-keys-shim-perf#/fnHasown_fnForIfcallLength
	 *
	 * @static
	 * @method
	 * @until ES5
	 * @param {Object} Object to get properties from
	 * @returns {String[]} List of object keys
	 */
	ve.getObjectKeys = Object.keys || function ( obj ) {
		var key, keys;

		if ( Object( obj ) !== obj ) {
			throw new TypeError( 'Called on non-object' );
		}

		keys = [];
		for ( key in obj ) {
			if ( hasOwn.call( obj, key ) ) {
				keys[keys.length] = key;
			}
		}

		return keys;
	};

	/**
	 * Gets an array of all property values in an object.
	 *
	 * @static
	 * @method
	 * @param {Object} Object to get values from
	 * @returns {Array} List of object values
	 */
	ve.getObjectValues = function ( obj ) {
		var key, values;

		if ( Object( obj ) !== obj ) {
			throw new TypeError( 'Called on non-object' );
		}

		values = [];
		for ( key in obj ) {
			if ( hasOwn.call( obj, key ) ) {
				values[values.length] = obj[key];
			}
		}

		return values;
	};

	/**
	 * Recursively compares string and number property between two objects.
	 *
	 * A false result may be caused by property inequality or by properties in one object missing from
	 * the other. An asymmetrical test may also be performed, which checks only that properties in the
	 * first object are present in the second object, but not the inverse.
	 *
	 * @static
	 * @method
	 * @param {Object} a First object to compare
	 * @param {Object} b Second object to compare
	 * @param {Boolean} [asymmetrical] Whether to check only that b contains values from a
	 * @returns {Boolean} If the objects contain the same values as each other
	 */
	ve.compareObjects = function ( a, b, asymmetrical ) {
		var aValue, bValue, aType, bType, k;
		for ( k in a ) {
			aValue = a[k];
			bValue = b[k];
			aType = typeof aValue;
			bType = typeof bValue;
			if ( aType !== bType ||
				( ( aType === 'string' || aType === 'number' ) && aValue !== bValue ) ||
				( ve.isPlainObject( aValue ) && !ve.compareObjects( aValue, bValue ) ) ) {
				return false;
			}
		}
		// If the check is not asymmetrical, recursing with the arguments swapped will verify our result
		return asymmetrical ? true : ve.compareObjects( b, a, true );
	};

	/**
	 * Recursively compare two arrays.
	 *
	 * @static
	 * @method
	 * @param {Array} a First array to compare
	 * @param {Array} b Second array to compare
	 * @param {Boolean} [objectsByValue] Use ve.compareObjects() to compare objects instead of ===
	 */
	ve.compareArrays = function ( a, b, objectsByValue ) {
		var i,
			aValue,
			bValue,
			aType,
			bType;
		if ( a.length !== b.length ) {
			return false;
		}
		for ( i = 0; i < a.length; i++ ) {
			aValue = a[i];
			bValue = b[i];
			aType = typeof aValue;
			bType = typeof bValue;
			if (
				aType !== bType ||
				!(
					(
						ve.isArray( aValue ) &&
						ve.isArray( bValue ) &&
						ve.compareArrays( aValue, bValue )
					) ||
					(
						objectsByValue &&
						ve.isPlainObject( aValue ) &&
						ve.compareObjects( aValue, bValue )
					) ||
					aValue === bValue
				)
			) {
				return false;
			}
		}
		return true;
	};

	/**
	 * Gets a deep copy of an array's string, number, array, plain-object and cloneable object contents.
	 *
	 * @static
	 * @method
	 * @param {Array} source Array to copy
	 * @returns {Array} Copy of source array
	 */
	ve.copyArray = function ( source ) {
		var i, sourceValue, sourceType,
			destination = [];
		for ( i = 0; i < source.length; i++ ) {
			sourceValue = source[i];
			sourceType = typeof sourceValue;
			if ( sourceType === 'string' || sourceType === 'number' || sourceType === 'undefined' || sourceValue === null ) {
				destination.push( sourceValue );
			} else if ( ve.isPlainObject( sourceValue ) ) {
				destination.push( ve.copyObject( sourceValue ) );
			} else if ( ve.isArray( sourceValue ) ) {
				destination.push( ve.copyArray( sourceValue ) );
			} else if ( sourceValue && typeof sourceValue.clone === 'function' ) {
				destination.push( sourceValue.clone() );
			}
		}
		return destination;
	};

	/**
	 * Gets a deep copy of an object's string, number, array and plain-object properties.
	 *
	 * @static
	 * @method
	 * @param {Object} source Object to copy
	 * @returns {Object} Copy of source object
	 */
	ve.copyObject = function ( source ) {
		var key, sourceValue, sourceType,
			destination = {};
		if ( typeof source.clone === 'function' ) {
			return source.clone();
		}
		for ( key in source ) {
			sourceValue = source[key];
			sourceType = typeof sourceValue;
			if ( sourceType === 'string' || sourceType === 'number' || sourceType === 'undefined' || sourceValue === null ) {
				destination[key] = sourceValue;
			} else if ( ve.isPlainObject( sourceValue ) ) {
				destination[key] = ve.copyObject( sourceValue );
			} else if ( ve.isArray( sourceValue ) ) {
				destination[key] = ve.copyArray( sourceValue );
			} else if ( sourceValue && typeof sourceValue.clone === 'function' ) {
				destination[key] = sourceValue.clone();
			}
		}
		return destination;
	};

	/**
	 * Splice one array into another.
	 *
	 * This is the equivalent of arr.splice( offset, remove, d1, d2, d3, ... ) except that arguments are
	 * specified as an array rather than separate parameters.
	 *
	 * This method has been proven to be faster than using slice and concat to create a new array, but
	 * performance tests should be conducted on each use of this method to verify this is true for the
	 * particular use. Also, browsers change fast, never assume anything, always test everything.
	 *
	 * @static
	 * @method
	 * @param {Array} arr Array to remove from and insert into. Will be modified
	 * @param {Number} offset Offset in arr to splice at. This may NOT be negative, unlike the
	 *                         'index' parameter in Array.prototype.splice
	 * @param {Number} remove Number of elements to remove at the offset. May be zero
	 * @param {Array} data Array of items to insert at the offset. May not be empty if remove=0
	 */
	ve.batchSplice = function ( arr, offset, remove, data ) {
		// We need to splice insertion in in batches, because of parameter list length limits which vary
		// cross-browser - 1024 seems to be a safe batch size on all browsers
		var index = 0, batchSize = 1024, toRemove = remove, spliced, removed = [];
		if ( data.length === 0 ) {
			// Special case: data is empty, so we're just doing a removal
			// The code below won't handle that properly, so we do it here
			return arr.splice( offset, remove );
		}
		while ( index < data.length ) {
			// Call arr.splice( offset, remove, i0, i1, i2, ..., i1023 );
			// Only set remove on the first call, and set it to zero on subsequent calls
			spliced = arr.splice.apply(
				arr, [index + offset, toRemove].concat( data.slice( index, index + batchSize ) )
			);
			if ( toRemove > 0 ) {
				removed = spliced;
			}
			index += batchSize;
			toRemove = 0;
		}
		return removed;
	};

	/**
	 * Insert one array into another. This just calls ve.batchSplice( dst, offset, 0, src )
	 *
	 * @static
	 * @method
	 * @see ve.batchSplice
	 */
	ve.insertIntoArray = function ( dst, offset, src ) {
		ve.batchSplice( dst, offset, 0, src );
	};

	/**
	 * Get a deeply nested property of an object using variadic arguments, protecting against
	 * undefined property errors.
	 *
	 * quux = getProp( obj, 'foo', 'bar', 'baz' ); is equivalent to quux = obj.foo.bar.baz;
	 * except that the former protects against JS errors if one of the intermediate properties
	 * is undefined. Instead of throwing an error, this function will return undefined in
	 * that case.
	 *
	 * @param {Object} obj
	 * @returns obj[arguments[1]][arguments[2]].... or undefined
	 */
	ve.getProp = function ( obj /*, keys ... */ ) {
		var i, retval = obj;
		for ( i = 1; i < arguments.length; i++ ) {
			if ( retval === undefined || retval === null ) {
				// Trying to access a property of undefined or null causes an error
				return undefined;
			}
			retval = retval[arguments[i]];
		}
		return retval;
	};

	/**
	 * Set a deeply nested property of an object using variadic arguments, protecting against
	 * undefined property errors.
	 *
	 * ve.setProp( obj, 'foo', 'bar', 'baz' ); is equivalent to obj.foo.bar = baz; except that
	 * the former protects against JS errors if one of the intermediate properties is
	 * undefined. Instead of throwing an error, undefined intermediate properties will be
	 * initialized to an empty object. If an intermediate property is null, or if obj itself
	 * is undefined or null, this function will silently abort.
	 *
	 * @param {Object} obj
	 */
	ve.setProp = function ( obj /*, keys ... , value */ ) {
		var i, prop = obj;
		if ( Object( obj ) !== obj ) {
			return;
		}
		for ( i = 1; i < arguments.length - 2; i++ ) {
			if ( prop[arguments[i]] === undefined ) {
				prop[arguments[i]] = {};
			}
			if ( prop[arguments[i]] === null || typeof prop[arguments[i]] !== 'object' ) {
				return;
			}
			prop = prop[arguments[i]];
		}
		prop[arguments[arguments.length - 2]] = arguments[arguments.length - 1];
	};

	/**
	 * Logs data to the console.
	 *
	 * This implementation does nothing, to add a real implmementation ve.debug needs to be loaded.
	 *
	 * @static
	 * @method
	 * @param {Mixed} [...] Data to log
	 */
	ve.log = function () {
		// don't do anything, this is just a stub
	};

	/**
	 * Logs an object to the console.
	 *
	 * This implementation does nothing, to add a real implmementation ve.debug needs to be loaded.
	 *
	 * @static
	 * @method
	 * @param {Object} obj Object to log
	 */
	ve.dir = function () {
		// don't do anything, this is just a stub
	};

	/**
	 * Ported from: http://underscorejs.org/underscore.js
	 *
	 * Returns a function, that, as long as it continues to be invoked, will not
	 * be triggered. The function will be called after it stops being called for
	 * N milliseconds. If `immediate` is passed, trigger the function on the
	 * leading edge, instead of the trailing.
	 *
	 * @static
	 * @method
	 * @param func
	 * @param wait
	 * @param immediate
	 */
	ve.debounce = function ( func, wait, immediate ) {
		var timeout;
		return function () {
			var context = this,
				args = arguments,
				later = function () {
					timeout = null;
					if ( !immediate ) {
						func.apply( context, args );
					}
				};
			if ( immediate && !timeout ) {
				func.apply( context, args );
			}
			clearTimeout( timeout );
			timeout = setTimeout( later, wait );
		};
	};

	/**
	 * Gets a localized message.
	 *
	 * @static
	 * @method
	 * @param {String} key Message key
	 * @param {Mixed} [...] Message parameters
	 */
	ve.msg = function () {
		return ve.init.platform.getMessage.apply( ve.init.platform, arguments );
	};

	/**
	 * Escapes non-word characters so they can be safely used as HTML attribute values.
	 *
	 * This method is basically a copy of mw.html.escape.
	 *
	 * @static
	 * @method
	 * @param {String} value Attribute value to escape
	 * @returns {String} Escaped attribute value
	 */
	ve.escapeHtml = function ( value ) {
		return value.replace( /['"<>&]/g, ve.escapeHtml.escapeHtmlCharacter );
	};

	/**
	 * Helper function for ve.escapeHtml which escapes a character for use in HTML.
	 *
	 * This is a callback passed into String.prototype.replace.
	 *
	 * @static
	 * @method
	 * @param {String} key Property name of value being replaced
	 * @returns {String} Escaped charcater
	 */
	ve.escapeHtml.escapeHtmlCharacter = function ( value ) {
		switch ( value ) {
			case '\'':
				return '&#039;';
			case '"':
				return '&quot;';
			case '<':
				return '&lt;';
			case '>':
				return '&gt;';
			case '&':
				return '&amp;';
			default:
				return value;
		}
	};

	/**
	 * Generate an opening HTML tag.
	 *
	 * This method copies part of mw.html.element() in MediaWiki.
	 *
	 * NOTE: While the values of attributes are escaped, the tag name and the names of
	 * attributes (i.e. the keys in the attributes objects) are NOT ESCAPED. The caller is
	 * responsible for making sure these are sane tag/attribute names and do not contain
	 * unsanitized content from an external source (e.g. from the user or from the web).
	 *
	 * @param {String} tag HTML tag name
	 * @param {Object} attributes Key-value map of attributes for the tag
	 * @return {String} Opening HTML tag
	 */
	ve.getOpeningHtmlTag = function ( tagName, attributes ) {
		var html, attrName, attrValue;
		html = '<' + tagName;
		for ( attrName in attributes ) {
			attrValue = attributes[attrName];
			if ( attrValue === true ) {
				// Convert name=true to name=name
				attrValue = attrName;
			} else if ( attrValue === false ) {
				// Skip name=false
				continue;
			}
			html += ' ' + attrName + '="' + ve.escapeHtml( String( attrValue ) ) + '"';
		}
		html += '>';
		return html;
	};

	/**
	 * Get the attributes of a DOM element as an object with key/value pairs
	 * @param {HTMLElement} element
	 * @returns {Object}
	 */
	ve.getDOMAttributes = function ( element ) {
		var result = {}, i;
		for ( i = 0; i < element.attributes.length; i++ ) {
			result[element.attributes[i].name] = element.attributes[i].value;
		}
		return result;
	};

	/**
	 * Set the attributes of a DOM element as an object with key/value pairs
	 * @param {HTMLElement} element
	 * @param {Object} attributes
	 */
	ve.setDOMAttributes = function ( element, attributes ) {
		var key;
		for ( key in attributes ) {
			if ( attributes[key] === undefined || attributes[key] === null ) {
				element.removeAttribute( key );
			} else {
				element.setAttribute( key, attributes[key] );
			}
		}
	};

	/**
	 * Check whether a given DOM element is of a block or inline type
	 * @param {HTMLElement} element
	 * @returns {Boolean} True if element is block, false if it is inline
	 */
	ve.isBlockElement = function ( element ) {
		return ve.isBlockElementType( element.nodeName.toLowerCase() );
	};

	/**
	 * Check whether a given tag name is a block or inline tag
	 * @param {String} nodeName All-lowercase HTML tag name
	 * @returns {Boolean} True if block, false if inline
	 */
	ve.isBlockElementType = function ( nodeName ) {
		return ve.indexOf( nodeName, ve.isBlockElementType.blockTypes ) !== -1;
	};

	/**
	 * Private data for ve.isBlockElementType()
	 */
	ve.isBlockElementType.blockTypes = [
		'div', 'p',
		// tables
		'table', 'tbody', 'thead', 'tfoot', 'caption',  'th', 'tr', 'td',
		// lists
		'ul', 'ol', 'li', 'dl', 'dt', 'dd',
		// HTML5 heading content
		'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hgroup',
		// HTML5 sectioning content
		'article', 'aside', 'body', 'nav', 'section', 'footer', 'header', 'figure',
		'figcaption', 'fieldset', 'details', 'blockquote',
		// other
		'hr', 'button', 'canvas', 'center', 'col', 'colgroup', 'embed',
		'map', 'object', 'pre', 'progress', 'video'
	];

	// Expose
	window.ve = ve;
}() );
