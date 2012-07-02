/*
 * jQuery MediaWiki LinkSuggest 1.1.0
 * JavaScript for LinkSuggest extension
 *
 * Copyright © 2010
 * Authors: Inez Korczyński (korczynski at gmail dot com)
 *          Jesús Martínez Novo (martineznovo at gmail dot com)
 * Licensed under the GPL (GPL-LICENSE.txt) license.
 *
 * Depends:
 *	jquery.ui.autocomplete.js
 */
( function( $ ) {

$.widget( 'mw.linksuggest', {
	options: {
		minLength: 3,
		delay: 300,
		url: window.wgScript
	},
	_create: function() {
		var self = this;
		var opt = {
			source: function() {
				self._sendQuery.apply( self, arguments );
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				self._updateValue( ui.item );
				// prevent value inserted on select
				return false;
			},
			open: function() {
				self._open.apply( self, arguments );
			}
		};
		// Opera only prevents default behavior on keypress, needed for
		// capturing arrows and enter
		var eventType = $.browser.opera ? 'keypress' : 'keydown';
		this.options = $.extend( opt, this.options );
		this.element.autocomplete( this.options );
		// Overwrite the keydown event of autocomplete to fix some undesired key events
		if ( typeof( this.element.data( 'events' ).keydown[0] ) !== undefined ) {
			this._legacyKeydown = this.element.data( 'events' ).keydown[0].handler;
		}
		this.element.unbind( 'keydown.autocomplete' )
		.bind( eventType + '.linksuggest', function( thisInstance ) {
			return function() {
				thisInstance._keydown.apply( thisInstance, arguments );
			};
		}( this ));
		// deactivate some menu weird behavior
		this.element.data( 'autocomplete' ).menu.options.blur = null;
	},
	_legacyKeydown: null,
	_keydown: function( event ) {
		var keyCode = $.ui.keyCode;
		switch( event.keyCode ) {
			case keyCode.UP:
			case keyCode.DOWN:
				if ( !this.element.data( 'autocomplete' ).menu.element.is( ':visible' ) ) {
					// If menu element is not visible, ignore.
					// Autocomplete event handler just prevents default
					// behavior, which is not what we want
					return;
				}
				break;
			case keyCode.TAB:
				// don't navigate away from the field on tab when selecting an item
				if ( this.element.data( 'autocomplete' ).menu.active ) {
					event.preventDefault();
				}
				break;
			case keyCode.ESCAPE:
				// return without setting any value
				this.element.data( 'autocomplete' ).close( event );
				return;
				break;
			case keyCode.PAGE_UP:
			case keyCode.PAGE_DOWN:
			case keyCode.LEFT:
			case keyCode.RIGHT:
			case keyCode.SHIFT:
			case keyCode.CONTROL:
			case keyCode.ALT:
			case keyCode.COMMAND:
			case keyCode.COMMAND_RIGHT:
			case keyCode.INSERT:
			case keyCode.CAPS_LOCK:
			case keyCode.END:
			case keyCode.HOME:
				// ignore metakeys (shift, ctrl, alt)
				return
				break;
		}
		// If we not already returned from this function, fire the old autocomplete handler
		if ( $.isFunction( this._legacyKeydown ) ) {
			this._legacyKeydown.apply( this.element.data( 'autocomplete' ), arguments );
		}
	},
	_sendQuery: function( request, response ) {
		var emptyset = [];
		var text = this._getText();
		var caret = this._getCaret();
		var sQueryStartAt = -1;
		var sQueryReal = '';
		var format = '';
		var stripPrefix = false;

		// Look forward, to see if we closed this one
		for ( var i = caret; i < text.length; i++ ) {
			var c = text.charAt( i );
			var c1 = ( i > 0 ? text.charAt( i - 1 ) : '' );
			// A line break, it isn't closed
			if ( c == '\n' ) {
				break;
			}
			// A start of a link, so this link isn't closed
			if ( c == '[' && c1 == '[' ) {
				break;
			}
			// A closing link and this was a link, exit
			if ( c == ']' && c1 == ']' ) {
				response( emptyset );
				return false;
			}
			// A start of a template, so this template isn't closed
			if ( c == '{' && c1 == '{' ) {
				break;
			}
			// A closing template and this was a template, exit
			if ( c == '}' && c1 == '}' ) {
				response( emptyset );
				return false;
			}
		}

		// Get the start of the link/template
		for ( var i = caret - 1; i >= 0; i-- ) {
			var c = text.charAt( i );
			// If nothing found after a line break, nothing to match
			if ( c == '\n' ) {
				break;
			}
			// Closed link/template, a pipe or a hash.
			// There's no link/template to complete, or we're on a parser
			// function or link hash
			if ( c == ']' || c == '}' || c == '|' || c == '#' ) {
				response( emptyset );
				return false;
			}

			// It's an open link
			if ( c == '[' && i > 0 && text.charAt( i - 1 ) == '[' ) {
				sQueryReal = text.substr( i + 1, ( caret - i - 1 ) );
				if ( sQueryReal.charAt( 0 ) == ':' ) {
					sQueryReal = sQueryReal.substr( 1 );
					format = '[[:$1]]';
				} else {
					format = '[[$1]]';
				}
				sQueryStartAt = i;
				break;
			}

			// It's an open template
			if ( c == '{' && i > 0 && text.charAt( i - 1 ) == '{' ) {
				// Exclude template parameters
				if ( i > 1 && text.charAt( i - 2 ) == '{' ) {
					response( emptyset );
					return false;
				}
				sQueryReal = text.substr( i + 1, ( caret - i - 1 ) );
				if ( sQueryReal.length >= 6 && sQueryReal.toLowerCase().substr( 0, 6 ) == 'subst:' ) {
					if ( sQueryReal.length >= 7 && sQueryReal.charAt( 6 ) == ':' ) {
						sQueryReal = sQueryReal.substr( 7 );
						format = '{{subst::$1}}';
					} else {
						sQueryReal = 'Template:' + sQueryReal.substr( 6 );
						stripPrefix = true;
						format = '{{subst:$1}}';
					}
				} else if ( sQueryReal.charAt( 0 ) == ':' ) {
					sQueryReal = sQueryReal.substr( 1 );
					format = '{{:$1}}';
				} else {
					sQueryReal = 'Template:' + sQueryReal;
					stripPrefix = true;
					format = '{{$1}}';
				}
				sQueryStartAt = i;
				break;
			}
		}

		if ( sQueryStartAt >= 0 && sQueryReal.length > this.options.minLength ) {
			$.get(
				this.options.url,
				{
					action: 'ajax',
					rs: 'getLinkSuggest',
					query: sQueryReal
				},
				this._responseWrapper( this, response, format, stripPrefix )
			);
			return true;
		}
		response( emptyset );
		return false
	},
	_responseWrapper: function( thisArg, callback, format, stripPrefix ) {
		return function( data ) {
			if ( data.length == 0 ) {
				return callback( [] );
			}
			callback( thisArg._formatResponse( data, format, stripPrefix ) );
		};
	},
	_formatResponse: function( data, format, stripPrefix ) {
		return $.map( data.split( '\n' ), function( n ) {
			if ( stripPrefix ) {
				var pos = n.indexOf( ':' );
				if ( pos >= 0 ) {
					n = n.substr( pos + 1 );
				}
			}
			return { label: n, value: format.replace( '$1', n ) };
		} );
	},
	_updateValue: function( oItem ) {
		this.element[0].focus();

		var scrollTop = this.element[0].scrollTop;
		var text = this._getText();
		var caret = this._getCaret();
		var prefix = oItem.value.substr( 0, 2 );

		for ( var i = caret - 2; i >= 0; i-- ) { // break for templates and normal links
			if ( text.substr( i, 2 ) == prefix ) {
				break;
			}
		}

		var textBefore = text.substr( 0, i );
		var newVal = textBefore + oItem.value + text.substr( caret );
		this.element.val( newVal );

		this._setCaret( textBefore.length + oItem.value.length );
		this.element[0].scrollTop = scrollTop;
	},
	_getCaret: function() {
		var caretPos = 0;
		var control = this.element[0];
		// IE Support
		if ( document.selection && document.selection.createRange ) {
			control.focus();
			var sel = document.selection.createRange();
			var sel2 = sel.duplicate();
			sel2.moveToElementText( control );
			var caretPos = -1;
			while ( sel2.inRange( sel ) ) {
				sel2.moveStart( 'character' );
				caretPos++;
			}
		// Firefox support
		} else if ( control.selectionStart || control.selectionStart == '0' ) {
			caretPos = control.selectionStart;
		}
		return caretPos;
	},
	_getText: function() {
		if ( document.selection && document.selection.createRange ) {
			return this.element.val();
		}
		// jQuery.val() removes \n, we need them so we get the caret position
		// correctly. That does not apply to document.selection
		return this.element[0].value;
	},
	_setCaret: function( pos ) {
		var control = this.element[0];
		if ( control.setSelectionRange ) {
			control.focus();
			control.setSelectionRange( pos, pos );
		} else if ( control.createTextRange ) {
			var range = control.createTextRange();
			range.collapse( true );
			range.moveEnd( 'character', pos );
			range.moveStart( 'character', pos );
			range.select();
		}
	},
	_getCaretPosition: function() {
		var control = this.element[0];
		var left = 0;
		var top = 0;
		var tester = $( '<div style="position:absolute;top:-1000px;left:-1000px;white-space:pre-wrap;visibility:hidden;"></div>' );
		var text = this._getText();
		var caret = this._getCaret();
		var initialcaret = caret;
		if ( caret == 0 ) {
			// This should never happen
			return [ 0, 0 ];
		}
		// Get the position at the start of the link/template
		for ( var i = caret - 1; i >= 0; i-- ) {
			var c = text.charAt( i );
			if ( c == '[' || c == '{' ) {
				initialcaret = i + 1;
				break;
			}
		}
		// Create a tester container to get the size of the text before the
		// caret, and thus the position inside the element
		// WARNING: You MUST apply a font-family CSS attribute to the textarea
		// (to this particular one, or a generic `textarea {font-famly: whatever;}´)
		// so IE could retrieve the correct font-family used, otherwise it may
		// fail to position the drop-down correctly!
		var props = 'padding-top padding-right padding-bottom padding-left border-top-style border-right-style border-bottom-style border-left-style border-top-width border-right-width border-bottom-width border-left-width font-size font-family font-weight line-height'.split(' ');
		for ( var i = 0; i < props.length; i++ ) {
			tester.css( props[i], this.element.css( props[i] ) );
		}
 		// Using clientWidth because if the textarea has scroll, the effective
		// width for word wrap doesn't include the width used by the scrollbar
		tester.width( control.clientWidth ).appendTo( document.body ).text( text.substr( 0, caret ) );
		left = tester.outerWidth();
		top = tester.outerHeight() - control.scrollTop;
		var initialheight = tester.height();
		var paddingText = '';
		// Insert the text until the initial position of the element we want to
		// suggest, plus a space, to get the characters needed to force a word
		// wrap to a new line
		tester.text( text.substr( 0, initialcaret ) + ' ' );
		if ( tester.height() < initialheight ) {
			// If the height has been reduced then the element to suggest is
			// forcing a word wrap to a new line and it's on the left side of
			// the textarea
			left = 0;
		} else {
			// Get how many characters we need to force a word wrap to a new
			// line, and then transform it in an actual size
			// If we go beyond 500, something must be wrong
			for ( var i = 1; i < 500; i++ ) {
				paddingText += 'A';
				// msie appendData doesn't update the height()
				if ( $.browser.msie ) {
					tester[0].firstChild.data += 'A';
				} else {
					tester[0].firstChild.appendData( 'A' );
				}
				if ( tester.height() > initialheight ) {
					tester.css( 'width', 'auto' );
					tester.text( paddingText );
					left -= tester.outerWidth();
					break;
				}
			}
		}
		tester.remove();
		return [ left, top ];
	},
	_open: function( event, ui ) {
		var menu = this.element.data( 'autocomplete' ).menu.element;
		var offset = this._getCaretPosition();
		var width = menu.outerWidth();
		var props = {
			my: 'left top',
			at: 'left top',
			of: this.element,
			offset: offset.join( ' ' ),
			collision: 'fit none'
		};
		if ( offset.left + width > this.element.outerWidth() ) {
			props.my = 'right top';
		}
		menu.width( '' ).position( props );
	}

});

}( jQuery ));

// Implementation: This should be done injecting this code into MediaWiki, not
// in this JS file
$( function() {
	// Apply font-style for bug in IE. This should be done using a style sheet
	$( '#wpTextbox1' ).css( 'font-family', 'monospace' ).linksuggest();
});