/* Preview module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.preview = {

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
	 * Creates a preview module within a wikiEditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		if ( 'initialized' in context.modules.preview ) {
			return;
		}
		context.modules.preview = {
			'initialized': true,
			'previewText': null,
			'changesText': null
		};
		context.modules.preview.$preview = context.fn.addView( {
			'name': 'preview',
			'titleMsg': 'wikieditor-preview-tab',
			'init': function( context ) {
				// Gets the latest copy of the wikitext
				var wikitext = context.$textarea.textSelection( 'getContents' );
				// Aborts when nothing has changed since the last preview
				if ( context.modules.preview.previewText == wikitext ) {
					return;
				}
				context.modules.preview.$preview.find( '.wikiEditor-preview-contents' ).empty();
				context.modules.preview.$preview.find( '.wikiEditor-preview-loading' ).show();
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
						context.modules.preview.$preview.find( '.wikiEditor-preview-loading' ).hide();
						context.modules.preview.$preview.find( '.wikiEditor-preview-contents' )
							.html( data.parse.text['*'] )
							.find( 'a:not([href^=#])' ).click( function() { return false; } );
					},
					'json'
				);
			}
		} );

		context.$changesTab = context.fn.addView( {
			'name': 'changes',
			'titleMsg': 'wikieditor-preview-changes-tab',
			'init': function( context ) {
				// Gets the latest copy of the wikitext
				var wikitext = context.$textarea.textSelection( 'getContents' );
				// Aborts when nothing has changed since the last time
				if ( context.modules.preview.changesText == wikitext ) {
					return;
				}
				context.$changesTab.find( 'table.diff tbody' ).empty();
				context.$changesTab.find( '.wikiEditor-preview-loading' ).show();

				// Call the API. First PST the input, then diff it
				var postdata = {
					'action': 'parse',
					'onlypst': '',
					'text': wikitext,
					'format': 'json'
				};

				$.post( mw.util.wikiScript( 'api' ), postdata, function( data ) {
					try {
						var postdata2 = {
							'action': 'query',
							'indexpageids': '',
							'prop': 'revisions',
							'titles': mw.config.get( 'wgPageName' ),
							'rvdifftotext': data.parse.text['*'],
							'rvprop': '',
							'format': 'json'
						};
						var section = $( '[name=wpSection]' ).val();
						if ( section != '' )
							postdata2['rvsection'] = section;

						$.post( mw.util.wikiScript( 'api' ), postdata2, function( data ) {
								// Add diff CSS
								mw.loader.load( 'mediawiki.action.history.diff' );
								try {
									var diff = data.query.pages[data.query.pageids[0]]
										.revisions[0].diff['*'];
									context.$changesTab.find( 'table.diff tbody' )
										.html( diff );
									context.$changesTab
										.find( '.wikiEditor-preview-loading' ).hide();
									context.modules.preview.changesText = wikitext;
								} catch ( e ) { } // "blah is undefined" error, ignore
							}, 'json'
						);
					} catch( e ) { } // "blah is undefined" error, ignore
				}, 'json' );
			}
		} );

		var loadingMsg = mediaWiki.msg( 'wikieditor-preview-loading' );
		context.modules.preview.$preview
			.add( context.$changesTab )
			.append( $( '<div />' )
				.addClass( 'wikiEditor-preview-loading' )
				.append( $( '<img />' )
					.addClass( 'wikiEditor-preview-spinner' )
					.attr( {
						'src': $.wikiEditor.imgPath + 'dialogs/loading.gif',
						'valign': 'absmiddle',
						'alt': loadingMsg,
						'title': loadingMsg
					} )
				)
				.append(
					$( '<span></span>' ).text( loadingMsg )
				)
			)
			.append( $( '<div />' )
				.addClass( 'wikiEditor-preview-contents' )
			);
		context.$changesTab.find( '.wikiEditor-preview-contents' )
			.html( '<table class="diff"><col class="diff-marker" /><col class="diff-content" />' +
				'<col class="diff-marker" /><col class="diff-content" /><tbody /></table>' );
	}
}

}; } )( jQuery );
