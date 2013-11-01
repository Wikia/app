/*!
 * VisualEditor tracking for Wikia
 */

/* global require */

require( ['wikia.tracker'], function ( tracker ) {
	var actions = tracker.ACTIONS,
		keysToNormalize = [ 'category', 'label' ];

	// Normalize special parameter values
	function normalize( params ) {
		var i, key,
			rSpecialChars = /[_\s]/g;

		for ( i = 0; i < keysToNormalize.length; i++ ) {
			key = keysToNormalize[i];
			params[key] = params[key].toLowerCase().replace( rSpecialChars, '-' );
		}

		return params;
	}

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
					params.label = 'save';
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

		tracker.track( normalize( params ) );
	} );
} );
