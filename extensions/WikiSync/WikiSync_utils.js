window.WikiSyncUtils = {

	mathLogBase : function( x, base ) {
		return Math.log( x ) / Math.log( base );
	},

	getLocalDate : function() {
		var today = new Date();
		return today.toLocaleString();
	},

	// browser-independent addevent function
	addEvent : function ( obj, type, fn ) {
		if ( document.getElementById && document.createTextNode ) {
			if (obj.addEventListener) {
				obj.addEventListener( type, fn, false );
			}
			else if (obj.attachEvent) {
				obj["e"+type+fn] = fn;
				obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
				obj.attachEvent( "on"+type, obj[type+fn] );
			}
			else {
				obj["on"+type] = obj["e"+type+fn];
			}
		}
	},

	getEventObj : function ( event, stopPropagation ) {
		var obj;
		if ( typeof event.target !== 'undefined' ) {
			obj = event.target;
			if ( stopPropagation ) {
				event.stopPropagation();
			}
		} else {
			obj = event.srcElement;
			if ( stopPropagation ) {
				event.cancelBubble = true;
			}
		}
		return obj;
	},

	/**
	 * taken from http://phpjs.org/functions/urldecode:572
	 */
	urldecode : function( s ) {
		return decodeURIComponent( s.replace(/\+/g, '%20') );
	},

	// basename prefix of user's cookies
	cookiePrefix : null,

	/**
	 */
	setCookiePrefix : function( name ) {
		this.cookiePrefix = name;
	},

	/**
	 * @return empty string in case cookie value is empty, null when cookie is not set
	 */
	getCookie : function ( cookieName ) {
		var ca, cn, keyval, key, val;
		ca = document.cookie.split( ';' );
		for ( var i=0; i < ca.length; i++ ) {
			keyval = ca[i].split( '=' );
			// trim whitespace
			key = keyval[0].replace(/^\s+|\s+$/g, '');
			if ( key == (this.cookiePrefix + cookieName) ) {
				if ( keyval.length > 1 ) {
					return this.urldecode( keyval[1].replace(/^\s+|\s+$/g, '') );
				} else {
					// cookie exists but has no value
					return "";
				}
			}
		}
		// cookie not found
		return null;
	},

	/**
	 * usage example: WikiSyncUtils.setCookie( 'rootcond', eventObj.value, 24 * 60 * 60, '/' );
	 */
	setCookie : function( cookieName, value, expires, path, domain, secure ) {
		// set time, it's in milliseconds
		var today = new Date();
		today.setTime( today.getTime() );

		/*
		if the expires variable is set, make the correct
		expires time, the current script below will set
		it for x number of days, to make it for hours,
		delete * 24, for minutes, delete * 60 * 24
		*/
		if ( expires ) {
			expires = expires * 1000 // * 60 * 60 * 24;
		}
		var expires_date = new Date( today.getTime() + expires );

		document.cookie = this.cookiePrefix + cookieName + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
		( ( path ) ? ";path=" + path : "" ) +
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
	},

	cookieToInput : function( cookie, input ) {
		var val = this.getCookie( cookie );
		if ( val !== null ) {
			input.value = val;
		}
		return val;
	},

	cookieToCheckbox : function( cookie, input ) {
		var val = this.getCookie( cookie );
		if ( val !== null ) {
			val = val === 'true';
			input.checked = val;
		}
		return val;
	}

};

/**
 * percents indicator class
 * @param id - id of table container for percents indicator
 */
window.WikiSyncPercentsIndicator = function( id ) {
	this.topElement = document.getElementById( id );
	// cannot use .firstChild here, because in FF indentation text nodes are inserted
	// between TABLE / TR / TD
	// (in IE8 the indentation is ignored and .firstChild worked)
	var elements = this.topElement.getElementsByTagName( 'TD' );
	// description line will be stored there
	this.descriptionContainer = elements[0];
	// td1 and td2 are used together as percent indicators
	this.td1 = elements[1];
	this.td2 = elements[2];
	this.reset();
}

WikiSyncPercentsIndicator.prototype.setVisibility = function( visible ) {
	this.topElement.style.display = visible ? 'table' : 'none';
}

/**
 * @access private
 */
WikiSyncPercentsIndicator.prototype.setPercents = function( element, percent ) {
	element.style.display = (percent > 0) ? 'table-cell' : 'none';
	element.style.width = percent + '%';
}

WikiSyncPercentsIndicator.prototype.reset = function() {
	this.iterations = { 'desc' : '', 'curr' : 0, 'min' : 0, 'max' : 0 };
	this.display();
}

WikiSyncPercentsIndicator.prototype.display = function( indicator ) {
	if ( typeof indicator !== 'undefined' ) {
		if ( typeof indicator.desc !== 'undefined' ) {
			this.iterations.desc = '' + indicator.desc;
		}
		if ( typeof indicator.curr !== 'undefined' ) {
			if ( indicator.curr === 'max' ) {
				this.iterations.curr = this.iterations.max;
			} else if ( indicator.curr === 'next' ) {
				this.iterations.curr++;
			} else {
				this.iterations.curr = parseInt( indicator.curr );
			}
		}
		if ( typeof indicator.min !== 'undefined' ) {
			this.iterations.min = parseInt( indicator.min );
		}
		if ( typeof indicator.max !== 'undefined' ) {
			this.iterations.max = parseInt( indicator.max );
		}
	}
	// display process description
	var text = document.createTextNode( this.iterations.desc );
	if ( this.descriptionContainer.firstChild === null ) {
		this.descriptionContainer.appendChild( text );
	} else {
		this.descriptionContainer.replaceChild( text, this.descriptionContainer.firstChild );
	}
	// calculate percent
	var percent;
	var len = this.iterations.max - this.iterations.min;
	if ( len === 0 ) {
		percent = 0;
	} else {
		percent = ( this.iterations.curr - this.iterations.min ) / len * 100;
	}
	if ( percent < 0 ) { percent = 0 }
	if ( percent > 100 ) { percent = 100 }
	// show percent
	this.setPercents( this.td1, percent );
	this.setPercents( this.td2, 100 - percent );
}
/* end of WikiSyncPercentsIndicator class */

/**
 * Debug / output logger class
 * @param logId - id of DIV container for logger
 */
function WikiSyncLog( logId ) {
	this.logContainer = document.getElementById( logId );
}

WikiSyncLog.prototype.log = function( s, color, type ) {
	var span = document.createElement( 'SPAN' );
	if ( typeof s === 'object' ) {
		s = JSON.stringify( s );
	}
	if ( typeof type !== 'undefined' ) {
		var b = document.createElement( 'B' );
		b.appendChild( document.createTextNode( type + ': ' ) );
		span.appendChild( b );
	}
	span.appendChild( document.createTextNode( s ) );
	if ( typeof color !== 'undefined' ) {
		span.style.color = color;
	}
	this.logContainer.appendChild( span );
	this.logContainer.appendChild( document.createElement( 'HR' ) );
	this.logContainer.scrollTop = this.logContainer.scrollHeight;
}

/**
 * note: may be used as "inline html" event handler, thus should return true / false
 */
WikiSyncLog.prototype.clear = function() {
	this.logContainer.innerHTML = '';
	return false;
}
/* end of WikiSyncLog class */
