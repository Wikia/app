var EditorSurvey = {

	$survey: null,
	$wrapper: null,
	veLoaded: false,

	init: function() {
		mw.hook( 've.activationComplete' ).add( function() {
			EditorSurvey.set( 've-fail' );
			EditorSurvey.veLoaded = true;
		} );
		mw.hook( 'postEdit' ).add( function() {
			// Only act on this hook if VE was first loaded
			if ( EditorSurvey.veLoaded ) {
				EditorSurvey.set( 've-success' );
			}
		} );
		mw.hook( 've.deactivationComplete' ).add( function() {
			EditorSurvey.veLoaded = false;
			// Delayed because VE core code fires deactivation before postEdit. Also, it feels nicer.
			setTimeout( EditorSurvey.getSurvey, 1000 );
		} );

		EditorSurvey.getSurvey();
	},

	getSurvey: function() {
		var contentType, json;
		if ( $.cookie( 'editorsurvey' ) && $.cookie( 'editorsurvey' ) !== 'seen' ) {
			$.nirvana.sendRequest( {
				format: 'html',
				controller: 'EditorSurvey',
				method: 'index',
				data: { 'type': $.cookies.get( 'editorsurvey' ) },
				callback: function( response, status, xhr ) {
					contentType = xhr.getResponseHeader( 'content-type' ) || '';
					if ( contentType.indexOf( 'html' ) > -1 ) {
						// Modal
						$( response ).makeModal( { 'escapeToClose': false } );
						// Cache
						EditorSurvey.$survey = $( '.editor-survey' );
						EditorSurvey.$wrapper = EditorSurvey.$survey.closest( '.modalWrapper' );
						// Buttons
						EditorSurvey.$survey.find( '.secondary, .primary' ).on( 'click', function() {
							EditorSurvey.set( 'seen' );
							EditorSurvey.closeModal();
						} );
						// Close button
						EditorSurvey.$wrapper.find( '.close' ).on( 'click', EditorSurvey.set( 'seen' ) );
						// Blackout overlay
						EditorSurvey.$wrapper.next( '.blackout' ).on( 'click', EditorSurvey.set( 'seen' ) );
					} else if ( contentType.indexOf( 'json' ) > -1 ) {
						json = JSON.parse( response );
						if ( json.wam ) {
							EditorSurvey.clear();
						}
					}
				}
			} );
		}
	},

	closeModal: function() {
		EditorSurvey.$wrapper.closeModal();
	},

	clear: function() {
		$.cookie( 'editorsurvey', null );
	},

	set: function( value ) {
		if ( value === 'seen' ) {
			// Expire in 10 years
			$.cookie( 'editorsurvey', 'seen', { 'expires': 3650, 'domain': wgCookieDomain } );
		} else if ( !$.cookie( 'editorsurvey' ) || $.cookie( 'editorsurvey' ) !== 'seen' ) {
			// Expire in 2 days
			$.cookie( 'editorsurvey', value, { 'expires': 2, 'domain': wgCookieDomain } );
		}
	}
};

$( function() {
	EditorSurvey.init();
} );
