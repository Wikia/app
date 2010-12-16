/**
 * Extend the RegExp object with an escaping function
 * From http://simonwillison.net/2006/Jan/20/escape/
 */
RegExp.escape = function( s ) { return s.replace(/([.*+?^${}()|\/\\[\]])/g, '\\$1'); };

/**
 * Dialog Module for wikiEditor
 */
( function( $ ) { $.wikiEditor.modules.dialogs = {

/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 7]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]],
		'chrome': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]],
		'chrome': [['>=', 4]]
	}
},
/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * API accessible functions
 */
api: {
	addDialog: function( context, data ) {
		$.wikiEditor.modules.dialogs.fn.create( context, data )
	},
	openDialog: function( context, module ) {
		if ( module in $.wikiEditor.modules.dialogs.modules ) {
			$( '#' + $.wikiEditor.modules.dialogs.modules[module].id ).dialog( 'open' );
		}
	},
	closeDialog: function( context, data ) {
		if ( module in $.wikiEditor.modules.dialogs.modules ) {
			$( '#' + $.wikiEditor.modules.dialogs.modules[module].id ).dialog( 'close' );
		}
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a dialog module within a wikiEditor
	 *
	 * @param {Object} context Context object of editor to create module in
	 * @param {Object} config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Add modules
		for ( module in config ) {
			$.wikiEditor.modules.dialogs.modules[module] = config[module];
		}
		// Build out modules immediately
		mw.usability.load( ['$j.ui', '$j.ui.dialog', '$j.ui.draggable', '$j.ui.resizable' ], function() {
			for ( module in $.wikiEditor.modules.dialogs.modules ) {
				var module = $.wikiEditor.modules.dialogs.modules[module];
				// Only create the dialog if it doesn't exist yet
				if ( $( '#' + module.id ).size() == 0 ) {
					var configuration = module.dialog;
					// Add some stuff to configuration
					configuration.bgiframe = true;
					configuration.autoOpen = false;
					configuration.modal = true;
					configuration.title = $.wikiEditor.autoMsg( module, 'title' );
					// Transform messages in keys
					// Stupid JS won't let us do stuff like
					// foo = { mw.usability.getMsg ('bar'): baz }
					configuration.newButtons = {};
					for ( msg in configuration.buttons )
						configuration.newButtons[mw.usability.getMsg( msg )] = configuration.buttons[msg];
					configuration.buttons = configuration.newButtons;
					// Create the dialog <div>
					var dialogDiv = $( '<div /> ' )
						.attr( 'id', module.id )
						.html( module.html )
						.data( 'context', context )
						.appendTo( $( 'body' ) )
						.each( module.init )
						.dialog( configuration );
					if ( !( 'resizeme' in module ) || module.resizeme ) {
						dialogDiv
							.bind( 'dialogopen', $.wikiEditor.modules.dialogs.fn.resize )
							.find( '.ui-tabs' ).bind( 'tabsshow', function() {
								$(this).closest( '.ui-dialog-content' ).each(
									$.wikiEditor.modules.dialogs.fn.resize );
							});
					}
					dialogDiv.bind( 'dialogclose', function() {
						context.fn.restoreSelection();
					} );
					// Add tabindexes to dialog form elements
					// Find the highest tabindex in use
					var maxTI = 0;
					$j( '[tabindex]' ).each( function() {
						var ti = parseInt( $j(this).attr( 'tabindex' ) );
						if ( ti > maxTI )
							maxTI = ti;
					});
					
					var tabIndex = maxTI + 1;
					$j( '.ui-dialog input, .ui-dialog button' )
						.not( '[tabindex]' )
						.each( function() {
							$j(this).attr( 'tabindex', tabIndex++ );
						});
				}
			}
		});
	},
	/**
	 * Resize a dialog so its contents fit
	 *
	 * Usage: dialog.each( resize ); or dialog.bind( 'blah', resize );
	 * NOTE: This function assumes $j.ui.dialog has already been loaded
	 */
	resize: function() {
		var wrapper = $(this).closest( '.ui-dialog' );
		var oldWidth = wrapper.width();
		// Make sure elements don't wrapped so we get an accurate idea of whether they really fit. Also temporarily show
		// hidden elements. Work around jQuery bug where <div style="display:inline;" /> inside a dialog is both
		// :visible and :hidden
		var oldHidden = $(this).find( '*' ).not( ':visible' );
		// Save the style attributes of the hidden elements to restore them later. Calling hide() after show() messes up
		// for elements hidden with a class
		oldHidden.each( function() {
			$(this).data( 'oldstyle', $(this).attr( 'style' ) );
		});
		oldHidden.show();
		var oldWS = $(this).css( 'white-space' );
		$(this).css( 'white-space', 'nowrap' );
		if ( wrapper.width() <= $(this).get(0).scrollWidth ) {
			var thisWidth = $(this).data( 'thisWidth' ) ? $(this).data( 'thisWidth' ) : 0;
			thisWidth = Math.max( $(this).get(0).scrollWidth, thisWidth );
			$(this).width( thisWidth );
			$(this).data( 'thisWidth', thisWidth );
			var wrapperWidth = $(this).data( 'wrapperWidth' ) ? $(this).data( 'wrapperWidth' ) : 0;
			wrapperWidth = Math.max( wrapper.get(0).scrollWidth, wrapperWidth );
			wrapper.width( wrapperWidth );
			$(this).data( 'wrapperWidth', wrapperWidth );
			$(this).dialog( { 'width': wrapper.width() } );
			wrapper.css( 'left', parseInt( wrapper.css( 'left' ) ) - ( wrapper.width() - oldWidth ) / 2 );
		}
		$(this).css( 'white-space', oldWS );
		oldHidden.each( function() {
			$(this).attr( 'style', $(this).data( 'oldstyle' ) );
		});		
	}
},
// This stuff is just hanging here, perhaps we could come up with a better home for this stuff
modules: {},
quickDialog: function( body, settings ) {
	$( '<div />' )
		.text( body )
		.appendTo( $( 'body' ) )
		.dialog( $.extend( {
			bgiframe: true,
			modal: true
		}, settings ) )
		.dialog( 'open' );
}

}; } ) ( jQuery );
