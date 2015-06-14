( function ( $, mw ) {

	/**
	 * Debug console
	 * Based on JavaScript Shell 1.4 by Jesse Ruderman (GPL/LGPL/MPL tri-license)
	 *
	 * TODO:
	 *    * Refactor, more jQuery, etc.
	 *    * Spinner?
	 *    * A prompt in front of input lines and the textarea
	 *    * Collapsible backtrace display
	 */

	var
		histList = [""],
		histPos = 0,
		question,
		_in,
		_out,
		lastError = null,
		sessionContent = null,
		sessionKey = null,
		pending = false,
		clearNextRequest = false;

	function refocus() {
		_in.blur(); // Needed for Mozilla to scroll correctly.
		_in.focus();
	}

	function initConsole() {
		_in = document.getElementById( "mw-scribunto-input" );
		_out = document.getElementById( "mw-scribunto-output" );

		recalculateInputHeight();
		println( mw.msg( 'scribunto-console-intro' ), 'mw-scribunto-message' );
	}

	function inputKeydown( e ) {
		// Use onkeydown because IE doesn't support onkeypress for arrow keys

		if ( e.shiftKey && e.keyCode === 13 ) { // shift-enter
			// don't do anything; allow the shift-enter to insert a line break as normal
		} else if ( e.keyCode === 13 ) { // enter
			// execute the input on enter
			go();
		} else if ( e.keyCode === 38 ) { // up
			// go up in history if at top or ctrl-up
			if ( e.ctrlKey || caretInFirstLine( _in ) ) {
				hist( 'up' );
			}
		} else if ( e.keyCode === 40 ) { // down
			// go down in history if at end or ctrl-down
			if ( e.ctrlKey || caretInLastLine( _in ) ) {
				hist( 'down' );
			}
		}

		setTimeout( recalculateInputHeight, 0 );

		//return true;
	}

	function inputFocus( e ) {
		if ( sessionContent === null ) {
			// No previous state to clear
			return;
		}

		if ( clearNextRequest ) {
			// User already knows
			return;
		}

		if ( getContent() !== sessionContent ) {
			printClearBar( 'scribunto-console-cleared' );
			clearNextRequest = true;
		}
	}

	function caretInFirstLine( textbox ) {
		// IE doesn't support selectionStart/selectionEnd
		if ( textbox.selectionStart === undefined ) {
			return true;
		}

		var firstLineBreak = textbox.value.indexOf( "\n" );

		return ((firstLineBreak === -1) || (textbox.selectionStart <= firstLineBreak));
	}

	function caretInLastLine( textbox ) {
		// IE doesn't support selectionStart/selectionEnd
		if ( textbox.selectionEnd === undefined ) {
			return true;
		}

		var lastLineBreak = textbox.value.lastIndexOf( "\n" );

		return ( textbox.selectionEnd > lastLineBreak );
	}

	function recalculateInputHeight() {
		var rows = _in.value.split( /\n/ ).length
			+ 1 // prevent scrollbar flickering in Mozilla
			+ ( window.opera ? 1 : 0 ); // leave room for scrollbar in Opera

		// without this check, it is impossible to select text in Opera 7.60 or Opera 8.0.
		if ( _in.rows !== rows ) {
			_in.rows = rows;
		}
	}

	function println( s, type ) {
		if ( ( s = String( s ) ) ) {
			var newdiv = document.createElement( "div" );
			newdiv.appendChild( document.createTextNode( s ) );
			newdiv.className = type;
			_out.appendChild( newdiv );
			return newdiv;
		}
	}

	function printWithRunin( h, s, type ) {
		var div = println( s, type );
		var head = document.createElement( "strong" );
		head.appendChild( document.createTextNode( h + ": " ) );
		div.insertBefore( head, div.firstChild );
	}

	function printClearBar( msg ) {
		$( '<div/>' )
			.attr( 'class', 'mw-scribunto-clear' )
			.text( mw.msg( msg ) )
			.appendTo( _out );
	}

	function hist( direction ) {
		// histList[0] = first command entered, [1] = second, etc.
		// type something, press up --> thing typed is now in "limbo"
		// (last item in histList) and should be reachable by pressing
		// down again.

		var L = histList.length;

		if ( L === 1 ) {
			return;
		}

		if ( direction === 'up' ) {
			if ( histPos === L - 1 ) {
				// Save this entry in case the user hits the down key.
				histList[histPos] = _in.value;
			}

			if ( histPos > 0 ) {
				histPos--;
				// Use a timeout to prevent up from moving cursor within new text
				// Set to nothing first for the same reason
				setTimeout(
					function () {
						_in.value = '';
						_in.value = histList[histPos];
						var caretPos = _in.value.length;
						if ( _in.setSelectionRange ) {
							_in.setSelectionRange( caretPos, caretPos );
						}
					},
					0
				);
			}
		}
		else // down
		{
			if ( histPos < L - 1 ) {
				histPos++;
				_in.value = histList[histPos];
			}
			else if ( histPos === L - 1 ) {
				// Already on the current entry: clear but save
				if ( _in.value ) {
					histList[histPos] = _in.value;
					++histPos;
					_in.value = "";
				}
			}
		}
	}

	function printQuestion( q ) {
		println( q, "mw-scribunto-input" );
	}

	function printError( er ) {
		var lineNumberString;

		lastError = er; // for debugging the shell
		if ( er.name ) {
			// lineNumberString should not be "", to avoid a very wacky bug in IE 6.
			lineNumberString = (er.lineNumber !== undefined) ? (" on line " + er.lineNumber + ": ") : ": ";
			// Because IE doesn't have error.toString.
			println( er.name + lineNumberString + er.message, "mw-scribunto-error" );
		} else {
			println( er, "mw-scribunto-error" ); // Because security errors in Moz /only/ have toString.
		}
	}

	function setPending() {
		pending = true;
		_in.readOnly = true;
	}

	function clearPending() {
		pending = false;
		_in.readOnly = false;
	}

	function go() {
		if ( pending ) {
			// If there is an XHR request pending, don't send another one
			// We set readOnly on the textarea to give a UI indication, this is
			// just for paranoia.
			return;
		}

		question = _in.value;

		if ( question === "" ) {
			return;
		}

		histList[histList.length - 1] = question;
		histList[histList.length] = "";
		histPos = histList.length - 1;

		// Unfortunately, this has to happen *before* the script is run, so that
		// print() output will go in the right place.
		_in.value = '';
		// can't preventDefault on input, so also clear it later
		setTimeout( function () {
			_in.value = "";
		}, 0 );

		recalculateInputHeight();
		printQuestion( question );

		var params = {
			action: 'scribunto-console',
			title: mw.config.get( 'wgPageName' ),
			question: question
		};
		var content = getContent();
		var sentContent = false;
		if ( !sessionKey || sessionContent !== content ) {
			params.clear = true;
			params.content = content;
			sentContent = true;
		}
		if ( sessionKey ) {
			params.session = sessionKey;
		}
		if ( clearNextRequest ) {
			params.clear = true;
			clearNextRequest = false;
		}

		var api = new mw.Api();
		setPending();

		api.post( params, {
			ok: function ( result ) {
				if ( result.sessionIsNew === '' && !sentContent ) {
					// Session was lost. Resend query, with content
					printClearBar( 'scribunto-console-cleared-session-lost' );
					sessionContent = null;
					clearPending();
					_in.value = params.question;
					go();
					return;
				}
				sessionKey = result.session;
				sessionContent = content;
				if ( result.type === 'error' ) {
					printError( result.message );
				} else {
					if ( result.print !== '' ) {
						println( result.print, 'mw-scribunto-print' );
					}
					if ( result['return'] !== '' ) {
						println( result['return'], "mw-scribunto-normalOutput" );
					}
				}
				clearPending();
				setTimeout( refocus, 0 );
			},

			err: function ( code, result ) {
				if ( 'error' in result && 'info' in result.error ) {
					printError( result.error.info );
				} else if ( 'exception' in result ) {
					printError( 'Error sending API request: ' + result.exception );
				} else {
					console.log( result );
					printError( 'error' );
				}
				clearPending();
				setTimeout( refocus, 0 );
			}
		} );
	}

	function getContent() {
		var $textarea = $( '#wpTextbox1' ),
			context = $textarea.data( 'wikiEditor-context' );

		// Wikia change begin
		if (window.wgEnableCodePageEditor) {
			return window.ace.edit('editarea').getSession().getValue();
		}
		// Wikia change end

		if ( context === undefined || context.codeEditor === undefined ) {
			return $textarea.val();
		} else {
			return $textarea.textSelection( 'getContents' );
		}
	}

	function onClearClick( e ) {
		$( '#mw-scribunto-output' ).empty();
		clearNextRequest = true;
		refocus();
	}

	mw.scribunto.edit = {
		'init': function () {
			var action = mw.config.get( 'wgAction' );
			if ( action === 'edit' || action === 'submit' || action === 'editredlink' ) {
				this.initEditPage();
			}
		},

		'initEditPage': function () {
			var console = document.getElementById( 'mw-scribunto-console' );
			if ( !console ) {
				return;
			}

			$( '<fieldset/>' )
				.attr( 'class', 'mw-scribunto-console-fieldset' )
				.append( $( '<legend/>' ).text( mw.msg( 'scribunto-console-title' ) ) )
				.append( $( '<div id="mw-scribunto-output"></div>' ) )
				.append(
				$( '<div/>' ).append(
					$( '<textarea/>' )
						.attr( {
							id: 'mw-scribunto-input',
							'class': 'mw-scribunto-input',
							wrap: 'off',
							rows: 1,
							dir: 'ltr',
							lang: 'en'
						} )
						.bind( 'keydown', inputKeydown )
						.bind( 'focus', inputFocus )
				)
			)
				.append(
				$( '<div/>' ).append(
					$( '<input/>' )
						.attr( {
							type: 'button',
							value: mw.msg( 'scribunto-console-clear' )
						} )
						.bind( 'click', onClearClick )
				)
			)
				.wrap( '<form/>' )
				.appendTo( console );
			initConsole();
		}
	};

	$( document ).ready( function () {
		mw.scribunto.edit.init();
	} );

} ) ( jQuery, mediaWiki );

