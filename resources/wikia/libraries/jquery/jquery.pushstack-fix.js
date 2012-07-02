(function(jQuery) {

// temporary workaround for chrome issue #125148
// See: http://code.google.com/p/chromium/issues/detail?id=125148
// See: https://wikia.fogbugz.com/default.asp?33592
var push = Array.prototype.push;
jQuery.fn.pushStack = function( elems, name, selector ) {
	// Build a new jQuery matched element set
	var ret = this.constructor();

	// PATCH START
	if (!(ret instanceof jQuery.fn.init)) {
		ret = new jQuery.fn.init();
	}
	// PATCH END

	if ( jQuery.isArray( elems ) ) {
		push.apply( ret, elems );

	} else {
		jQuery.merge( ret, elems );
	}

	// Add the old object onto the stack (as a reference)
	ret.prevObject = this;

	ret.context = this.context;

	if ( name === "find" ) {
		ret.selector = this.selector + ( this.selector ? " " : "" ) + selector;
	} else if ( name ) {
		ret.selector = this.selector + "." + name + "(" + selector + ")";
	}

	// Return the newly-formed element set
	return ret;
};

})(jQuery);