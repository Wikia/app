( function( window, $ ) {
	if ( !window.wgEditorSurveyEnabled ) {
		return;
	}

	var EditorSurvey = {
		init: function() {
			mw.hook( 've.activationComplete' ).add( function() {
				EditorSurvey.bindUnload();
			} );
			mw.hook( 'postEdit' ).add( function() {
				EditorSurvey.handleSuccess();
			} );
			mw.hook( 've.deactivationComplete' ).add( function() {
				// Delayed because VE core code fires deactivation before postEdit. Also, it feels nicer.
				setTimeout( function() {
					EditorSurvey.getSurvey();
				}, 1000 );
			} );
			mw.hook( 've.cancelButton' ).add( function() {
				EditorSurvey.handleFailure();
			} );

			EditorSurvey.getSurvey();
		},

		getEditorAbbreviation: function() {
			var abbreviation;
			if ( window.WikiaEditor ) {
				abbreviation = 'ck';
			} else if ( window.ve ) {
				abbreviation = 've';
			}
			return abbreviation;
		}

		bindUnload: function() {
			$( window ).on( 'beforeunload.EditorSurvey', function() {
				EditorSurvey.handleFailure();
			} );
		},

		unbindUnload: function() {
			$( window ).off( 'beforeunload.EditorSurvey' );
		},

		handleSuccess: function() {
			EditorSurvey.unbindUnload();
			EditorSurvey.set( EditorSurvey.getEditorAbbreviation() + '-success' );
		},

		handleFailure: function() {
			EditorSurvey.set( EditorSurvey.getEditorAbbreviation() + '-fail' );
		},

		getSurvey: function() {
			var contentType, json,
				val = $.cookie( 'editorsurvey' );
			if ( val && val !== 'seen' ) {
				$.nirvana.sendRequest( {
					format: 'json',
					controller: 'EditorSurvey',
					method: 'index',
					data: { 'type': val },
					callback: function( response ) {
						var $modal;

						// Disable setting the fail cookie when the window is unloaded
						EditorSurvey.unbindUnload();

						// Don't display for wikis with WAM scores of 100 or lower
						if ( response.wam_rank <= 100 ) {
							// Since 've-fail' was set on editor activation, we need to clear
							// the cookie for these users so they don't immediately get a modal
							// when they go to another wiki with a higher WAM score.
							EditorSurvey.set( null );
							return;
						}

						// Show the survey modal and mark it as seen.
						$modal = $( response.html ).makeModal( {
							'escapeToClose': false,
							'onAfterClose': function() {
								EditorSurvey.set( 'seen' );
							}
						} );

						// Buttons
						$modal.on( 'click', '.primary, .secondary', function() {
							$modal.closeModal();
						} );
					}
				} );
			}
		},

		set: function( value ) {
			var options = { 'domain': wgCookieDomain };

			// Only set value if modal hasn't been seen.
			if ( $.cookie( 'editorsurvey' ) === 'seen' ) {
				return;
			}

			// If setting a value, set the expire time based on whether or not the user
			// has seen the survey modal (10 years if they have, 2 days otherwise).
			if ( value ) {
				options.expires = value === 'seen' ? 3650 : 2;
			}

			$.cookie( 'editorsurvey', value, options );
		}
	};

	$( EditorSurvey.init );

	// Exports
	window.EditorSurvey = EditorSurvey;

})( window, jQuery );
