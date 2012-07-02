( function( $ ) { 

// These vars are hard coded for testing/development, but should be fetched from the PageTriage API
var	$currentArticle = 'Hello World';
var $testArticleId = 1;
	
$.pageTriage = {

	requestPage: function() {
		var sendData = {
			'action': 'pagetriage',
			'mode': 'checkout',
			'format': 'json',
			'id' : $testArticleId
		};

		$.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': sendData,
			'dataType': 'json',
			'type': 'GET',
			'success': function( data ) {
				var pageTitle = $currentArticle; // TODO: Get this from the API data instead
				$.pageTriage.loadPage( pageTitle );
			}
		} );
	},

	loadPage: function( pageTitle ) {
	
		// Get some info about the latest revision of the article
		var sendData = {
			'action': 'query',
			'prop': 'revisions',
			'titles': pageTitle,
			'rvlimit': 1,
			'rvprop': 'timestamp', // Add some other properties here as needed
			'format': 'json'
		};
		$.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': sendData,
			'dataType': 'json',
			'type': 'GET',
			'success': function( data ) {
				if ( !data || !data.query || !data.query.pages ) {
					// Show error
					return;
				}
				$.each( data.query.pages, function( id, page ) {
					if ( page.revisions[0].timestamp && page.revisions[0].timestamp.length ) {
						//$( '#ptr-stuff' ).append( page.revisions[0].timestamp );
					}
				});
			}
		} );
		
		// Load the article into the page
		$( '#ptr-stuff' ).load( 
			mw.config.get( 'wgServer' ) 
			+ mw.config.get( 'wgScriptPath' ) 
			+ '/index.php?title=' + encodeURIComponent( $currentArticle ) + '&action=render'
		);
		
	},
	
	tagPage: function() {
		var tagsToApply = new Array;
		$.each( $( '#ptr-checkboxes input:checkbox' ), function( index, value ) {
			if ( $( this ).is( ':checked' ) ) {
				// Add it to the list
			}
		} );
		
		// Build the new version of the article with tags added.
		
		var sendData = {
			'action': 'edit',
			'title': $currentArticle,
			'text' : $newText,
			'token': mw.user.tokens.get( 'editToken' ), // MW 1.18 and later
			'summary': 'Triaging the page',
			'notminor': true
		};

		$.ajax( {
			'url': mw.util.wikiScript( 'api' ),
			'data': sendData,
			'dataType': 'json',
			'type': 'POST',
			'success': function( data ) {
				// Record the triaging and start the process over again.
			}
		} );
	}
	
};

$( document ).ready( $.pageTriage.requestPage );
} ) ( jQuery );
