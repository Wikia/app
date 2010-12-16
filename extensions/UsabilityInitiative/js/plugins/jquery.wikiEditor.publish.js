/* Publish module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.publish = {

/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 7]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 9.6]],
		'safari': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 9.6]],
		'safari': [['>=', 4]]
	}
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates a publish module within a wikiEditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Build the dialog behind the Publish button
		var dialogID = 'wikiEditor-' + context.instance + '-dialog';
		$.wikiEditor.modules.dialogs.fn.create(
			context,
			{
				previewsave: {
					id: dialogID,
					titleMsg: 'wikieditor-publish-dialog-title',
					html: '\
						<div class="wikiEditor-dialog-copywarn"></div>\
						<div class="wikiEditor-dialog-editoptions">\
							<form id="wikieditor-' + context.instance + '-publish-dialog-form">\
								<label for="wikiEditor-' + context.instance + '-dialog-summary"\
									rel="wikieditor-publish-dialog-summary"></label>\
								<br />\
								<input type="text" id="wikiEditor-' + context.instance + '-dialog-summary"\
									style="width: 100%;" />\
								<br />\
								<input type="checkbox"\
									id="wikiEditor-' + context.instance + '-dialog-minor" />\
								<label for="wikiEditor-' + context.instance + '-dialog-minor"\
									rel="wikieditor-publish-dialog-minor"></label>\
								<br />\
								<input type="checkbox"\
									id="wikiEditor-' + context.instance + '-dialog-watch" />\
								<label for="wikiEditor-' + context.instance + '-dialog-watch"\
									rel="wikieditor-publish-dialog-watch"></label>\
							</form>\
						</div>',
					init: function() {
						$(this).find( '[rel]' ).each( function() {
							$(this).text( mw.usability.getMsg( $(this).attr( 'rel' ) ) );
						});
						$(this).find( '.wikiEditor-dialog-copywarn' )
							.html( $( '#editpage-copywarn' ).html() );
						
						if ( $( '#wpMinoredit' ).size() == 0 )
							$( '#wikiEditor-' + context.instance + '-dialog-minor' ).hide();
						else if ( $( '#wpMinoredit' ).is( ':checked' ) )
							$( '#wikiEditor-' + context.instance + '-dialog-minor' )
								.attr( 'checked', 'checked' );
						if ( $( '#wpWatchthis' ).size() == 0 )
							$( '#wikiEditor-' + context.instance + '-dialog-watch' ).hide();
						else if ( $( '#wpWatchthis' ).is( ':checked' ) )
							$( '#wikiEditor-' + context.instance + '-dialog-watch' )
								.attr( 'checked', 'checked' );
						
						$(this).find( 'form' ).submit( function( e ) {
							$(this).closest( '.ui-dialog' ).find( 'button:first' ).click();
							e.preventDefault();
						});
					},
					dialog: {
						buttons: {
							'wikieditor-publish-dialog-publish': function() {
								var minorChecked = $( '#wikiEditor-' + context.instance +
									'-dialog-minor' ).is( ':checked' ) ?
										'checked' : '';
								var watchChecked = $( '#wikiEditor-' + context.instance +
									'-dialog-watch' ).is( ':checked' ) ?
										'checked' : '';
								$( '#wpMinoredit' ).attr( 'checked', minorChecked );
								$( '#wpWatchthis' ).attr( 'checked', watchChecked );
								$( '#wpSummary' ).val( $j( '#wikiEditor-' + context.instance +
									'-dialog-summary' ).val() );
								$( '#editform' ).submit();
							},
							'wikieditor-publish-dialog-goback': function() {
								$(this).dialog( 'close' );
							}
						},
						open: function() {
							$( '#wikiEditor-' + context.instance + '-dialog-summary' ).focus();
						},
						width: 500
					},
					resizeme: false
				}
			}
		);
		context.fn.addButton( {
			'captionMsg': 'wikieditor-publish-button-publish',
			'action': function() {
				$( '#' + dialogID ).dialog( 'open' );
				return false;
			}
		} );
		context.fn.addButton( {
			'captionMsg': 'wikieditor-publish-button-cancel',
			'action': function() { }
		} );
	}
}

}; } )( jQuery );
