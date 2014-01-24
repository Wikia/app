var EditorSurvey = {

	$survey: null,
	$wrapper: null,

	init: function() {
		if ( $.cookie( 'editorsurvey' ) && $.cookie( 'editorsurvey' ) !== 'seen' ) {
			$.nirvana.sendRequest( {
				format: 'html',
				controller: 'EditorSurvey',
				method: 'index',
				data: { 'type': $.cookies.get( 'editorsurvey' ) },
				callback: function( response, status, xhr ) {
					var ct = xhr.getResponseHeader( 'content-type' ) || '';
					if ( ct.indexOf( 'html' ) > -1 ) {
						// Modal
						$( response ).makeModal( { 'escapeToClose': false } );
						// Cache
						EditorSurvey.$survey = $( '.editor-survey' );
						EditorSurvey.$wrapper = EditorSurvey.$survey.closest( '.modalWrapper' );
						// Buttons
						EditorSurvey.$survey.find( '.secondary, .primary' ).on( 'click', function() {
							EditorSurvey.seen();
							EditorSurvey.closeModal();
						} );
						// Close button
						EditorSurvey.$wrapper.find( '.close' ).on( 'click', EditorSurvey.seen );
						// Blackout overlay
						EditorSurvey.$wrapper.next( '.blackout' ).on( 'click', EditorSurvey.seen );
					} else if ( ct.indexOf( 'json' ) > -1 ) {
						var json = JSON.parse( response );
						if ( json.wam ) {
							EditorSurvey.clear();
						}
					}
				}
			} );
		}
	},

	seen: function() {
		// Expire in 10 years
		$.cookie( 'editorsurvey', 'seen', { 'expires': 3650, 'domain': wgCookieDomain } );
	},

	closeModal: function() {
		EditorSurvey.$wrapper.closeModal();
	},

	clear: function() {
		$.cookie( 'editorsurvey', null );
	},

	set: function( value ) {
		var date = new Date();
		if ( !$.cookie( 'editorsurvey' ) || $.cookie( 'editorsurvey' ) !== 'seen' ) {
			// Expire in 2 days
			$.cookie( 'editorsurvey', value, { 'expires': 2, 'domain': wgCookieDomain } );
		}
	}
};

$( function() {
	EditorSurvey.init();
} );