// Alias jQuery to Zepto (ew)
window.jQuery = window.Zepto;

// Add a few things missing from jQuery
(function ( $ ){
	$.isPlainObject = function( obj ) {
		// Must be an Object.
		// Because of IE, we also have to check the presence of the constructor property.
		// Make sure that DOM nodes and window objects don't pass through, as well
		if ( !obj || $.isObject() || obj.nodeType || jQuery.isWindow( obj ) ) {
			return false;
		}

		var hasOwn = Object.prototype.hasOwnProperty;
		try {
			// Not own constructor property must be Object
			if ( obj.constructor &&
				!hasOwn.call(obj, "constructor") &&
				!hasOwn.call(obj.constructor.prototype, "isPrototypeOf") ) {
				return false;
			}
		} catch ( e ) {
			// IE8,9 Will throw exceptions on certain host objects #9897
			return false;
		}

		// Own properties are enumerated firstly, so to speed up,
		// if last one is own, then all properties are own.

		var key;
		for ( key in obj ) {}

		return key === undefined || hasOwn.call( obj, key );
	};

	$.isWindow = function( obj ) {
		return obj && typeof obj === "object" && "setInterval" in obj;
	};

	$.isEmptyObject = function( obj ) {
		for ( var name in obj ) {
			return false;
		}
		return true;
	};
})( Zepto );