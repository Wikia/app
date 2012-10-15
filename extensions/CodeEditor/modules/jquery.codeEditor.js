/* Ace syntax-highlighting code editor extension for wikiEditor */

( function( $ ) {

$.wikiEditor.modules.codeEditor = {

/**
 * Core Requirements
 */
'req': [ 'codeEditor' ],
/**
 * Configuration
 */
cfg: {
	//
},
/**
 * API accessible functions
 */
api: {
	//
},
/**
 * Event handlers
 */
evt: {
	//
},
/**
 * Internally used functions
 */
fn: {
}

};

$.wikiEditor.extensions.codeEditor = function( context ) {

/*
 * Event Handlers
 *
 * These act as filters returning false if the event should be ignored or returning true if it should be passed
 * on to all modules. This is also where we can attach some extra information to the events.
 */
context.evt = $.extend( context.evt, {
	/**
	 * Filters change events, which occur when the user interacts with the contents of the iframe. The goal of this
	 * function is to both classify the scope of changes as 'division' or 'character' and to prevent further
	 * processing of events which did not actually change the content of the iframe.
	 */
	'keydown': function( event ) {
	},
	'change': function( event ) {
	},
	'delayedChange': function( event ) {
	},
	'cut': function( event ) {
	},
	'paste': function( event ) {
	},
	'ready': function( event ) {
	},
	'codeEditorSubmit': function( event ) {
		context.$textarea.val( context.$textarea.textSelection( 'getContents' ) );
	}
} );

var cookieEnabled = $.cookie('wikiEditor-' + context.instance + '-codeEditor-enabled');
context.codeEditorActive = (cookieEnabled != '0');

/**
 * Internally used functions
 */
context.fn = $.extend( context.fn, {
	'codeEditorToolbarIcon': function() {
		// When loaded as a gadget, one may need to override the wiki's own assets path.
		var iconPath = mw.config.get('wgCodeEditorAssetsPath', mw.config.get('wgExtensionAssetsPath')) + '/CodeEditor/images/';
		return iconPath + (context.codeEditorActive ? 'code-selected.png' : 'code.png');
	},
	'setupCodeEditorToolbar': function() {
		// Drop out some formatting that isn't relevant on these pages...
		context.api.removeFromToolbar(context, {
			'section': 'main',
			'group': 'format',
			'tool': 'bold'
		});
		context.api.removeFromToolbar(context, {
			'section': 'main',
			'group': 'format',
			'tool': 'italic'
		});
		var callback = function( context ) {
			context.codeEditorActive = !context.codeEditorActive;
			$.cookie(
				'wikiEditor-' + context.instance + '-codeEditor-enabled',
				context.codeEditorActive ? 1 : 0,
				{ expires: 30, path: '/' }
			);
			context.fn.toggleCodeEditorToolbar();

			if (context.codeEditorActive) {
				// set it back up!
				context.fn.setupCodeEditor();
			} else {
				context.fn.disableCodeEditor();
			}
		}
		context.api.addToToolbar( context, {
			'section': 'main',
			'group': 'format',
			'tools': {
				'codeEditor': {
					'labelMsg': 'codeeditor-toolbar-toggle',
					'type': 'button',
					'icon': context.fn.codeEditorToolbarIcon(),
					'action': {
						'type': 'callback',
						'execute': callback
					}
				}
			}
		} );
	},
	'toggleCodeEditorToolbar': function() {
		var target = 'img.tool[rel=codeEditor]';
		var $img = context.modules.toolbar.$toolbar.find( target );
		$img.attr('src', context.fn.codeEditorToolbarIcon());
	},
	/**
	 * Sets up the iframe in place of the textarea to allow more advanced operations
	 */
	'setupCodeEditor': function() {
		var box = context.$textarea;

		var lang = mw.config.get("wgCodeEditorCurrentLanguage")
		if (lang) {
			// Ace doesn't like replacing a textarea directly.
			// We'll stub this out to sit on top of it...
			// line-height is needed to compensate for oddity in WikiEditor extension, which zeroes the line-height on a parent container
			var container = context.$codeEditorContainer = $('<div style="position: relative"><div class="editor" style="line-height: 1.5em; top: 0px; left: 0px; right: 0px; bottom: 0px; border: 1px solid gray"></div></div>').insertAfter(box);
			var editdiv = container.find('.editor');

			box.css('display', 'none');
			container.width(box.width())
					 .height(box.height());

			editdiv.text(box.val());
			context.codeEditor = ace.edit(editdiv[0]);
			
			// Disable some annoying commands
			context.codeEditor.commands.removeCommand('replace');          // ctrl+R
			context.codeEditor.commands.removeCommand('transposeletters'); // ctrl+T
			context.codeEditor.commands.removeCommand('gotoline');         // ctrl+L

			// fakeout for bug 29328
			context.$iframe = [
				{
					contentWindow: {
						focus: function() {
							context.codeEditor.focus();
						}
					}
				}
			];
			box.closest('form').submit( context.evt.codeEditorSubmit );
			context.codeEditor.getSession().setMode(new (require("ace/mode/" + lang).Mode));

			// Force the box to resize horizontally to match in future :D
			var resize = function() {
				container.width(box.width());
			};
			$(window).resize(resize);
			// Use jquery.ui.resizable so user can make the box taller too
			container.resizable({
				handles: 's',
				minHeight: box.height(),
				resize: function() {
					context.codeEditor.resize();
				}
			});

			var summary = $('#wpSummary');
			if (summary.val() == '') {
				summary.val('/* using [[mw:CodeEditor|CodeEditor]] */ ');
			}
			// Let modules know we're ready to start working with the content
			context.fn.trigger( 'ready' );
		}
	},

	/**
	 *  Turn off the code editor view and return to the plain textarea.
	 * May be needed by some folks with funky browsers, or just to compare.
	 */
	'disableCodeEditor': function() {
		// Kills it!
		context.$textarea.closest('form').unbind('submit', context.evt.onCodeEditorSubmit );

		// Save contents
		context.$textarea.val(context.fn.getContents());

		// @todo fetch cursor, scroll position

		// Drop the fancy editor widget...
		context.$codeEditorContainer.remove();
		context.$codeEditorContainer = undefined;
		context.$iframe = undefined;
		context.codeEditor = undefined;

		// Restore textarea
		context.$textarea.show();

		// @todo restore cursor, scroll position
	}
});

/**
 * Override the base functions in a way that lets
 * us fall back to the originals when we turn off.
 */
var saveAndExtend = function( base, extended ) {
	var saved = {};
	// $.map doesn't handle objects in jQuery < 1.6; need this for compat with MW 1.17
	var map = function( obj, callback ) {
		for (var key in extended ) {
			if ( obj.hasOwnProperty( key ) ) {
				callback( obj[key], key );
			}
		}
	};
	map( extended, function( func, name ) {
		if ( name in base ) {
			var orig = base[name];
			base[name] = function() {
				if (context.codeEditorActive) {
					return func.apply(this, arguments);
				} else if (orig) {
					return orig.apply(this, arguments);
				} else {
					throw new Error('CodeEditor: no original function to call for ' + name);
				}
			}
		} else {
			base[name] = func;
		}
	});
};

saveAndExtend( context.fn, {
	'saveCursorAndScrollTop': function() {
		// Stub out textarea behavior
		return;
	},
	'restoreCursorAndScrollTop': function() {
		// Stub out textarea behavior
		return;
	},
	'saveSelection': function() {
		mw.log('codeEditor stub function saveSelection called');
	},
	'restoreSelection': function() {
		mw.log('codeEditor stub function restoreSelection called');
	},

	/* Needed for search/replace */
	'getContents': function() {
		return context.codeEditor.getSession().getValue();
	},

	/**
	 * Compatibility with the $.textSelection jQuery plug-in. When the iframe is in use, these functions provide
	 * equivilant functionality to the otherwise textarea-based functionality.
	 */

	'getElementAtCursor': function() {
		mw.log('codeEditor stub function getElementAtCursor called');
	},

	/**
	 * Gets the currently selected text in the content
	 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
	 */
	'getSelection': function() {
		return context.codeEditor.getCopyText();
	},
	/**
	 * Inserts text at the begining and end of a text selection, optionally inserting text at the caret when
	 * selection is empty.
	 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
	 */
	'encapsulateSelection': function( options ) {
		// Does not yet handle 'ownline', 'splitlines' option
		var sel = context.codeEditor.getSelection();
		var range = sel.getRange();
		var selText = context.fn.getSelection();
		var isSample = false;
		if ( !selText ) {
			selText = options.peri;
			isSample = true;
		} else if ( options.replace ) {
			selText = options.peri;
		}
		var text = options.pre;
		text += selText;
		text += options.post;
		context.codeEditor.insert( text );
		if ( isSample && options.selectPeri && !options.splitlines ) {
			// May esplode if anything has newlines, be warned. :)
			range.setStart( range.start.row, range.start.column + options.pre.length );
			range.setEnd( range.start.row, range.start.column + selText.length );
			sel.setSelectionRange(range);
		}
		return context.$textarea;
	},
	/**
	 * Gets the position (in resolution of bytes not nessecarily characters) in a textarea
	 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
	 */
	'getCaretPosition': function( options ) {
		mw.log('codeEditor stub function getCaretPosition called');
	},
	/**
	 * Sets the selection of the content
	 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
	 *
	 * @param start Character offset of selection start
	 * @param end Character offset of selection end
	 * @param startContainer Element in iframe to start selection in. If not set, start is a character offset
	 * @param endContainer Element in iframe to end selection in. If not set, end is a character offset
	 */
	'setSelection': function( options ) {
		// Ace stores positions for ranges as row/column pairs.
		// To convert from character offsets, we'll need to iterate through the document
		var doc = context.codeEditor.getSession().getDocument();
		var lines = doc.getAllLines();

		var offsetToPos = function( offset ) {
			var row = 0, col = 0;
			var pos = 0;
			while ( row < lines.length && pos + lines[row].length < offset) {
				pos += lines[row].length;
				pos++; // for the newline
				row++;
			}
			col = offset - pos;
			return {row: row, column: col};
		}
		var start = offsetToPos( options.start ),
			end = offsetToPos( options.end );

		var sel = context.codeEditor.getSelection();
		var range = sel.getRange();
		range.setStart( start.row, start.column );
		range.setEnd( end.row, end.column );
		sel.setSelectionRange( range );
		return context.$textarea;
	},
	/**
	 * Scroll a textarea to the current cursor position. You can set the cursor position with setSelection()
	 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
	 */
	'scrollToCaretPosition': function( options ) {
		mw.log('codeEditor stub function scrollToCaretPosition called');
		return context.$textarea;
	},
	/**
	 * Scroll an element to the top of the iframe
	 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
	 *
	 * @param $element jQuery object containing an element in the iframe
	 * @param force If true, scroll the element even if it's already visible
	 */
	'scrollToTop': function( $element, force ) {
		mw.log('codeEditor stub function scrollToTop called');
	}
} );

/* Setup the editor */
context.fn.setupCodeEditorToolbar();
if (context.codeEditorActive) {
	context.fn.setupCodeEditor();
}

} } )( jQuery );
