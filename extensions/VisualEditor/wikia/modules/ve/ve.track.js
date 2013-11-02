/*!
 * VisualEditor tracking for Wikia
 */

/* global require */

require( ['wikia.tracker'], function ( tracker ) {
	var actions = tracker.ACTIONS,
		upperToHyphenLower = ( function () {
			var rSpecialChars = /[A-Z]/g;

			function upperToHyphenLower( match ) {
				return '-' + match.toLowerCase();
			}

			return function ( str ) {
				return str.replace( rSpecialChars, upperToHyphenLower );
			};
		}() );

	ve.track.actions = actions;
	ve.trackRegisterHandler( function ( name, data ) {
		var params = {
			category: 'editor-ve',
			trackingMethod: 'ga'
		};

		// Handle MW tracking calls
		if ( typeof name === 'string' ) {
			switch( data.action ) {
				case 'edit-link-click':
					params.action = actions.CLICK;
					params.category = 'article';
					params.label = 've-edit';
					break;
				case 'page-edit-impression':
					params.action = actions.IMPRESSION;
					params.label = 'edit-page';
					break;
				case 'page-save-attempt':
					params.action = actions.CLICK;
					params.label = 'button-publish';
					break;
				case 'page-save-success':
					params.action = actions.SUCCESS;
					params.label = 'publish';
					break;
				case 'section-edit-link-click':
					params.action = actions.CLICK;
					params.category = 'article';
					params.label = 've-section-edit';
					break;
				default:
					// Don't track
					return;
			}
		} else {
			ve.extendObject( params, name );
		}

		// Normalize label values
		params.label = upperToHyphenLower( params.label );

		tracker.track( params );
	} );
} );
