/**
 * This plugin provides a way to build a wiki-text editing user interface around a textarea.
 *
 * @example To intialize without any modules:
 * 		$( 'div#edittoolbar' ).wikiEditor();
 *
 * @example To initialize with one or more modules, or to add modules after it's already been initialized:
 * 		$( 'textarea#wpTextbox1' ).wikiEditor( 'addModule', 'toolbar', { ... config ... } );
 *
 */
( function( $ ) {

/**
 * Global static object for wikiEditor that provides generally useful functionality to all modules and contexts.
 */
$.wikiEditor = {
	/**
	 * For each module that is loaded, static code shared by all instances is loaded into this object organized by
	 * module name. The existance of a module in this object only indicates the module is available. To check if a
	 * module is in use by a specific context check the context.modules object.
	 */
	'modules': {},
	/**
	 * A context can be extended, such as adding iframe support, on a per-wikiEditor instance basis.
	 */
	'extensions': {},
	/**
	 * In some cases like with the iframe's HTML file, it's convienent to have a lookup table of all instances of the
	 * WikiEditor. Each context contains an instance field which contains a key that corrosponds to a reference to the
	 * textarea which the WikiEditor was build around. This way, by passing a simple integer you can provide a way back
	 * to a specific context.
	 */
	'instances': [],
	/**
	 * For each browser name, an array of conditions that must be met are supplied in [operaton, value]-form where
	 * operation is a string containing a JavaScript compatible binary operator and value is either a number to be
	 * compared with $.browser.versionNumber or a string to be compared with $.browser.version. If a browser is not
	 * specifically mentioned, we just assume things will work.
	 */
	'browsers': {
		// Left-to-right languages
		'ltr': {
			// The toolbar layout is broken in IE6
			'msie': [['>=', 7]],
			// Layout issues in FF < 2
			'firefox': [['>=', 2]],
			// Text selection bugs galore - this may be a different situation with the new iframe-based solution
			'opera': [['>=', 9.6]],
			// jQuery minimums
			'safari': [['>=', 3]],
			'chrome': [['>=', 3]],
			'netscape': [['>=', 9]],
			'blackberry': false,
			'ipod': false,
			'iphone': false
		},
		// Right-to-left languages
		'rtl': {
			// The toolbar layout is broken in IE 7 in RTL mode, and IE6 in any mode
			'msie': [['>=', 8]],
			// Layout issues in FF < 2
			'firefox': [['>=', 2]],
			// Text selection bugs galore - this may be a different situation with the new iframe-based solution
			'opera': [['>=', 9.6]],
			// jQuery minimums
			'safari': [['>=', 3]],
			'chrome': [['>=', 3]],
			'netscape': [['>=', 9]],
			'blackberry': false,
			'ipod': false,
			'iphone': false
		}
	},
	/**
	 * Path to images - this is a bit messy, and it would need to change if this code (and images) gets moved into the
	 * core - or anywhere for that matter...
	 */
	'imgPath' : mw.config.get( 'wgExtensionAssetsPath' ) + '/WikiEditor/modules/images/',
	/**
	 * Checks the current browser against the browsers object to determine if the browser has been black-listed or not.
	 * Because these rules are often very complex, the object contains configurable operators and can check against
	 * either the browser version number or string. This process also involves checking if the current browser is amung
	 * those which we have configured as compatible or not. If the browser was not configured as comptible we just go on
	 * assuming things will work - the argument here is to prevent the need to update the code when a new browser comes
	 * to market. The assumption here is that any new browser will be built on an existing engine or be otherwise so
	 * similar to another existing browser that things actually do work as expected. The merrits of this argument, which
	 * is essentially to blacklist rather than whitelist are debateable, but at this point we've decided it's the more
	 * "open-web" way to go.
	 * @param module Module object, defaults to $.wikiEditor
	 */
	'isSupported': function( module ) {
		// Fallback to the wikiEditor browser map if no special map is provided in the module
		var mod = module && 'browsers' in module ? module : $.wikiEditor;
		// Check for and make use of cached value and early opportunities to bail
		if ( typeof mod.supported !== 'undefined' ) {
			// Cache hit
			return mod.supported;
		}
		// Run a browser support test and then cache and return the result
		return mod.supported = $.client.test( mod.browsers );
	},
	/**
	 * Checks if a module has a specific requirement
	 * @param module Module object
	 * @param requirement String identifying requirement
	 */
	'isRequired': function( module, requirement ) {
		if ( typeof module['req'] !== 'undefined' ) {
			for ( var req in module['req'] ) {
				if ( module['req'][req] == requirement ) {
					return true;
				}
			}
		}
		return false;
	},
	/**
	 * Provides a way to extract messages from objects. Wraps the mediaWiki.msg() function, which
	 * may eventually become a wrapper for some kind of core MW functionality.
	 *
	 * @param object Object to extract messages from
	 * @param property String of name of property which contains the message. This should be the base name of the
	 * property, which means that in the case of the object { this: 'that', fooMsg: 'bar' }, passing property as 'this'
	 * would return the raw text 'that', while passing property as 'foo' would return the internationalized message
	 * with the key 'bar'.
	 */
	'autoMsg': function( object, property ) {
		// Accept array of possible properties, of which the first one found will be used
		if ( typeof property == 'object' ) {
			for ( var i in property ) {
				if ( property[i] in object || property[i] + 'Msg' in object ) {
					property = property[i];
					break;
				}
			}
		}
		if ( property in object ) {
			return object[property];
		} else if ( property + 'Msg' in object ) {
			var p = object[property + 'Msg'];
			if ( $.isArray( p ) && p.length >= 2 ) {
				return mediaWiki.msg.apply( mediaWiki.msg, p );
			} else {
				return mediaWiki.msg( p );
			}
		} else {
			return '';
		}
	},
	/**
	 * Provides a way to extract a property of an object in a certain language, falling back on the property keyed as
	 * 'default' or 'default-rtl'. If such key doesn't exist, the object itself is considered the actual value, which
	 * should ideally be the case so that you may use a string or object of any number of strings keyed by language
	 * with a default.
	 *
	 * @param object Object to extract property from
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoLang': function( object, lang ) {
		var defaultKey = $( 'body' ).hasClass( 'rtl' ) ? 'default-rtl' : 'default';
		return object[lang || mw.config.get( 'wgUserLanguage' )] || object[defaultKey] || object['default'] || object;
	},
	/**
	 * Provides a way to extract the path of an icon in a certain language, automatically appending a version number for
	 * caching purposes and prepending an image path when icon paths are relative.
	 *
	 * @param icon Icon object from e.g. toolbar config
	 * @param path Default icon path, defaults to $.wikiEditor.imgPath
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoIcon': function( icon, path, lang ) {
		var src = $.wikiEditor.autoLang( icon, lang );
		path = path || $.wikiEditor.imgPath;
		// Prepend path if src is not absolute
		if ( src.substr( 0, 7 ) != 'http://' && src.substr( 0, 8 ) != 'https://' && src[0] != '/' ) {
			src = path + src;
		}
		return src + '?' + mw.loader.version( 'jquery.wikiEditor' );
	},
	/**
	 * Get the sprite offset for a language if available, icon for a language if available, or the default offset or icon,
	 * in that order of preference.
	 * @param icon Icon object, see autoIcon()
	 * @param offset Offset object
	 * @param path Icon path, see autoIcon()
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoIconOrOffset': function( icon, offset, path, lang ) {
		lang = lang || mw.config.get( 'wgUserLanguage' );
		if ( typeof offset == 'object' && lang in offset ) {
			return offset[lang];
		} else if ( typeof icon == 'object' && lang in icon ) {
			return $.wikiEditor.autoIcon( icon, undefined, lang );
		} else {
			return $.wikiEditor.autoLang( offset, lang );
		}
	}
};

/**
 * jQuery plugin that provides a way to initialize a wikiEditor instance on a textarea.
 */
$.fn.wikiEditor = function() {

// Skip any further work when running in browsers that are unsupported
if ( !$.wikiEditor.isSupported() ) {
	return $(this);
}

/* Initialization */

// The wikiEditor context is stored in the element's data, so when this function gets called again we can pick up right
// where we left off
var context = $(this).data( 'wikiEditor-context' );
// On first call, we need to set things up, but on all following calls we can skip right to the API handling
if ( !context || typeof context == 'undefined' ) {

	// Star filling the context with useful data - any jQuery selections, as usual should be named with a preceding $
	context = {
		// Reference to the textarea element which the wikiEditor is being built around
		'$textarea': $(this),
		// Container for any number of mutually exclusive views that are accessible by tabs
		'views': {},
		// Container for any number of module-specific data - only including data for modules in use on this context
		'modules': {},
		// General place to shouve bits of data into
		'data': {},
		// Unique numeric ID of this instance used both for looking up and differentiating instances of wikiEditor
		'instance': $.wikiEditor.instances.push( $(this) ) - 1,
		// Array mapping elements in the textarea to character offsets
		'offsets': null,
		// Cache for context.fn.htmlToText()
		'htmlToTextMap': {},
		// The previous HTML of the iframe, stored to detect whether something really changed.
		'oldHTML': null,
		// Same for delayedChange()
		'oldDelayedHTML': null,
		// The previous selection of the iframe, stored to detect whether the selection has changed
		'oldDelayedSel': null,
		// Saved selection state for IE
		'savedSelection': null,
		// Stack of states in { html: [string] } form
		'history': [],
		// Current history state position - this is number of steps backwards, so it's always -1 or less
		'historyPosition': -1,
		/// The previous historyPosition, stored to detect if change events were due to an undo or redo action
		'oldDelayedHistoryPosition': -1,
		// List of extensions active on this context
		'extensions': []
	};

	/**
	 * Externally Accessible API
	 *
	 * These are available using calls to $(selection).wikiEditor( call, data ) where selection is a jQuery selection
	 * of the textarea that the wikiEditor instance was built around.
	 */

	context.api = {
		/**
		 * Activates a module on a specific context with optional configuration data.
		 *
		 * @param data Either a string of the name of a module to add without any additional configuration parameters,
		 * or an object with members keyed with module names and valued with configuration objects.
		 */
		'addModule': function( context, data ) {
			var modules = {};
			if ( typeof data == 'string' ) {
				modules[data] = {};
			} else if ( typeof data == 'object' ) {
				modules = data;
			}
			for ( var module in modules ) {
				// Check for the existance of an available / supported module with a matching name and a create function
				if ( typeof module == 'string' && typeof $.wikiEditor.modules[module] !== 'undefined' &&
						$.wikiEditor.isSupported( $.wikiEditor.modules[module] ) )
				{
					// Extend the context's core API with this module's own API calls
					if ( 'api' in $.wikiEditor.modules[module] ) {
						for ( var call in $.wikiEditor.modules[module].api ) {
							// Modules may not overwrite existing API functions - first come, first serve
							if ( !( call in context.api ) ) {
								context.api[call] = $.wikiEditor.modules[module].api[call];
							}
						}
					}
					// Activate the module on this context
					if ( 'fn' in $.wikiEditor.modules[module] && 'create' in $.wikiEditor.modules[module].fn ) {
						// Add a place for the module to put it's own stuff
						context.modules[module] = {};
						// Tell the module to create itself on the context
						$.wikiEditor.modules[module].fn.create( context, modules[module] );
					}
				}
			}
		}
	};

	/**
	 * Event Handlers
	 *
	 * These act as filters returning false if the event should be ignored or returning true if it should be passed
	 * on to all modules. This is also where we can attach some extra information to the events.
	 */

	context.evt = {
		/* Empty until extensions add some; see jquery.wikiEditor.iframe.js for examples. */
	};

	/* Internal Functions */

	context.fn = {
		/**
		 * Executes core event filters as well as event handlers provided by modules.
		 */
		'trigger': function( name, event ) {
			// Event is an optional argument, but from here on out, at least the type field should be dependable
			if ( typeof event == 'undefined' ) {
				event = { 'type': 'custom' };
			}
			// Ensure there's a place for extra information to live
			if ( typeof event.data == 'undefined' ) {
				event.data = {};
			}

			// Allow filtering to occur
			if ( name in context.evt ) {
				if ( !context.evt[name]( event ) ) {
					return false;
				}
			}
			var returnFromModules = null; //they return null by default
			// Pass the event around to all modules activated on this context

			for ( var module in context.modules ) {
				if (
					module in $.wikiEditor.modules &&
					'evt' in $.wikiEditor.modules[module] &&
					name in $.wikiEditor.modules[module].evt
				) {
					var ret = $.wikiEditor.modules[module].evt[name]( context, event );
					if (ret != null) {
						//if 1 returns false, the end result is false
						if( returnFromModules == null ) {
							returnFromModules = ret;
						} else {
							returnFromModules = returnFromModules && ret;
						}
					}
				}
			}
			if ( returnFromModules != null ) {
				return returnFromModules;
			} else {
				return true;
			}
		},
		/**
		 * Adds a button to the UI
		 */
		'addButton': function( options ) {
			// Ensure that buttons and tabs are visible
			context.$controls.show();
			context.$buttons.show();
			return $( '<button />' )
				.text( $.wikiEditor.autoMsg( options, 'caption' ) )
				.click( options.action )
				.appendTo( context.$buttons );
		},
		/**
		 * Adds a view to the UI, which is accessed using a set of tabs. Views are mutually exclusive and by default a
		 * wikitext view will be present. Only when more than one view exists will the tabs will be visible.
		 */
		'addView': function( options ) {
			// Adds a tab
			function addTab( options ) {
				// Ensure that buttons and tabs are visible
				context.$controls.show();
				context.$tabs.show();
				// Return the newly appended tab
				return $( '<div></div>' )
					.attr( 'rel', 'wikiEditor-ui-view-' + options.name )
					.addClass( context.view == options.name ? 'current' : null )
					.append( $( '<a></a>' )
						.attr( 'href', '#' )
						.mousedown( function() {
							// No dragging!
							return false;
						} )
						.click( function( event ) {
							context.$ui.find( '.wikiEditor-ui-view' ).hide();
							context.$ui.find( '.' + $(this).parent().attr( 'rel' ) ).show();
							context.$tabs.find( 'div' ).removeClass( 'current' );
							$(this).parent().addClass( 'current' );
							$(this).blur();
							if ( 'init' in options && typeof options.init == 'function' ) {
								options.init( context );
							}
							event.preventDefault();
							return false;
						} )
						.text( $.wikiEditor.autoMsg( options, 'title' ) )
					)
					.appendTo( context.$tabs );
			}
			// Automatically add the previously not-needed wikitext tab
			if ( !context.$tabs.children().size() ) {
				addTab( { 'name': 'wikitext', 'titleMsg': 'wikieditor-wikitext-tab' } );
			}
			// Add the tab for the view we were actually asked to add
			addTab( options );
			// Return newly appended view
			return $( '<div></div>' )
				.addClass( 'wikiEditor-ui-view wikiEditor-ui-view-' + options.name )
				.hide()
				.appendTo( context.$ui );
		},
		/**
		 * Save scrollTop and cursor position for IE
		 */
		'saveCursorAndScrollTop': function() {
			if ( $.client.profile().name === 'msie' ) {
				var IHateIE = {
					'scrollTop' : context.$textarea.scrollTop(),
					'pos': context.$textarea.textSelection( 'getCaretPosition', { startAndEnd: true } )
				};
				context.$textarea.data( 'IHateIE', IHateIE );
			}
		},
		/**
		 * Restore scrollTo and cursor position for IE
		 */
		'restoreCursorAndScrollTop': function() {
			if ( $.client.profile().name === 'msie' ) {
				var IHateIE = context.$textarea.data( 'IHateIE' );
				if ( IHateIE ) {
					context.$textarea.scrollTop( IHateIE.scrollTop );
					context.$textarea.textSelection( 'setSelection', { start: IHateIE.pos[0], end: IHateIE.pos[1] } );
					context.$textarea.data( 'IHateIE', null );
				}
			}
		},
		/**
		 * Save text selection for IE
		 */
		'saveSelection': function() {
			if ( $.client.profile().name === 'msie' ) {
				context.$textarea.focus();
				context.savedSelection = document.selection.createRange();
			}
		},
		/**
		 * Restore text selection for IE
		 */
		'restoreSelection': function() {
			if ( $.client.profile().name === 'msie' && context.savedSelection !== null ) {
				context.$textarea.focus();
				context.savedSelection.select();
				context.savedSelection = null;
			}
		}
	};

	/**
	 * Base UI Construction
	 *
	 * The UI is built from several containers, the outer-most being a div classed as "wikiEditor-ui". These containers
	 * provide a certain amount of "free" layout, but in some situations procedural layout is needed, which is performed
	 * as a response to the "resize" event.
	 */

	// Assemble a temporary div to place over the wikiEditor while it's being constructed
	/* Disabling our loading div for now
	var $loader = $( '<div></div>' )
		.addClass( 'wikiEditor-ui-loading' )
		.append( $( '<span>' + mediaWiki.msg( 'wikieditor-loading' ) + '</span>' )
			.css( 'marginTop', context.$textarea.height() / 2 ) );
	*/
	// Encapsulate the textarea with some containers for layout
	context.$textarea
	/* Disabling our loading div for now
		.after( $loader )
		.add( $loader )
	*/
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-view wikiEditor-ui-view-wikitext' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-left' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-bottom' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-text' ) );
	// Get references to some of the newly created containers
	context.$ui = context.$textarea.parent().parent().parent().parent().parent();
	context.$wikitext = context.$textarea.parent().parent().parent().parent();
	// Add in tab and button containers
	context.$wikitext
		.before(
			$( '<div></div>' ).addClass( 'wikiEditor-ui-controls' )
				.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-tabs' ).hide() )
				.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-buttons' ) )
		)
		.before( $( '<div style="clear:both;"></div>' ) );
	// Get references to some of the newly created containers
	context.$controls = context.$ui.find( '.wikiEditor-ui-buttons' ).hide();
	context.$buttons = context.$ui.find( '.wikiEditor-ui-buttons' );
	context.$tabs = context.$ui.find( '.wikiEditor-ui-tabs' );
	// Clear all floating after the UI
	context.$ui.after( $( '<div style="clear:both;"></div>' ) );
	// Attach a right container
	context.$wikitext.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-right' ) );
	// Attach a top container to the left pane
	context.$wikitext.find( '.wikiEditor-ui-left' ).prepend( $( '<div></div>' ).addClass( 'wikiEditor-ui-top' ) );
	// Setup the intial view
	context.view = 'wikitext';
	// Trigger the "resize" event anytime the window is resized
	$( window ).resize( function( event ) { context.fn.trigger( 'resize', event ); } );
}

/* API Execution */

// Since javascript gives arguments as an object, we need to convert them so they can be used more easily
var args = $.makeArray( arguments );

// Dynamically setup core extensions for modules that are required
if ( args[0] == 'addModule' && typeof args[1] != 'undefined' ) {
	var modules = args[1];
	if ( typeof modules != "object" ) {
		modules = {};
		modules[args[1]] = '';
	}
	for ( var module in modules ) {
		// Only allow modules which are supported (and thus actually being turned on) affect the decision to extend
		if ( module in $.wikiEditor.modules && $.wikiEditor.isSupported( $.wikiEditor.modules[module] ) ) {
			// Activate all required core extensions on context
			for ( var e in $.wikiEditor.extensions ) {
				if (
					$.wikiEditor.isRequired( $.wikiEditor.modules[module], e ) &&
					$.inArray( e, context.extensions ) === -1
				) {
					context.extensions[context.extensions.length] = e;
        			$.wikiEditor.extensions[e]( context );
				}
			}
			break;
		}
	}
}

// There would need to be some arguments if the API is being called
if ( args.length > 0 ) {
	// Handle API calls
	var call = args.shift();
	if ( call in context.api ) {
		context.api[call]( context, typeof args[0] == 'undefined' ? {} : args[0] );
	}
}

// Store the context for next time, and support chaining
return $(this).data( 'wikiEditor-context', context );

}; } )( jQuery );
