/* JavaScript for SimpleSearch extension */

jQuery( document ).ready( function( $ ) {

	// Ensure that the thing is actually present!
	if ($('#simpleSearch').length == 0) {
		// Don't try to set anything up if simpleSearch is disabled sitewide.
		// The loader code loads us if the option is present, even if we're
		// not actually enabled (anymore).
		return;
	}

	// Compatibility map
	var map = {
		'browsers': {
			// Left-to-right languages
			'ltr': {
				// SimpleSearch is broken in Opera < 9.6
				'opera': [['>=', 9.6]],
				'docomo': false,
				'blackberry': false,
				'ipod': false,
				'iphone': false
			},
			// Right-to-left languages
			'rtl': {
				'opera': [['>=', 9.6]],
				'docomo': false,
				'blackberry': false,
				'ipod': false,
				'iphone': false
			}
		}
	};
	if ( !$.client.test( map ) ) {
		return true;
	}

	// Disable MWSuggest if loaded
	if ( window.os_MWSuggestDisable ) {
		window.os_MWSuggestDisable();
	}

	// Placeholder text for SimpleSearch box
	$( '#simpleSearch > input#searchInput' )
		.attr( 'placeholder', mw.msg( 'vector-simplesearch-search' ) )
		.placeholder();

	// General suggestions functionality for all search boxes
	$( '#searchInput, #searchInput2, #powerSearchText, #searchText' )
		.suggestions( {
			fetch: function( query ) {
				var $this = $(this);
				if ( query.length !== 0 ) {
					var request = $.ajax( {
						url: mw.util.wikiScript( 'api' ),
						data: {
							action: 'opensearch',
							search: query,
							namespace: 0,
							suggest: ''
						},
						dataType: 'json',
						success: function( data ) {
							if ( $.isArray( data ) && 1 in data ) {
								$this.suggestions( 'suggestions', data[1] );
							}
						}
					});
					$this.data( 'request', request );
				}
			},
			cancel: function() {
				var request = $(this).data( 'request' );
				// If the delay setting has caused the fetch to have not even happend yet, the request object will
				// have never been set
				if ( request && $.isFunction( request.abort ) ) {
					request.abort();
					$(this).removeData( 'request' );
				}
			},
			result: {
				select: function( $input ) {
					$input.closest( 'form' ).submit();
				}
			},
			delay: 120,
			positionFromLeft: $( 'body' ).hasClass( 'rtl' ),
			highlightInput: true
		} )
		.bind( 'paste cut drop', function( e ) {
			// make sure paste and cut events from the mouse and drag&drop events
			// trigger the keypress handler and cause the suggestions to update
			$( this ).trigger( 'keypress' );
		} );
	// Special suggestions functionality for skin-provided search box
	$( '#searchInput' ).suggestions( {
		result: {
			select: function( $input ) {
				$input.closest( 'form' ).submit();
			}
		},
		special: {
			render: function( query ) {
				if ( $(this).children().length === 0 ) {
					$(this).show();
					var $label = $( '<div></div>', {
							'class': 'special-label',
							text: mw.msg( 'vector-simplesearch-containing' )
						})
						.appendTo( $(this) );
					var $query = $( '<div></div>', {
							'class': 'special-query',
							text: query
						})
						.appendTo( $(this) );
					$query.autoEllipsis();
				} else {
					$(this).find( '.special-query' )
						.empty()
						.text( query )
						.autoEllipsis();
				}
			},
			select: function( $input ) {
				$input.closest( 'form' ).append(
					$( '<input>', {
						type: 'hidden',
						name: 'fulltext',
						val: '1'
					})
				);
				$input.closest( 'form' ).submit();
			}
		},
		$region: $( '#simpleSearch' )
	} );
});