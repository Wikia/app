/* Publish module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.previewDialog = {

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
		var dialogID = 'wikiEditor-' + context.instance + '-preview-dialog';
		$.wikiEditor.modules.dialogs.fn.create(
			context,
			{
				preview: {
					id: dialogID,
					titleMsg: 'wikieditor-preview-tab',
					html: '\
						<div class="wikiEditor-ui-loading"><span></span></div>\
						<div class="wikiEditor-preview-dialog-contents"></div>\
					',
					init: function() {
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
								$( '#wpSummary' ).val( $( '#wikiEditor-' + context.instance +
									'-dialog-summary' ).val() );
								$( '#editform' ).submit();
							},
							'wikieditor-publish-dialog-goback': function() {
								$(this).dialog( 'close' );
							}
						},
						resizable: false,
						height: $( 'body' ).height() - 100,
						width: $( 'body' ).width() - 300,
						position: ['center', 'top'],
						open: function() {
							// Gets the latest copy of the wikitext
							var wikitext = context.fn.getContents();
							var $dialog = $( '#' + dialogID );
							$dialog
								.css( 'position', 'relative' )
								.css( 'height', $( 'body' ).height() - 200 )
								.parent()
								.css( 'top', '25px' );
							// $dialog.dialog( 'option', 'width', $( 'body' ).width() - 300 );
							// Aborts when nothing has changed since the last preview
							if ( context.modules.preview.previewText == wikitext ) {
								return;
							}

							$dialog.find( '.wikiEditor-preview-dialog-contents' ).empty();
							$dialog.find( '.wikiEditor-ui-loading' ).show();
							$.post(
								mw.util.wikiScript( 'api' ),
								{
									'action': 'parse',
									'title': mw.config.get( 'wgPageName' ),
									'text': wikitext,
									'prop': 'text',
									'pst': '',
									'format': 'json'
								},
								function( data ) {
									if (
										typeof data.parse == 'undefined' ||
										typeof data.parse.text == 'undefined' ||
										typeof data.parse.text['*'] == 'undefined'
									) {
										return;
									}
									context.modules.preview.previewText = wikitext;
									$dialog.find( '.wikiEditor-ui-loading' ).hide();
									$dialog.find( '.wikiEditor-preview-dialog-contents' )
										.html( '<h1 class="firstHeading" id="firstHeading">' +
											mw.config.get( 'wgTitle' ) + '</h1>' +
											data.parse.text['*'] )
										.find( 'a:not([href^=#])' ).click( function() { return false; } );
								},
								'json'
							);
						}
					},
					resizeme: false
				}
			}
		);
		context.fn.addButton( {
			'captionMsg': 'wikieditor-preview-tab',
			'action': function() {
				context.$textarea.wikiEditor( 'openDialog', 'preview');
				return false;
			}
		} );
	}
}

}; } )( jQuery );
